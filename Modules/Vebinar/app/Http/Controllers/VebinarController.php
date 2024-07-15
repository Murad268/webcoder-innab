<?php

namespace Modules\Vebinar\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Vebinar\Repositories\ModelRepository;
use Modules\Vebinar\Models\Vebinar;

class VebinarController extends Controller
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
        $activeItemsCount = $this->repository->all_active()->count();
        if ($q) {
            $items = $this->repository->search($q, 80);
        } else {
            $items = $this->repository->all(80);
        }
        return view('vebinar::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('vebinar::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Vebinar(), $request, 'vebinar');
            return redirect()->route('vebinar.index')->with('status', 'Vebinar uğurla əlavə edildi');
        }, 'vebinar.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('vebinar::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->commonService->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('vebinar::edit', compact('languages', 'model'));
        }, 'vebinar.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->services->crudService->update($model, $request, 'vebinar');
            return redirect()->route('vebinar.index')->with('status', 'Vebinar uğurla yeniləndi');
        }, 'vebinar.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Vebinar(), true, 'vebinar.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Vebinar(), false, 'vebinar.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'vebinar.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'vebinar.index');
    }
}
