<?php

namespace App\Services;

use App\Models\SystemFiles;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function handleImages($request, $fileField, $relation_id, $directory, $type, $model_type)
    {
        if ($request->hasFile($fileField)) {
            foreach ($request->file($fileField) as $image) {
                $extension = $image->getClientOriginalExtension();
                $uniqueName = uniqid();
                $imagePath = 'images/' . $directory . '/' . $uniqueName . '.' . $extension;

                $directoryPath = storage_path('app/public/images/' . $directory);
                if (!file_exists($directoryPath)) {
                    mkdir($directoryPath, 0755, true);
                }

                if ($extension == 'svg') {
                    // Directly move SVG files without resizing
                    $image->storeAs('public/images/' . $directory, $uniqueName . '.' . $extension);
                } else {
                    // Handle resizing for other image types
                    $tempPath = $image->storeAs('temp', $uniqueName . '.' . $extension, 'public');
                    $this->resizeImage(storage_path('app/public/' . $tempPath), storage_path('app/public/' . $imagePath));
                    Storage::disk('public')->delete($tempPath);
                }

                SystemFiles::create([
                    'url' => $imagePath,
                    'file_type' => $type,
                    'relation_id' => $relation_id,
                    'model_type' => $model_type
                ]);
            }
        }
    }

    private function resizeImage($sourcePath, $destinationPath)
    {
        $info = getimagesize($sourcePath);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($sourcePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($sourcePath);
                break;
            default:
                throw new \Exception('Unsupported image format.');
        }

        // Resize the image
        $resizedImage = $image;

        // Preserve transparency
        if ($mime == 'image/png' || $mime == 'image/gif') {
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
        }

        // Save the resized image
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                imagejpeg($resizedImage, $destinationPath);
                break;
            case 'image/png':
                imagepng($resizedImage, $destinationPath);
                break;
            case 'image/gif':
                imagegif($resizedImage, $destinationPath);
                break;
            case 'image/webp':
                imagewebp($resizedImage, $destinationPath);
                break;
        }

        imagedestroy($image);
        imagedestroy($resizedImage);
    }

    public function saveImage($request, $fileField, $relation_id, $directory, $type, $model_type) {
        if ($request->hasFile($fileField)) {
            foreach ($request->file($fileField) as $file) {
                $this->handleImages($request, $fileField, $relation_id, $directory, $type, $model_type);
            }
        }
    }


    public function deleteImage($id)
    {
        $images_model = new SystemFiles();

        // Find the image by ID
        $image = $images_model::findOrFail($id);

        // Delete the image file from storage
        Storage::disk('public')->delete($image->url);

        // Delete the image record from the database
        $image->delete();

        return ['success' => true];
    }
}
