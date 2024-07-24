<?php

namespace Modules\VideoLessonsTitle\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\VideoLessonsTitle\Repositories\ModelRepository;
use Modules\VideoLessonsTitle\Models\VideoLessonsTitle;
use Modules\VideoLessons\Repositories\ModelRepository as VideoLessonsRepository;

class VideoLessonsTitleController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository,
        public VideoLessonsRepository $videoLessonsRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $videoLessons = $this->videoLessonsRepository->getAll();
        $result = $this->services->generalService->handleIndex($request, $this->repository, 80, 'lesson_id');

        return view('videolessonstitle::index', array_merge($result, [
            'videoLessons' => $videoLessons,
            'activeLangsCount' => $this->repository->all_active()->count(),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $lessons = $this->videoLessonsRepository->all_active();
        $languages = $this->services->langRepository->all_active();
        return view('videolessonstitle::create', compact('languages', 'lessons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new VideoLessonsTitle(), $request, 'image');
            return redirect()->route('videolessonstitle.index')->with('status', 'Başlıq uğurla əlavə edildi');
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
        $languages = $this->services->langRepository->all_active();
        $lessons = $this->videoLessonsRepository->all_active();
        return view('videolessonstitle::edit', compact('videolessonstitle', 'languages', 'lessons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoLessonsTitle $videolessonstitle): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $videolessonstitle) {
            $this->services->crudService->update($videolessonstitle, $request, 'image');
            return redirect()->route('videolessonstitle.index')->with('status', 'Başlıq uğurla yeniləndi');
        }, 'videolessonstitle.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new VideoLessonsTitle(), true, 'videolessonstitle.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new VideoLessonsTitle(), false, 'videolessonstitle.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'videolessonstitle.index');
    }
}
