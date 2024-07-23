<?php

namespace Modules\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Training\Repositories\ModelRepository;

class TrainingApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_trainings(Request $request): JsonResponse
    {
        $category_id = $request->id;
        $items = $this->repository->getTrainingByCategoryWith('category_id',$category_id, ['image', 'file']);
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
                'file' => config('app.url') . '/' . $item->file['url'],
                'slug	' => $item->slug,
                'short_description' => $item->short_description,
                'top_text_title' => $item->top_text_title,
                'top_text' => $item->top_text,
                'bottom_text_title' => $item->bottom_text_title,
                'bottom_text' => $item->bottom_text,
                'seo_title' => $item->seo_title,
                'list' => $item->list,
                'seo_keywords' => $item->seo_keywords,
                'seo_description' => $item->seo_description,
                'seo_links' => $item->seo_links,
                'seo_scripts' => $item->seo_scripts,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
