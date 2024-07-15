<?php

namespace Modules\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Training\Repositories\ModelRepository;
use Modules\Training\Models\Training;
use Modules\TrainingCategory\Repositories\ModelRepository as TrainingCategoryRepository;

class TrainingController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository,
        public TrainingCategoryRepository $trainingCategory
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
        return view('training::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->trainingCategory->all_active();
        $languages = $this->services->langRepository->all_active();
        return view('training::create', compact('languages', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Training(), $request, 'training');
            return redirect()->route('training.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'training.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('training::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Training $training)
    {
        return $this->executeSafely(function () use ($request, $training) {
            $languages = $this->services->langRepository->all_active();
            $categories = $this->trainingCategory->all_active();
            return view('training::edit', compact('training', 'languages', 'categories'));
        }, 'training.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Training $training): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $training) {
            $this->services->crudService->update($training, $request, 'training');
            return redirect()->route('training.index')->with('status', 'Təlim uğurla yeniləndi');
        }, 'training.index');
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
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusTrue($model, new Training());
            return redirect()->route('training.index')->with('status', 'Təlim statusu uğurla yeniləndi');
        }, 'training.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Training());
            return redirect()->route('training.index')->with('status', 'Təlim statusu uğurla yeniləndi');
        }, 'training.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "Məlumatlar uğurla silindilər"]);
        }, 'training.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->services->imageService->deleteImage($id);
            return redirect()->back()->with('success', 'Şəkil uğurla silindi');
        }, 'training.index', true);
    }
}
