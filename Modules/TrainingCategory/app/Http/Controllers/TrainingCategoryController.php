<?php

namespace Modules\TrainingCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RemoveService;
use App\Services\SimleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\TrainingCategory\Models\TrainingCategory;
use Modules\TrainingCategory\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
class TrainingCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ModelRepository $repository, public SimleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->q;
        if ($q) {
            $items = $this->repository->search($q);
        } else {
            $items = $this->repository->all();
        }
        $activeLangsCount = $this->repository->all()->count();
        return view('trainingcategory::index', compact('items', 'activeLangsCount', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        return view('trainingcategory::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new TrainingCategory(), $request);
            return redirect()->route('trainingcategory.index')->with('status', 'Dil uğurla əlavə edildi');
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
        $languages = $this->langRepository->all_active();
        return view('trainingcategory::edit', compact('trainingcategory', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingCategory $trainingcategory): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $trainingcategory) {
            $this->crudService->update($trainingcategory, $request);
            return redirect()->route('trainingcategory.index')->with('status', 'Dil uğurla yeniləndi');
        }, 'trainingcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }


    public function changeDefault($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->defaultService->changeDefault($model, new TrainingCategory());
            return redirect()->route('trainingcategory.index')->with('status', 'Dil uğurla əsas dil olaraq təyin edildi');
        }, 'trainingcategory.index');
    }



    public function changeStatusTrue($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusTrue($model, new TrainingCategory());
            return redirect()->route('trainingcategory.index')->with('status', 'Dilin statusu uğurla yeniləndi');
        }, 'trainingcategory.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new TrainingCategory());
            return redirect()->route('trainingcategory.index')->with('status', 'Dilin statusu uğurla yeniləndi');
        }, 'trainingcategory.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'trainingcategory.index', true);
    }
}
