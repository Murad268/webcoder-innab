<?php

namespace Modules\Menu\Http\Controllers;

use App\Services\CommonService;
use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Menu\Repositories\ModelRepository;
use Modules\Menu\Models\Menu;

class MenuController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository,
        public CommonService $commonService
    ) {
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
            $items = $this->repository->getAllPaginate(80);
        }
        return view('menu::index', compact('items', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->executeSafely(function () {
            $items = $this->repository->all_active();
            $languages = $this->services->langRepository->all_active();
            return view('menu::create', compact('languages', 'items'));
        }, 'menu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        return $this->executeSafely(function () use ($request) {

            $this->services->crudService->create(new Menu(), $request, 'menu');
            return redirect()->route('menu.index')->with('status', 'menu uğurla əlavə edildi');
        }, 'menu.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('menu::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        return $this->executeSafely(function () use ($id) {
            $items = $this->repository->all_active();
            $model = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('menu::edit', compact('languages', 'model', 'items'));
        }, 'menu.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->services->crudService->update($model, $request, 'menu');
            return redirect()->route('menu.index')->with('status', 'menu uğurla yeniləndi');
        }, 'menu.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new ScholarshipProgram(), true, 'menu.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new ScholarshipProgram(), false, 'menu.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'menu.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'menu.index');
    }
}
