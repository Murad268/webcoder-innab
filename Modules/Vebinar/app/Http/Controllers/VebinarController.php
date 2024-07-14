<?php

namespace Modules\Vebinar\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Vebinar\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Vebinar\Models\Vebinar;

class VebinarController extends Controller
{
    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public ImageService $imageService)
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
        return view('Vebinar::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        return view('Vebinar::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new Vebinar(), $request, 'Vebinar');
            return redirect()->route('Vebinar.index')->with('status', 'Vebinar uğurla əlavə edildi');
        }, 'Vebinar.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('Vebinar::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $languages = $this->langRepository->all_active();
            return view('Vebinar::edit', compact('languages', 'model'));
        }, 'Vebinar.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->crudService->update($model, $request, 'Vebinar');
            return redirect()->route('Vebinar.index')->with('status', 'Vebinar uğurla yeniləndi');
        }, 'Vebinar.index');
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
            $this->statusService->changeStatusTrue($model, new Vebinar());
            return redirect()->route('Vebinar.index')->with('status', 'Vebinar statusu uğurla yeniləndi');
        }, 'Vebinar.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new Vebinar());
            return redirect()->route('Vebinar.index')->with('status', 'Vebinar statusu uğurla yeniləndi');
        }, 'Vebinar.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'Vebinar.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->imageService->deleteImage($id);
            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'Vebinar.index', true);
    }
}
