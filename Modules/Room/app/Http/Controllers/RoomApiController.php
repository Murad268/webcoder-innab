<?php

namespace Modules\Room\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Room\Repositories\ModelRepository;

class RoomApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }
    public function get_rooms(Request $request): JsonResponse
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
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
