<?php

namespace Modules\Room\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ImageService;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Room\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Room\Models\Room;

class RoomController extends Controller
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
        return view('room::index', compact('items', 'q', 'activeItemsCount'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->langRepository->all_active();
        return view('room::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new Room(), $request, 'project');
            return redirect()->route('room.index')->with('status', 'Layihə uğurla əlavə edildi');
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


        $languages = $this->langRepository->all_active();
        return view('room::edit', compact('room', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $room) {
            $this->crudService->update($room, $request, 'project');
            return redirect()->route('room.index')->with('status', 'Layihə uğurla əlavə edildi');
        }, 'room.index');
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
            $this->statusService->changeStatusTrue($model, new Room());
            return redirect()->route('room.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'room.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new Room());
            return redirect()->route('room.index')->with('status', 'Tərəfdaş statusu uğurla yeniləndi');
        }, 'room.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'room.index', true);
    }

    public function deleteFile($id)
    {
        return $this->executeSafely(function () use ($id) {
            $this->imageService->deleteImage($id);

            return redirect()->back()->with('success', 'şəkil uğurla silindi');
        }, 'room.index', true);
    }
}
