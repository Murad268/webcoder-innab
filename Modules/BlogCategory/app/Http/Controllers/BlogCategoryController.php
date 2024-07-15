<?php

namespace Modules\BlogCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\BlogCategory\Models\BlogCategory;
use Modules\BlogCategory\Repositories\ModelRepository;

class BlogCategoryController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository
    ) {}

    public function index(Request $request)
    {
        $q = $request->q;
        if ($q) {
            $items = $this->repository->search($q, 80);
        } else {
            $items = $this->repository->all(80);
        }
        $activeLangsCount = $this->repository->all_active()->count();
        return view('blogcategory::index', compact('items', 'activeLangsCount', 'q'));
    }

    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('blogcategory::create', compact('languages'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new BlogCategory(), $request);
            return redirect()->route('blogcategory.index')->with('status', 'Kateqoriya uğurla əlavə edildi');
        }, 'blogcategory.index');
    }

    public function show($id)
    {
        return view('lang::show');
    }

    public function edit(Request $request, BlogCategory $blogcategory)
    {
        $languages = $this->services->langRepository->all_active();
        return view('blogcategory::edit', compact('blogcategory', 'languages'));
    }

    public function update(Request $request, BlogCategory $blogcategory): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $blogcategory) {
            $this->services->crudService->update($blogcategory, $request);
            return redirect()->route('blogcategory.index')->with('status', 'Kateqoriya uğurla yeniləndi');
        }, 'blogcategory.index');
    }

    public function destroy($id)
    {
        // Burada destroy metodunu implement edə bilərsiniz
    }

    public function changeStatusTrue($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new BlogCategory(), true, 'blogcategory.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new BlogCategory(), false, 'blogcategory.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'blogcategory.index');
    }
}
