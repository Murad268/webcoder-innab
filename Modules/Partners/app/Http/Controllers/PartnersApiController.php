<?php

namespace Modules\Partners\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Partners\Repositories\ModelRepository;

class PartnersApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }
    public function get_partners(Request $request): JsonResponse    {

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
                'image' => config('app.url') . '/' . $item->image['url'],
                'name' => $item->name,
                'short_description' => $item->short_description,
            ];
        });

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
