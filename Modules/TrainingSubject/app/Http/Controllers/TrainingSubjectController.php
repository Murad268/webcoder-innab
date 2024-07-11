<?php

namespace Modules\TrainingSubject\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\TrainingSubject\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\TrainingCategory\Models\TrainingCategory;
use Modules\Training\Repositories\ModelRepository as TrainingRepository;
use Modules\TrainingSubject\Models\TrainingSubject;

class TrainingSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public TrainingCategory $trainingCategory, public ImageService $imageService, public TrainingRepository $trainingRepository)
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
        return view('trainingsubject::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainings = $this->trainingRepository->all_active();
        $languages = $this->langRepository->all_active();
        return view('trainingsubject::create', compact('languages', 'trainings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new TrainingSubject(), $request, 'trainingSubject');
            return redirect()->route('trainingsubject.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'trainingsubject.index');
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('trainingsubject::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        return $this->executeSafely(function () use ($request, $id) {
            $trainingSubject = $this->repository->find($id);
            $languages = $this->langRepository->all_active();
            $trainings = $this->trainingRepository->all_active();
            return view('trainingsubject::edit', compact('trainingSubject', 'languages', 'trainings'));
        }, 'trainingsubject.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $trainingSubject = $this->repository->find($id);
            $this->crudService->update($trainingSubject, $request, 'trainingSubject');
            return redirect()->route('trainingsubject.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'trainingsubject.index');
    }

    /**
     * Remove the specified resource from storage.
     */



    public function changeStatusTrue($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusTrue($model, new TrainingSubject());
            return redirect()->route('trainingsubject.index')->with('status', 'Təlim statusu uğurla yeniləndi');
        }, 'trainingsubject.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new TrainingSubject());
            return redirect()->route('trainingsubject.index')->with('status', 'Təlim statusu uğurla yeniləndi');
        }, 'trainingsubject.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'trainingsubject.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->imageService->deleteImage($id);

            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'trainingsubject.index', true);
    }
}

