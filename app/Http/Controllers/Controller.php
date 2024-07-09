<?php

namespace App\Http\Controllers;

use Modules\Lang\Repositories\ModelRepository as LangRepository;
abstract class Controller
{



    protected function executeSafely(callable $callback, $route = null, $ajax = null)
    {
        try {
            return $callback();
        } catch (\Exception $e) {
            if ($route) {
                return redirect()->route($route)->with(['error' => 'Bir xəta baş verdi: ' . $e->getMessage()]);
            }
            if($ajax) {
                return response()->json(['error' => 'Bir xəta baş verdi: ' . $e->getMessage()]);
            } else {
                return redirect()->route($route)->with(['error' => 'Bir xəta baş verdi: ' . $e->getMessage()]);
            }

        }
    }
}
