<?php

namespace Modules\Corporative\Http\Controllers;

use App\Services\CommonService;
use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Corporative\Repositories\ModelRepository;
use Modules\Corporative\Models\Corporative;
use App\Traits\ExecuteSafely;

class CorporativeController extends Controller
{
    use ExecuteSafely;

    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository,
        public CommonService $commonService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languages = $this->services->langRepository->all_active();
        $model = $this->repository->find(1);
        return view('corporative::edit', compact('languages', 'model'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Corporative(), $request, 'corporative');
            return redirect()->route('corporative.index')->with('status', 'corporative uğurla əlavə edildi');
        }, 'corporative.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('corporative::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('corporative::edit', compact('languages', 'model'));
        }, 'corporative.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->services->crudService->update($model, $request, 'corporative');
            return redirect()->route('corporative.edit', $model->id)->with('status', 'corporative uğurla yeniləndi');
        }, 'corporative.edit', false, ['id' => $id]);
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
            $this->services->statusService->changeStatusTrue($model, new Corporative());
            return redirect()->route('corporative.index')->with('status', 'corporative statusu uğurla yeniləndi');
        }, 'corporative.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Corporative());
            return redirect()->route('corporative.index')->with('status', 'corporative statusu uğurla yeniləndi');
        }, 'corporative.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'corporative.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->services->imageService->deleteImage($id);
            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'corporative.index', true);
    }
}
