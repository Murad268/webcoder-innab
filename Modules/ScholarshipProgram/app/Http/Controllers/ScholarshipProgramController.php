<?php

namespace Modules\ScholarshipProgram\Http\Controllers;
use App\Services\CommonService;
use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\ScholarshipProgram\Repositories\ModelRepository;
use Modules\ScholarshipProgram\Models\ScholarshipProgram;

class ScholarshipProgramController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository,
        public CommonService $commonService
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
        return view('scholarshipprogram::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('scholarshipprogram::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new ScholarshipProgram(), $request, 'scholarshipprogram');
            return redirect()->route('scholarshipprogram.index')->with('status', 'scholarshipprogram uğurla əlavə edildi');
        }, 'scholarshipprogram.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('scholarshipprogram::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('scholarshipprogram::edit', compact('languages', 'model'));
        }, 'scholarshipprogram.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->services->crudService->update($model, $request, 'scholarshipprogram');
            return redirect()->route('scholarshipprogram.index')->with('status', 'scholarshipprogram uğurla yeniləndi');
        }, 'scholarshipprogram.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }


    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new ScholarshipProgram(), false, 'blog.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'blog.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'blog.index');
    }
}
