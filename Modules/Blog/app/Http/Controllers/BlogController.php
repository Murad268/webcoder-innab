<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Modules\Blog\Models\Blog;
use Modules\Blog\Repositories\ModelRepository;
use Modules\BlogCategory\Repositories\ModelRepository as Category;
class BlogController extends Controller
{

    public function __construct(public ServiceContainer $services, public Category $category, public ModelRepository $repository)
    {

    }

    public function index(Request $request)
    {
        $q = $request->q;
        $activeItemsCount = $this->repository->all_active()->count();
        if ($q) {
            $items = $this->repository->search($q, 80);
        } else {
            $items = $this->repository->all(80);
        }

        return view('blog::index', compact('items', 'q', 'activeItemsCount'));
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
            return redirect()->route('blog.index')->with('status', 'Tərəfdaş uğurla əlavə edildi');
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
            return redirect()->route('blog.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'blog.index');
    }

    public function destroy($id)
    {
        // ...
    }

    public function changeStatusTrue($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusTrue($model, new Blog());
            return redirect()->route('blog.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'blog.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Blog());
            return redirect()->route('blog.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'blog.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'blog.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->services->imageService->deleteImage($id);
            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'blog.index', true);
    }
}
