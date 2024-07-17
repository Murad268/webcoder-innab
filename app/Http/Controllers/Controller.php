<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ExecuteSafely;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
abstract class Controller
{
    use ExecuteSafely;
    protected function getPageAndQuery(Request $request): array
    {
        $page = $request->input('page', 1);
        $q = $request->input('q', '');
        return compact('page', 'q');
    }
}
