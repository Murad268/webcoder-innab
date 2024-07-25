<?php

namespace Modules\SiteInfo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\SiteInfo\Repositories\ModelRepository;

class SiteInfoApiController extends Controller
{
    public function __construct(private ModelRepository $repository)
    {
    }

    public function get_siteinfo(Request $request): JsonResponse
    {
        $item = $this->repository->findWith(1, ['header_footer', 'header_top']);



        if (!$item) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr =  [
        'header_top' => $item->header_top ? config('app.url') . '/' . $item->header_top['url'] : null,
        'header_footer' => $item->header_footer ? config('app.url') . '/' . $item->header_footer['url'] : null,
    ];

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
