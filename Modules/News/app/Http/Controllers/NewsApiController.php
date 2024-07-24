<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\News\Repositories\ModelRepository;

class NewsApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_news(Request $request): JsonResponse
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
                'image' => $item->image ? config('app.url') . '/' . $item->image['url'] : null,
                'title' => $item->title,
                'page_title' => $item->page_title,
                'text' => $item->text,
                'slug' => $item->slug,
                'short_description' => $item->short_description,
                'seo_title' => $item->seo_title,
                'seo_keywords' => $item->seo_keywords,
                'seo_description' => $item->seo_description,
                'seo_links' => $item->seo_links,
                'seo_scripts' => $item->seo_scripts,
                'pined' => $item->pined,
                'pined_order' => $item->pined_order,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
