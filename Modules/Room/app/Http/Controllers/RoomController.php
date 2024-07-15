<?php

namespace Modules\Room\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Room\Repositories\ModelRepository;
use Modules\Room\Models\Room;

class RoomController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
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
        return view('room::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('room::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Room(), $request, 'room');
            return redirect()->route('room.index')->with('status', 'Otaq uğurla əlavə edildi');
        }, 'room.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('room::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $languages = $this->services->langRepository->all_active();
        return view('room::edit', compact('room', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $room) {
            $this->services->crudService->update($room, $request, 'room');
            return redirect()->route('room.index')->with('status', 'Otaq uğurla yeniləndi');
        }, 'room.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Room(), true, 'room.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Room(), false, 'room.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'room.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'room.index');
    }
}
