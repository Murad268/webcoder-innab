<?php

namespace Modules\Project\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Project\Repositories\ModelRepository;
use Modules\Project\Models\Project;

class ProjectController extends Controller
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
        $languages = $this->services->langRepository->all_active();
        return view('project::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Project(), $request, 'project');
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
        $languages = $this->services->langRepository->all_active();
        return view('project::edit', compact('project', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $project) {
            $this->services->crudService->update($project, $request, 'project');
            return redirect()->route('project.index')->with('status', 'Layihə uğurla yeniləndi');
        }, 'project.index');
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
            $this->services->statusService->changeStatusTrue($model, new Project());
            return redirect()->route('project.index')->with('status', 'Layihə statusu uğurla yeniləndi');
        }, 'project.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Project());
            return redirect()->route('project.index')->with('status', 'Layihə statusu uğurla yeniləndi');
        }, 'project.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "Məlumatlar uğurla silindilər"]);
        }, 'project.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->services->imageService->deleteImage($id);
            return redirect()->back()->with('success', 'Şəkil uğurla silindi');
        }, 'project.index', true);
    }
}
