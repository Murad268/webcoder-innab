<?php

namespace Modules\Vacancy\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Vacancy\Repositories\ModelRepository;

class VacancyApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_vacancy(Request $request): JsonResponse
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
                'slug' => $item->slug,
                'vacancy_header_text' => $item->vacancy_header_text,
                'vacancy_footer_text' => $item->vacancy_footer_text,
                'obligations' => $item->obligations,
                'skills' => $item->skills,
                'seo_title' => $item->seo_title,
                'seo_keywords' => $item->seo_keywords,
                'seo_description' => $item->seo_description,
                'seo_links' => $item->seo_links,
                'seo_scripts' => $item->seo_scripts,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
