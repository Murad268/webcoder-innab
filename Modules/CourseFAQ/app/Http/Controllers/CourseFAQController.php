<?php

namespace Modules\CourseFAQ\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CourseFAQ\Models\CourseFaq;
use Modules\CourseFAQ\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Training\Repositories\ModelRepository as TrainingRepository;
class CourseFAQController extends Controller
{
    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public ImageService $imageService,public TrainingRepository $trainingRepository)
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
        return view('coursefaq::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $trainings = $this->trainingRepository->all_active();
        $languages = $this->langRepository->all_active();
        return view('coursefaq::create',  compact('languages', 'trainings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new CourseFaq(), $request, 'coursefaq');
            return redirect()->route('coursefaq.index')->with('status', 'Tərəfdaş uğurla əlavə edildi');
        }, 'coursefaq.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('coursefaq::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        return $this->executeSafely(function () use ($id) {
            $coursefaq = $this->repository->find($id);
            $languages = $this->langRepository->all_active();
            $trainings = $this->trainingRepository->all_active();
            return view('coursefaq::edit', compact('languages', 'coursefaq', 'trainings'));
        }, 'coursefaq.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {

        return $this->executeSafely(function () use ($request, $id) {
            $coursefaq = $this->repository->find($id);
            $this->crudService->update($coursefaq, $request, 'coursefaq');
            return redirect()->route('coursefaq.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'coursefaq.index');
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
            $this->statusService->changeStatusTrue($model, new CourseFaq());
            return redirect()->route('coursefaq.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'coursefaq.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new CourseFaq());
            return redirect()->route('coursefaq.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'coursefaq.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'coursefaq.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->imageService->deleteImage($id);

            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'coursefaq.index', true);
    }
}

