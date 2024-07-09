<?php

namespace Modules\Training\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RemoveService;
use App\Services\SimleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Training\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Training\Models\Training;
use Modules\TrainingCategory\Repositories\ModelRepository as TrainingCategory;
class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ModelRepository $repository, public SimleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public TrainingCategory $trainingCategory)
    {
    }
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
        $languages = $this->langRepository->all_active();
        return view('training::create', compact('languages', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new Training(), $request);
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
        $languages = $this->langRepository->all_active();
        $categories = $this->trainingCategory->all_active();
        return view('training::edit', compact('training', 'languages', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
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
            $this->statusService->changeStatusTrue($model, new Training());
            return redirect()->route('training.index')->with('status', 'Təlim statusu uğurla yeniləndi');
        }, 'training.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new Training());
            return redirect()->route('training.index')->with('status', 'Təlim statusu uğurla yeniləndi');
        }, 'training.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'training.index', true);
    }
}
