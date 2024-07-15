<?php

namespace App\Services;

use App\Traits\ExecuteSafely;

class CommonService
{
    use ExecuteSafely;

    public function deleteSelectedItems($repository, $request, $removeService, $route)
    {
        return $this->executeSafely(function () use ($repository, $request, $removeService) {
            $models = $repository->findWhereInGet($request->ids);
            $removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "Məlumatlar uğurla silindilər"]);
        }, $route, true);
    }

    public function deleteFile($id, $imageService, $route)
    {
        return $this->executeSafely(function () use ($id, $imageService) {
            $imageService->deleteImage($id);
            return redirect()->back()->with('success', 'Şəkil uğurla silindi');
        }, $route, true);
    }

    public function changeStatus($id, $repository, $statusService, $model, $status, $route)
    {
        return $this->executeSafely(function () use ($id, $repository, $statusService, $model, $status, $route) {
            $modelInstance = $repository->find($id);
            if ($status) {
                $statusService->changeStatusTrue($modelInstance, $model);
            } else {
                $statusService->changeStatusFalse($modelInstance, $model);
            }
            return redirect()->route($route)->with('status', 'Status uğurla yeniləndi');
        }, $route);
    }
}
