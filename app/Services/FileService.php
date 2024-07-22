<?php

namespace App\Services;

use App\Models\SystemFiles;
use Illuminate\Support\Facades\Storage;

class FileService
{
    public function handleFiles($file, $relation_id, $directory, $type, $model_type)
    {
        $extension = $file->getClientOriginalExtension();
        $uniqueName = uniqid();
        $filePath = 'files/' . $directory . '/' . $uniqueName . '.' . $extension;

        $directoryPath = storage_path('app/public/files/' . $directory);
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }

        // Store the file
        $file->storeAs('public/files/' . $directory, $uniqueName . '.' . $extension);

        // Save file information to the database
        SystemFiles::create([
            'url' => 'storage/'.$filePath,
            'file_type' => $type,
            'relation_id' => $relation_id,
            'model_type' => $model_type
        ]);
    }

    public function saveFiles($request, $fileField, $relation_id, $directory, $type, $model_type)
    {
        if ($request->hasFile($fileField)) {
            $files = $request->file($fileField);

            if (!is_array($files)) {
                $files = [$files];
            }

            foreach ($files as $file) {
                $this->handleFiles($file, $relation_id, $directory, $type, $model_type);
            }
        }
    }

    public function deleteFiles($model)
    {
        $files = $model->files;
        foreach ($files as $file) {
            Storage::disk('public')->delete($file->url);
            $file->delete();
        }
    }
}
