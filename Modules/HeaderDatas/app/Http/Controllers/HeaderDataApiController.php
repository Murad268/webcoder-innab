<?php

namespace Modules\HeaderDatas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\HeaderDatas\Repositories\ModelRepository;

class HeaderDataApiController extends Controller
{
    public function __construct(public ModelRepository $repository)
    {

    }
    public function get_headerdatas() {
        $items = $this->repository->all_activeWith(['image']);
        return response()->json(['success' => true, 'data' => $items]);
    }
}
