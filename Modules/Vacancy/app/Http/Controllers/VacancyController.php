<?php

namespace Modules\Vacancy\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Vacancy\Repositories\ModelRepository;
use Modules\Vacancy\Models\Vacancy;

class VacancyController extends Controller
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
        return view('vacancy::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('vacancy::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Vacancy(), $request, 'vacancy');
            return redirect()->route('vacancy.index')->with('status', 'vacancy uğurla əlavə edildi');
        }, 'vacancy.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('vacancy::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('vacancy::edit', compact('languages', 'model'));
        }, 'vacancy.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $model = $this->repository->find($id);
            $this->services->crudService->update($model, $request, 'vacancy');
            return redirect()->route('vacancy.index')->with('status', 'vacancy uğurla yeniləndi');
        }, 'vacancy.index');
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
            $this->services->statusService->changeStatusTrue($model, new Vacancy());
            return redirect()->route('vacancy.index')->with('status', 'vacancy statusu uğurla yeniləndi');
        }, 'vacancy.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Vacancy());
            return redirect()->route('vacancy.index')->with('status', 'vacancy statusu uğurla yeniləndi');
        }, 'vacancy.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'vacancy.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->services->imageService->deleteImage($id);
            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'vacancy.index', true);
    }
}
