<?php

namespace Modules\TrainingSubject\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\TrainingSubject\Repositories\ModelRepository;
use Modules\TrainingSubject\Models\TrainingSubject;
use Modules\Training\Repositories\ModelRepository as TrainingRepository;

class TrainingSubjectController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository,
        public TrainingRepository $trainingRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $trainings = $this->trainingRepository->getAll();
        $result = $this->services->generalService->handleIndex($request, $this->repository, 80, 'training_id');

        return view('trainingsubject::index', array_merge($result, [
            'trainings' => $trainings,
            'activeItemsCount' => $this->repository->all_active()->count(),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainings = $this->trainingRepository->all_active();
        $languages = $this->services->langRepository->all_active();
        return view('trainingsubject::create', compact('languages', 'trainings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new TrainingSubject(), $request, 'trainingSubject');
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
        return $this->commonService->executeSafely(function () use ($request, $id) {
            $trainingSubject = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            $trainings = $this->trainingRepository->all_active();
            return view('trainingsubject::edit', compact('trainingSubject', 'languages', 'trainings'));
        }, 'trainingsubject.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $id) {
            $trainingSubject = $this->repository->find($id);
            $this->services->crudService->update($trainingSubject, $request, 'trainingSubject');
            return redirect()->route('trainingsubject.index')->with('status', 'Təlim uğurla yeniləndi');
        }, 'trainingsubject.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new TrainingSubject(), true, 'trainingsubject.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new TrainingSubject(), false, 'trainingsubject.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'trainingsubject.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'trainingsubject.index');
    }
}
