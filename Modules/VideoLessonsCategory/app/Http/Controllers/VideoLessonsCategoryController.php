<?php

namespace Modules\VideoLessonsCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\VideoLessonsCategory\Models\VideoLessonsCategory;
use Modules\VideoLessonsCategory\Repositories\ModelRepository;

class VideoLessonsCategoryController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository
    ) {}

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
        $languages = $this->services->langRepository->all_active();
        return view('videolessonscategory::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new VideoLessonsCategory(), $request);
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
        $languages = $this->services->langRepository->all_active();
        return view('videolessonscategory::edit', compact('videolessonscategory', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoLessonsCategory $videolessonscategory): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $videolessonscategory) {
            $this->services->crudService->update($videolessonscategory, $request);
            return redirect()->route('videolessonscategory.index')->with('status', 'Kateqoriya uğurla yeniləndi');
        }, 'videolessonscategory.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Burada destroy metodunu implement edə bilərsiniz
    }

    public function changeStatusTrue($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new VideoLessonsCategory(), true, 'videolessonscategory.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new VideoLessonsCategory(), false, 'videolessonscategory.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'videolessonscategory.index');
    }
}
