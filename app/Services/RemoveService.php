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
            $this->imageService->deleteImages($model);
            $this->fileService->deleteFiles($model);
        }

    }
}
