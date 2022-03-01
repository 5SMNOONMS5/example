<?php

namespace Stephenchen\Core\Http\Backend\File;

use Illuminate\Http\File;
use Illuminate\Http\FileHelpers;

/**
 * 擴充原本的 File 即可，不需要在自己重新造輪子
 * @OA\Schema(
 *     description="File 物件",
 *     @OA\Xml(
 *         name="FileObject"
 *     )
 * )
 */
final class FileObject extends File
{
    use FileHelpers;

    /**
     * @var string
     */
    private string $relativePath;

    /**
     * @var string
     */
    private string $fileURL;

    /**
     * FileObject constructor.
     *
     * @param string $path
     * @param        $relativePath
     * @param        $fileURL
     */
    public function __construct(string $path, $relativePath, $fileURL)
    {
        parent::__construct($path, TRUE);
        $this->fileURL      = $fileURL;
        $this->relativePath = $relativePath;
    }

    /**
     * @return string
     */
    public function getRelativePath(): string
    {
        return $this->relativePath;
    }

    /**
     * @param string $relativePath
     */
    public function setRelativePath(string $relativePath): void
    {
        $this->relativePath = $relativePath;
    }

    /**
     * @return string
     */
    public function getHashName(): string
    {
        return $this->hashName;
    }

    /**
     * @param string $hashName
     */
    public function setHashName(string $hashName): void
    {
        $this->hashName = $hashName;
    }

    /**
     * @return string
     */
    public function getFileURL(): string
    {
        return $this->fileURL;
    }

    /**
     * @param string $fileURL
     */
    public function setFileURL(string $fileURL): void
    {
        $this->fileURL = $fileURL;
    }


    /**
     * Run the database seeds.
     *
     * @return array
     */
    public function toArray(): array
    {
        $path         = $this->getFileURL();
        $relativePath = $this->getRelativePath();
        $prefix       = explode($relativePath, $path)[ 0 ] ?? '';

        return [
            'suffix'    => $relativePath,
            'prefix'    => $prefix,
            'filename'  => $this->getFilename(),
            'full_path' => $this->getFileURL(),
        ];
    }
}
