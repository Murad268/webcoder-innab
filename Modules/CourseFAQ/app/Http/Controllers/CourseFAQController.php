<?php

namespace Modules\CourseFAQ\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\CourseFAQ\Models\CourseFaq;
use Modules\CourseFAQ\Repositories\ModelRepository;
use Modules\Training\Repositories\ModelRepository as TrainingRepository;

class CourseFAQController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository,
        public TrainingRepository $trainingRepository
    ) {}

    public function index(Request $request)
    {
        $trainings = $this->trainingRepository->getAll();
        $selectedTrainings = $request->trainings;
        $q = $request->q;
        $activeItemsCount = $this->repository->all_active()->count();
        if ($q) {
            $items = $this->repository->search($q, 80);
        } else {
            $items = $this->repository->all(80);
        }
        if($selectedTrainings) {
            $items = $this->repository->findWhereInGetPaginate($selectedTrainings, 80, 'course_id');
        } else {
            $selectedTrainings = [];
        }
        return view('coursefaq::index', compact('items', 'q', 'activeItemsCount', 'trainings', 'selectedTrainings'));
    }

    public function create()
    {
        $trainings = $this->trainingRepository->all_active();
        $languages = $this->services->langRepository->all_active();
        return view('coursefaq::create', compact('languages', 'trainings'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new CourseFaq(), $request, 'coursefaq');
            return redirect()->route('coursefaq.index')->with('status', 'FAQ uğurla əlavə edildi');
        }, 'coursefaq.index');
    }

    public function show($id)
    {
        return view('coursefaq::show');
    }

    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $coursefaq = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            $trainings = $this->trainingRepository->all_active();
            return view('coursefaq::edit', compact('languages', 'coursefaq', 'trainings'));
        }, 'coursefaq.index');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $coursefaq = $this->repository->find($id);
            $this->services->crudService->update($coursefaq, $request, 'coursefaq');
            return redirect()->route('coursefaq.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'coursefaq.index');
    }

    public function destroy($id)
    {
        // Burada destroy metodunu implement edə bilərsiniz
    }

    public function changeStatusTrue($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new CourseFaq(), true, 'coursefaq.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new CourseFaq(), false, 'coursefaq.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'coursefaq.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'coursefaq.index');
    }
}
