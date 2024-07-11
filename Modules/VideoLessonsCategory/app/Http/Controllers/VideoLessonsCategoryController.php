<?php

namespace Modules\VideoLessonsCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\VideoLessonsCategory\Models\VideoLessonsCategory;
use Modules\VideoLessonsCategory\Repositories\ModelRepository;
class VideoLessonsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->q;
        if ($q) {
            $items = $this->repository->search($q, 80);
        } else {
            $items = $this->repository->all(80);
        }
        $activeLangsCount = $this->repository->all_active()->count();
        return view('videolessonscategory::index', compact('items', 'activeLangsCount', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        return view('videolessonscategory::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new VideoLessonsCategory(), $request);
            return redirect()->route('videolessonscategory.index')->with('status', 'Kateqoriya uğurla əlavə edildi');
        }, 'videolessonscategory.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {

        return view('lang::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, VideoLessonsCategory $videolessonscategory)
    {
        $languages = $this->langRepository->all_active();
        return view('videolessonscategory::edit', compact('videolessonscategory', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoLessonsCategory $videolessonscategory): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $videolessonscategory) {
            $this->crudService->update($videolessonscategory, $request);
            return redirect()->route('videolessonscategory.index')->with('status', 'Kateqoriya uğurla yeniləndi');
        }, 'videolessonscategory.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }



    public function changeStatusTrue($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusTrue($model, new VideoLessonsCategory());
            return redirect()->route('videolessonscategory.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'videolessonscategory.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new VideoLessonsCategory());
            return redirect()->route('videolessonscategory.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'videolessonscategory.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'videolessonscategory.index', true);
    }
}

