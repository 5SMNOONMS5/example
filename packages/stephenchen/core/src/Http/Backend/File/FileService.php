<?php

namespace Stephenchen\Core\Http\Backend\File;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * Handle all file upload, resize logic include images, pdf.....etc.
 */
final class FileService
{
    /**
     * Upload file and return storage path
     *
     * @param UploadedFile $file
     * @return FileObject|null
     * @throws Exception
     */
    public function upload(UploadedFile $file): ?FileObject
    {
        if (!$this->hasMalicious($file)) {
            throw new Exception('此圖片存在惡意程式碼');
        }

        // 默認的 filesystems driver 是 storage,
        // 檔案在 config/filesystems.php 底下
        // cf. https://laravel.com/docs/8.x/filesystem
        $disk = request()->get('disk') ?? 'storage';
        // 留著擴充用
        $directory = NULL;
        // File contents
        $contents = file_get_contents($file->getRealPath());
        // 如果有特別指定儲存路徑路徑，沒有就使用系統產生的
        $relativePath = request()->get('desired_store_path') ?? $this->getSystemFilePath($file, $directory);

        $isSuccess = $this->store($disk, $relativePath, $contents);
        $fullPath  = $this->getFileFullPath($disk, $relativePath);
        $fileURL   = $this->getFileURL($disk, $relativePath);

//        dd([
//            'disk'         => $disk,
//            'fullPath'     => $fullPath,
//            'fileURL'      => $fileURL,
//            'directory'    => $directory,
//            'relativePath' => $relativePath,
//        ]);

        if ($fullPath && $isSuccess) {
            return new FileObject($fullPath, $relativePath, $fileURL);
        } else {
            throw new FileNotFoundException($file->path());
        }
    }

    /**
     * Laravel build in Storage:Link will locate under public folder
     *
     * @param UploadedFile $file
     *
     * @return bool
     */
    private function hasMalicious(UploadedFile $file): bool
    {
        // TODO： 16进制文件检查，防止图片恶意代码
        return TRUE;
    }

    /**
     * Get file path combine with directory and uniqid file name
     *
     * 檔案相對路徑邏輯，不管任何 drivers
     * 默認會使用 uploads/$directory/aaaa.xxxx 這種邏輯
     * ( 主要是怕重複檔名，所以使用 uniqid() )
     *      檔案名稱 => uploads/$directory/原檔名-uniqid().原檔後綴
     *
     * @param UploadedFile $file
     * @param string|null  $directory
     *
     * @return string
     */
    private function getSystemFilePath(UploadedFile $file, string $directory = NULL): string
    {
        // File extension, Ex: .png、.jpg、.pdf ....etc.
        $extension = $file->getClientOriginalExtension();
        // Ex: sample.png
        $originalName = $file->getClientOriginalName();
        $metadata     = explode('.', $originalName);
        $fileName     = $metadata[ 0 ] ?? NULL;
        $uniqid       = uniqid();

        // 如果沒有拿到檔名就用 uniqid 替代，然後後面固定加上 hms 日期格式
        $fileName = $fileName ? "{$fileName}-{$uniqid}" : "{$uniqid}";
        // 如果沒有客製化的路徑，那默認路徑使用 Ymd
        $directory = !is_null($directory) ? trim($directory) : date('Ymd');
        return "uploads/{$directory}/{$fileName}.{$extension}";
    }

    /**
     * Put content into storage, if given $path conflict, Storage facade will replace with new one
     *
     * @param $disk
     * @param $path
     * @param $content
     *
     * @return bool
     */
    public function store(string $disk, string $path, $content): bool
    {
        return Storage::disk($disk)->put($path, $content);
    }

    /**
     * 拿到檔案完整路徑 （ 非相對 ）
     *
     * @param string $disk
     * @param string $relativePath
     *
     * @return string
     */
    private function getFileFullPath(string $disk, string $relativePath): ?string
    {
        $root = config("filesystems.disks.{$disk}.root");
        if (!$root) {
            return NULL;
        }
        return "{$root}/{$relativePath}";
    }

    /**
     * 拿到檔案網址路徑
     *
     * @param string $disk
     * @param string $relativePath
     *
     * @return string
     */
    private function getFileURL(string $disk, string $relativePath): ?string
    {
        $url = config("filesystems.disks.{$disk}.url");
        if (!$url) {
            return NULL;
        }
        return "{$url}/{$relativePath}";
    }

    /**
     * Remove file via given path
     *
     * @param $disk
     * @param $path
     *
     * @return bool
     */
    public function remove(string $path, string $disk = 'local'): bool
    {
        if ($disk == 'local') {
            $path = $this->getStorageLinkPath($path);
        }
        return Storage::disk($disk)->delete($path);
    }

    /**
     * Laravel build in Storage:Link will locate under public folder
     *
     * @param $path
     *
     * @return string
     */
    private function getStorageLinkPath($path): string
    {
        return '/public/' . $path;
    }

    /**
     * 拿到所有的檔案，只允許 '.jpeg', '.png', '.jpg', '.pdf'
     */
    public function index()
    {
        $allowExtensions = ['.jpeg', '.png', '.jpg', '.pdf'];
        $storage         = Storage::disk('storage');
        $files           = $storage->allFiles();

//        $notAllowExtensions = ['.', '..', '.DS_Store', '.gitignore'];
//        $rootPath        = storage_path('app/public');
//        $folderStructure = DirectoryToTree::directoryToArray($rootPath, $notAllowExtensions);
//
//        return $folderStructure;

        return collect($files)
            ->filter(function ($element) use ($allowExtensions) {

                // 如果是在 archives 底下的資料夾，不會被顯示
                $firstPath = explode('/', $element)[ 0 ] ?? NULL;
                if (strtolower($firstPath) == 'archives') {
                    return FALSE;
                }

                // 只允許 $allowExtensions 裡面的副檔名，其餘一律隱藏
                foreach ($allowExtensions as $extension) {
                    if (strpos($element, $extension)) {
                        return TRUE;
                    }
                }
                return FALSE;
            })
            ->map(function ($element) use ($storage) {
//                echo $element;
                return [
                    // $path 會透過 config/filesystems.php 中拿到，而那邊的參數又取決於 env 的 APP_URL 參數
                    'path' => $storage->url($element),
                    'size' => $storage->size($element),
//                    'last_modified' => $storage->lastModified($element),
                ];
            })
            ->values()
            ->all();
    }
}
