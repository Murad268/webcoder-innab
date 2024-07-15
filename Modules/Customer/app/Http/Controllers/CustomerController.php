<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Customer\Models\Customer;
use Modules\Customer\Repositories\ModelRepository;

class CustomerController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository
    ) {
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
        return view('customer::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('customer::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Customer(), $request, 'customer');
            return redirect()->route('customer.index')->with('status', 'Tərəfdaş uğurla əlavə edildi');
        }, 'customer.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('customer::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $customer = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('customer::edit', compact('languages', 'customer'));
        }, 'customer.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $customer = $this->repository->find($id);
            $this->services->crudService->update($customer, $request, 'customer');
            return redirect()->route('customer.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'customer.index');
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
            $this->services->statusService->changeStatusTrue($model, new Customer());
            return redirect()->route('customer.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'customer.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Customer());
            return redirect()->route('customer.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'customer.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'customer.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->services->imageService->deleteImage($id);
            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'customer.index', true);
    }
}
