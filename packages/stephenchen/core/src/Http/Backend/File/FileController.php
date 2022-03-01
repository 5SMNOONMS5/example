<?php

namespace Stephenchen\Core\Http\Backend\File;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Stephenchen\Core\Base\BaseController;

final class FileController extends BaseController
{
    /**
     * Create a new FileService instance.
     *
     * @return void
     */
    protected FileService $fileService;

    /**
     * Create a new PermissionController instance.
     *
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * 新增檔案，只支援 jpeg,png,jpg,pdf,ico 格式，最大 2 m
     * @OA\Post(
     *     path="/files/upload",
     *     tags={"File"},
     *     security={
     *          {
     *              "bearerAuth": {}
     *          },
     *     },
     *     @OA\RequestBody(
     *         description="上傳檔案",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="file",
     *                     description="檔案",
     *                     type="string",
     *                     format="binary",
     *                 ),
     *                 required={"file"}
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="回傳格式解析",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="suffix",
     *                         type="integer",
     *                         description="檔案完整的 後綴路徑"
     *                     ),
     *                     @OA\Property(
     *                         property="prefix",
     *                         type="string",
     *                         description="檔案完整的 前綴路徑"
     *                     ),
     *                     @OA\Property(
     *                         property="filename",
     *                         type="string",
     *                         description="檔案名稱"
     *                     ),
     *                     @OA\Property(
     *                         property="full_path",
     *                         type="string",
     *                         description="檔案完整路徑"
     *                     ),
     *                     example={
     *                          "suffix": "uploads/20220301/sample-621d87bde24f8.png",
     *                          "prefix": "http://example-app.test/storage/",
     *                          "filename": "sample-621d87bde24f8.png",
     *                          "full_path": "http://example-app.test/storage/uploads/20220301/sample-621d87bde24f8.png"
     *                     }
     *                 )
     *             )
     *         }
     *     ),
     * )
     *
     * @param FileRequest $request
     * @return Response
     */
    public function upload(FileRequest $request)
    {
        try {

            $file    = collect($request->file())->first();
            $results = $this->fileService->upload($file)->toArray();

            return $this->jsonSuccess(trans('core::global.success'), $results);

        } catch (FileNotFoundException $e) {
//            Log::error('使用者上傳圖片失敗', $e->getMessage());
            return $this->jsonFail($e->getMessage());

        } catch (Exception $e) {
            return $this->jsonFail($e->getMessage());
        }
    }
}
