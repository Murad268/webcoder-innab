<?php

namespace Modules\About\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\About\Repositories\ModelRepository;

class AboutApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_about(Request $request): JsonResponse
    {
        $items = $this->repository->all_activeWith(['image', 'icon']);
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
                'icon' => $item->icon ? config('app.url') . '/' . $item->icon['url'] : null,
                'date' => $item->date,
                'description' => $item->description
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
