<?php

namespace Modules\HeaderDatas\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\HeaderDatas\Repositories\ModelRepository;

class HeaderDataApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_headerdatas(Request $request): JsonResponse
    {
        $items = $this->repository->all_activeWith(['image']);
        $lang = $request->locale;

        if ($lang) {
            app()->setLocale($lang);
        }

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr = $items->map(function ($item) {
            return [
                'icon' => config('app.url') . '/' . $item->image['url'],
                'text' => $item->sub_text,
                'count' => (int) $item->center_text,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
