<?php

namespace Modules\Translate\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Translate\Repositories\ModelRepository;

class TranslateApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_translate(Request $request): JsonResponse
    {
        $group = $request->group;
        $keyword = $request->keyword;
        $item = $this->repository->getTranslate($group, $keyword);
        $lang = $request->locale;

        if ($lang) {
            app()->setLocale($lang);
        }

        if ($item) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr = [
            'value' => $item->value
        ];
        return response()->json(['success' => true, 'data' => $arr]);
    }
}
