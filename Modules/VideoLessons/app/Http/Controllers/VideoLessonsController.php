<?php

namespace Modules\VideoLessons\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\VideoLessons\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\VideoLessons\Models\VideoLessons;
use Modules\VideoLessonsCategory\Repositories\ModelRepository as Category;

class VideoLessonsController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository,
        public LangRepository $langRepository,
        public Category $category
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->q;
        $activeItemsCount = $this->repository->all_active()->count();
        if ($q) {
            $items = $this->repository->search($q, 80);
        } else {
            $items = $this->repository->all(80);
        }
        return view('videolessons::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        $categories = $this->category->all_active();
        return view('videolessons::create', compact('languages', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new VideoLessons(), $request, 'videolesson');
            return redirect()->route('videolessons.index')->with('status', 'Tərəfdaş uğurla əlavə edildi');
        }, 'videolessons.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('videolessons::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->commonService->executeSafely(function () use ($id) {
            $categories = $this->category->all_active();
            $videolesson = $this->repository->find($id);
            $languages = $this->langRepository->all_active();
            return view('videolessons::edit', compact('languages', 'videolesson', 'categories'));
        }, 'videolessons.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $id) {
            $partner = $this->repository->find($id);
            $this->services->crudService->update($partner, $request, 'videolesson');
            return redirect()->route('videolessons.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'videolessons.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new VideoLessons(), true, 'videolessons.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new VideoLessons(), false, 'videolessons.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'videolessons.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'videolessons.index');
    }
}
