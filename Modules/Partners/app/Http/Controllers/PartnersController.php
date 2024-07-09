<?php

namespace Modules\Partners\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Partners\Models\Partners;
use Modules\Partners\Repositories\ModelRepository;
use Modules\TrainingCategory\Repositories\ModelRepository as TrainingCategory;

class PartnersController extends Controller
{
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
        return view('partners::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        return view('partners::create',  compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new Partners(), $request, 'partner');
            return redirect()->route('partners.index')->with('status', 'Tərəfdaş uğurla əlavə edildi');
        }, 'partners.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('partners::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $partner = $this->repository->find($id);
            $languages = $this->langRepository->all_active();
            return view('partners::edit', compact('languages', 'partner'));
        }, 'partners.index');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $partner = $this->repository->find($id);
            $this->crudService->update($partner, $request, 'partner');
            return redirect()->route('partners.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'partners.index');
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
            $this->statusService->changeStatusTrue($model, new Partners());
            return redirect()->route('partners.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'partners.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new Partners());
            return redirect()->route('partners.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'partners.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'partners.index', true);
    }

    public function deleteFile($id) {
        return $this->executeSafely(function () use ($id) {
            $this->imageService->deleteImage($id);

            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'partners.index', true);
    }
}
