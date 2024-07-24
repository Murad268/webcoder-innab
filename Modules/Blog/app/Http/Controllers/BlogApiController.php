<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Blog\Repositories\ModelRepository;

class BlogApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_blog(Request $request): JsonResponse
    {
        $category_id = $request->id;
        $items = $this->repository->getTrainingByCategoryWith('category_id', $category_id, ['image']);
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
                'title' => $item->title ,
                'slug' => $item->slug,
                'short_description' => $item->short_description,
                'seo_title' => $item->seo_title,
                'seo_keywords' => $item->seo_keywords,
                'seo_description' => $item->seo_description,
                'seo_links' => $item->seo_links,
                'seo_scripts' => $item->seo_scripts
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
