<?php

namespace App\Services;

use App\Traits\ExecuteSafely;

class PinService
{
    public function __construct(public ImageService $imageService, public FileService  $fileService)
    {
    }
    public function pin($item)
    {
        if ($item) {
            $item->update(['pinned' => true]);
            return response()->json(['message' => 'Uğurla pinləndi.']);
        } else {
            return response()->json(['message' => 'Tapılmadı!'], 404);
        }
    }

    public function unpin($item)
    {
        if ($item) {
            $item->update(['pinned' => false]);
            return response()->json(['message' => 'Uğurla pindən çıxarıldı.']);
        } else {
            return response()->json(['message' => 'Tapılmadı!'], 404);
        }
    }
}
