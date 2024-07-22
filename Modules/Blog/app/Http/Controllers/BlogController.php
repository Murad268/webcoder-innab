<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\Blog\Models\Blog;
use Modules\Blog\Repositories\ModelRepository;
use Modules\BlogCategory\Repositories\ModelRepository as Category;

class BlogController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public Category $category,
        public ModelRepository $repository
    ) {}


    public function index(Request $request)
    {
        $categories = $this->category->getAll();
        $result = $this->services->generalService->handleIndex($request, $this->repository, 80, 'category_id');

        return view('blog::index', array_merge($result, [
            'categories' => $categories,
            'activeItemsCount' => $this->repository->all_active()->count(),
        ]));
    }


    public function create()
    {
        $categories = $this->category->all_active();
        $languages = $this->services->langRepository->all_active();
        return view('blog::create', compact('languages', 'categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Blog(), $request, 'blog');
            return redirect()->route('blog.index')->with('status', 'Bloq uğurla əlavə edildi');
        }, 'blog.index');
    }

    public function show($id)
    {
        return view('blog::show');
    }

    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $categories = $this->category->all_active();
            $blog = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('blog::edit', compact('languages', 'blog', 'categories'));
        }, 'blog.index');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $partner = $this->repository->find($id);
            $this->services->crudService->update($partner, $request, 'blog');
            return redirect()->route('blog.index')->with('status', 'Bloq uğurla əlavə edildi');
        }, 'blog.index');
    }

    public function destroy($id)
    {
        // ...
    }

    public function changeStatusTrue($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Blog(), true, 'blog.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Blog(), false, 'blog.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'blog.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'blog.index');
    }
}
