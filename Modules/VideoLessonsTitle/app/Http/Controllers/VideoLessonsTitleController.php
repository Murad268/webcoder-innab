<?php

namespace Modules\VideoLessonsTitle\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\VideoLessonsTitle\Repositories\ModelRepository;
use Modules\VideoLessonsTitle\Models\VideoLessonsTitle;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\VideoLessons\Repositories\ModelRepository as VideLessonsRepository;
class VideoLessonsTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public VideLessonsRepository $videLessonsRepository)
    {
    }
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
        return view('videolessonstitle::index', compact('items', 'activeLangsCount', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = $this->videLessonsRepository->all_active();
        $languages = $this->langRepository->all_active();
        return view('videolessonstitle::create', compact('languages', 'lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new videolessonstitle(), $request, 'image');
            return redirect()->route('videolessonstitle.index')->with('status', 'Kateqoriya uğurla əlavə edildi');
        }, 'videolessonstitle.index');
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
    public function edit(Request $request, VideoLessonsTitle $videolessonstitle)
    {
        $languages = $this->langRepository->all_active();
        $lessons = $this->videLessonsRepository->all_active();
        return view('videolessonstitle::edit', compact('videolessonstitle', 'languages', 'lessons', 'videolessonstitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoLessonsTitle $videolessonstitle): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $videolessonstitle) {
            $this->crudService->update($videolessonstitle, $request, 'image');
            return redirect()->route('videolessonstitle.index')->with('status', 'Kateqoriya uğurla yeniləndi');
        }, 'videolessonstitle.index');
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
            $this->statusService->changeStatusTrue($model, new VideoLessonsTitle());
            return redirect()->route('videolessonstitle.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'videolessonstitle.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new VideoLessonsTitle());
            return redirect()->route('videolessonstitle.index')->with('status', 'Kateqoriya statusu uğurla yeniləndi');
        }, 'videolessonstitle.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'videolessonstitle.index', true);
    }
}
