<?php

namespace Modules\VideoLessonsTitle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\VideoLessonsTitle\Repositories\ModelRepository;

class VideoLessonsTitleApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_videolessonstitle(Request $request): JsonResponse
    {
        $lesson_id = $request->id;
        $items = $this->repository->getTrainingByCategoryWith('lesson_id', $lesson_id);
        $lang = $request->locale;

        if ($lang) {
            app()->setLocale($lang);
        }

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr = $items->map(function ($item) {
            return [
                'title' => $item->title ,
                'slug' => $item->slug,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
