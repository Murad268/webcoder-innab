<?php

namespace App\Services;

class RemoveService
{
    public function __construct(public ImageService $imageService, public FileService  $fileService)
    {

    }
    public function removeAll($models) {
        foreach ($models as $model) {
            $model->delete();
            if($model->images) {
                $this->imageService->deleteImages($model);
            }
            if($model->files) {
                $this->fileService->deleteFiles($model);
            }
        }

    }
}
