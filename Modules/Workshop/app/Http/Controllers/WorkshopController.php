<?php

namespace Modules\Workshop\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Workshop\Repositories\ModelRepository;
use Modules\Workshop\Models\Workshop;

class WorkshopController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository,
        public CommonService $commonService
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
        return view('workshop::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('workshop::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Workshop(), $request, 'workshop');
            return redirect()->route('workshop.index')->with('status', 'Workshop uğurla əlavə edildi');
        }, 'workshop.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('workshop::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->commonService->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('workshop::edit', compact('languages', 'model'));
        }, 'workshop.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->services->crudService->update($model, $request, 'workshop');
            return redirect()->route('workshop.index')->with('status', 'Workshop uğurla yeniləndi');
        }, 'workshop.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Workshop(), true, 'workshop.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Workshop(), false, 'workshop.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'workshop.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'workshop.index');
    }
}
