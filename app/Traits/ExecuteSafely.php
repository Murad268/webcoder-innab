<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;

trait ExecuteSafely
{
    public function executeSafely(callable $callback, $route = null, $ajax = null)
    {
        try {
            return $callback();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($ajax) {
                return response()->json(['error' => 'Bir xəta baş verdi: ' . $e->getMessage()]);
            } else {
                return redirect()->route($route)->with(['error' => 'Bir xəta baş verdi: ' . $e->getMessage()]);
            }
        }
    }
}
