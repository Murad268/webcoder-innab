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
        $item = $this->repository->findWith(1, ['header_footer', 'header_top', 'header_image']);



        if (!$item) {
            return response()->json(['success' => false, 'message' => 'No data found'], 404);
        }

        $arr =  [
            'header_top' => $item->header_top ? config('app.url') . '/' . $item->header_top['url'] : null,
            'header_footer' => $item->header_footer ? config('app.url') . '/' . $item->header_footer['url'] : null,
            'header_image' => $item->header_image ? config('app.url') . '/' . $item->header_image['url'] : null,
            'instagram_link' => $item->instagram_link,
            'linkedin_link' => $item->linkedin_link,
            'twitter_link' => $item->twitter_link,
            'youtube_link' => $item->youtube_link,
            'phone1' => $item->phone1,
            'phone2' => $item->phone2,
            'email1' => $item->email1,
            'email2' => $item->email2,
            'address' => $item->address,
            'map' => $item->map
        ];

        return response()->json(['success' => true, 'data' => $arr]);
    }
}
