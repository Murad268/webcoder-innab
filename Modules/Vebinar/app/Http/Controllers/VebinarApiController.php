<?php

namespace Modules\Vebinar\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Vebinar\Repositories\ModelRepository;

class VebinarApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_vebinar(Request $request): JsonResponse
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
                'slug' => $item->slug,
                'spikers' => array_map('trim', explode(',', $item->spikers)),
                'event_datetime' => $item->event_datetime,
                'place' => $item->place
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
