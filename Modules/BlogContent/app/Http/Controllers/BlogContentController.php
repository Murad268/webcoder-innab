<?php

namespace Modules\BlogContent\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\BlogContent\Models\BlogContent as ModelsBlogContent;
use Modules\BlogContent\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Blog\Repositories\ModelRepository as Blog;
class BlogContentController extends Controller
{
    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public ImageService $imageService, public Blog $blog)
    {
    }
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
        return view('blogcontent::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogs = $this->blog->all_active();
        $languages = $this->langRepository->all_active();
        return view('blogcontent::create',  compact('languages', 'blogs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new ModelsBlogContent(), $request, 'blogcontent');
            return redirect()->route('blogcontent.index')->with('status', 'Kontent uğurla əlavə edildi');
        }, 'blogcontent.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('blogcontent::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $blogs = $this->blog->all_active();
            $blogcontent = $this->repository->find($id);
            $languages = $this->langRepository->all_active();
            return view('blogcontent::edit', compact('languages', 'blogcontent', 'blogs'));
        }, 'blogcontent.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $partner = $this->repository->find($id);
            $this->crudService->update($partner, $request, 'blogcontent');
            return redirect()->route('blogcontent.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'blogcontent.index');
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
            $this->statusService->changeStatusTrue($model, new ModelsBlogContent());
            return redirect()->route('blogcontent.index')->with('status', 'Kontent statusu uğurla yeniləndi');
        }, 'blogcontent.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new ModelsBlogContent());
            return redirect()->route('blogcontent.index')->with('status', 'Kontent statusu uğurla yeniləndi');
        }, 'blogcontent.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'blogcontent.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->imageService->deleteImage($id);

            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'blogcontent.index', true);
    }
}
