<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Customer\Models\Customer;
use Modules\Customer\Repositories\ModelRepository;

class CustomerController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository
    ) {
    }

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

    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('customer::create', compact('languages'));
    }

    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Customer(), $request, 'customer');
            return redirect()->route('customer.index')->with('status', 'Tərəfdaş uğurla əlavə edildi');
        }, 'customer.index');
    }

    public function show($id)
    {
        return view('customer::show');
    }

    public function edit($id)
    {
        return $this->executeSafely(function () use ($id) {
            $customer = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('customer::edit', compact('languages', 'customer'));
        }, 'customer.index');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $id) {
            $customer = $this->repository->find($id);
            $this->services->crudService->update($customer, $request, 'customer');
            return redirect()->route('customer.index')->with('status', 'Təlim uğurla əlavə edildi');
        }, 'customer.index');
    }

    public function destroy($id)
    {
        // Burada destroy metodunu implement edə bilərsiniz
    }

    public function changeStatusTrue($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Customer(), true, 'customer.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Customer(), false, 'customer.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'customer.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'customer.index');
    }
}
