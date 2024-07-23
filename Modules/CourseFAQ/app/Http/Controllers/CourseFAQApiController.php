<?php

namespace Modules\CourseFAQ\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CourseFAQ\Repositories\ModelRepository;

class CourseFAQApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_faq(Request $request): JsonResponse
    {

        $course_id = $request->id;

        $items = $this->repository->getTrainingByCategoryWith('course_id', $course_id);
        $lang = $request->locale;

        if ($lang) {
            app()->setLocale($lang);
        }

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr = $items->map(function ($item) {
            return [
                'question' => $item->question,
                'answer' => $item->question,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
