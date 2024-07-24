<?php

namespace Modules\BlogContent\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\BlogContent\Repositories\ModelRepository;

class BlogContentApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_blogcontent(Request $request): JsonResponse
    {
        $items = $this->repository->all_activeWith();
        $lang = $request->locale;

        if ($lang) {
            app()->setLocale($lang);
        }

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr = $items->map(function ($item) {
            return [
                'title' => $item->title,
                'slug' => $item->slug,
                'text' => $item->text
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
