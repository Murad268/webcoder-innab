<?php

namespace Modules\Corporative\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Corporative\Repositories\ModelRepository;

class CorporativeApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_corporative(Request $request): JsonResponse
    {
        $item = $this->repository->find(1, ['image', 'banner']);

        $lang = $request->locale;

        if ($lang) {
            app()->setLocale($lang);
        }

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $data = [
            'image' => $item->image ? config('app.url') . '/' . $item->image['url'] : null,
            'banner' => $item->banner ? config('app.url') . '/' . $item->banner['url'] : null,
            'banner_title' => $item->banner_title,
            'banner_description' => $item->banner_description,
            'content_title' => $item->content_title,
            'content_top_text' => $item->content_top_text,
            'content_text' => $item->content_text,
        ];

        return response()->json(['success' => true, 'data' => $data]);
    }
}
