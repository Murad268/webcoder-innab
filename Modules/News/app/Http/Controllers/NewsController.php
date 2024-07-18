<?php

namespace Modules\News\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\News\Repositories\ModelRepository;
use Modules\News\Models\News;

class NewsController extends Controller
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
        return view('news::index', compact('items', 'q', 'activeItemsCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $languages = $this->services->langRepository->all_active();
        return view('news::create', compact('languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new News(), $request, 'news');
            return redirect()->route('news.index')->with('status', 'Xəbər uğurla əlavə edildi');
        }, 'news.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('news::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return $this->commonService->executeSafely(function () use ($id) {
            $news = $this->repository->find($id);
            $languages = $this->services->langRepository->all_active();
            return view('news::edit', compact('languages', 'news'));
        }, 'news.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $id) {
            $news = $this->repository->find($id);
            $this->services->crudService->update($news, $request, 'news');
            return redirect()->route('news.index')->with('status', 'Xəbər uğurla yeniləndi');
        }, 'news.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new News(), true, 'news.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new News(), false, 'news.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'news.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'news.index');
    }
    public function pin(Request $request)
    {
        $id = $request->id;
        $item = $this->repository->find($id);

        if ($item) {
            $item->update(['pinned' => true]);
            return response()->json(['data' => $id, 'message' => 'Uğurla pinləndi.']);
        } else {
            return response()->json(['message' => 'Tapılmadı!'], 404);
        }
    }

    public function unpin(Request $request) {
        $id = $request->id;
        $item = $this->repository->find($id);

        if ($item) {
            $item->update(['pinned' => false]);
            return response()->json(['data' => $id, 'message' => 'Uğurla pindən çıxarıldı.']);
        } else {
            return response()->json(['message' => 'Tapılmadı!'], 404);
        }
    }

}
