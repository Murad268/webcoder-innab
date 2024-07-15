<?php

namespace Modules\Lang\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Lang\Models\Lang;
use Modules\Lang\Repositories\ModelRepository;

class LangController extends Controller
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
        if ($q) {
            $items = $this->repository->search($q, 80);
        } else {
            $items = $this->repository->all(80);
        }
        $activeLangsCount = $this->repository->all_active()->count();
        return view('lang::index', compact('items', 'activeLangsCount', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lang::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Lang(), $request);
            return redirect()->route('lang.index')->with('status', 'Dil uğurla əlavə edildi');
        }, 'lang.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('lang::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Lang $lang)
    {
        return view('lang::edit', compact('lang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lang $lang): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $lang) {
            $this->services->crudService->update($lang, $request);
            return redirect()->route('lang.index')->with('status', 'Dil uğurla yeniləndi');
        }, 'lang.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Burada destroy metodunu implement edə bilərsiniz
    }

    public function changeDefault($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->defaultService->changeDefault($model, new Lang());
            return redirect()->route('lang.index')->with('status', 'Dil uğurla əsas dil olaraq təyin edildi');
        }, 'lang.index');
    }

    public function changeStatusTrue($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusTrue($model, new Lang());
            return redirect()->route('lang.index')->with('status', 'Dilin statusu uğurla yeniləndi');
        }, 'lang.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Lang());
            return redirect()->route('lang.index')->with('status', 'Dilin statusu uğurla yeniləndi');
        }, 'lang.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'lang.index', true);
    }
}
