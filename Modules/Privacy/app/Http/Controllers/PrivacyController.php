<?php

namespace Modules\Privacy\Http\Controllers;
use App\Services\CommonService;
use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Privacy\Repositories\ModelRepository;
use Modules\Privacy\Models\Privacy;

class PrivacyController extends Controller
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

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('privacy::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Privacy(), $request, 'privacy');
            return redirect()->route('privacy.index')->with('status', 'privacy uğurla əlavə edildi');
        }, 'privacy.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('privacy::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('privacy::edit', compact('languages', 'model'));
        }, 'privacy.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->services->crudService->update($model, $request, 'privacy');
            return redirect()->route('privacy.edit', $model->id)->with('status', 'privacy uğurla yeniləndi');
        }, 'privacy.edit', false, ['id' => $id]);
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
