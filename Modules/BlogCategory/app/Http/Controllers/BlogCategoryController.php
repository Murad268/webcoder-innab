<?php

namespace Modules\BlogCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\BlogCategory\Models\BlogCategory;
use Modules\BlogCategory\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
class BlogCategoryController extends Controller
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
        return view('blogcategory::index', compact('items', 'activeLangsCount', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        return view('blogcategory::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new BlogCategory(), $request);
            return redirect()->route('blogcategory.index')->with('status', 'Kateqoriya uğurla əlavə edildi');
        }, 'blogcategory.index');
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
    public function edit(Request $request, BlogCategory $blogcategory)
    {
        $languages = $this->langRepository->all_active();
        return view('blogcategory::edit', compact('blogcategory', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogcategory): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $blogcategory) {
            $this->crudService->update($blogcategory, $request);
            return redirect()->route('blogcategory.index')->with('status', 'Kateqoriya uğurla yeniləndi');
        }, 'blogcategory.index');
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
            $this->statusService->changeStatusTrue($model, new BlogCategory());
            return redirect()->route('blogcategory.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'blogcategory.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new BlogCategory());
            return redirect()->route('blogcategory.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'blogcategory.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'blogcategory.index', true);
    }
}
