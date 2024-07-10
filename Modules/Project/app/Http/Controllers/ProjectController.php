<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Project\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Project\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public ImageService $imageService)
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
        return view('project::index', compact('items', 'q', 'activeItemsCount'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        return view('project::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
     
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new Project(), $request, 'project');
            return redirect()->route('project.index')->with('status', 'Layihə uğurla əlavə edildi');
        }, 'project.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('project::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {


        $languages = $this->langRepository->all_active();
        return view('project::edit', compact('project', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $partner = $this->repository->find($id);
            $this->crudService->update($partner, $request, 'project');
            return redirect()->route('project.index')->with('status', 'Layihə uğurla əlavə edildi');
        }, 'project.index');
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
            $this->statusService->changeStatusTrue($model, new Project());
            return redirect()->route('project.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'project.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new Project());
            return redirect()->route('project.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'project.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'project.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->imageService->deleteImage($id);

            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'project.index', true);
    }
}
