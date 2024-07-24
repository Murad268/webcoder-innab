<?php

namespace Modules\Privacy\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Privacy\Repositories\ModelRepository;

class PrivacyApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_privacy(Request $request): JsonResponse
    {
        $item = $this->repository->find(1);
        $lang = $request->locale;

        if ($lang) {
            app()->setLocale($lang);
        }

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr = [
            'page_title' => $item->page_title,
            'text' => $item->text,
        ];

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
