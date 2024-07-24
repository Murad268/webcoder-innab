<?php

namespace Modules\BlogCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\BlogCategory\Repositories\ModelRepository;

class BlogCategoryApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_blogcategory(Request $request): JsonResponse
    {
        $items = $this->repository->all_activeWith([]);
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
                'seo_title' => $item->seo_title,
                'seo_keywords' => $item->seo_keywords,
                'seo_description' => $item->seo_description,
                'seo_links' => $item->seo_links,
                'seo_scripts' => $item->seo_scripts,
                'slug' => $item->slug,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
