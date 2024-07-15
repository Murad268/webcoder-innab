<?php

namespace Modules\TrainingCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\TrainingCategory\Models\TrainingCategory;
use Modules\TrainingCategory\Repositories\ModelRepository;

class TrainingCategoryController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository
    ) {}

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
        $activeLangsCount = $this->repository->all()->count();
        return view('trainingcategory::index', compact('items', 'activeLangsCount', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('trainingcategory::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new TrainingCategory(), $request);
            return redirect()->route('trainingcategory.index')->with('status', 'Kateqoriya uğurla əlavə edildi');
        }, 'trainingcategory.index');
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
    public function edit(Request $request, TrainingCategory $trainingcategory)
    {
        $languages = $this->services->langRepository->all_active();
        return view('trainingcategory::edit', compact('trainingcategory', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingCategory $trainingcategory): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $trainingcategory) {
            $this->services->crudService->update($trainingcategory, $request);
            return redirect()->route('trainingcategory.index')->with('status', 'Kateqoriya uğurla yeniləndi');
        }, 'trainingcategory.index');
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
            $this->services->statusService->changeStatusTrue($model, new TrainingCategory());
            return redirect()->route('trainingcategory.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'trainingcategory.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new TrainingCategory());
            return redirect()->route('trainingcategory.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'trainingcategory.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "Məlumatlar uğurla silindilər"]);
        }, 'trainingcategory.index', true);
    }
}
