<?php

namespace Modules\Lesson\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use App\Services\CommonService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Lesson\Repositories\ModelRepository;
use Modules\Lesson\Models\Lesson;
use Modules\VideoLessonsTitle\Repositories\ModelRepository as VideLessonsTitleRepository;

class LessonController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public CommonService $commonService,
        public ModelRepository $repository,
        public VideLessonsTitleRepository $videLessonsTitleRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $titles = $this->videLessonsTitleRepository->getAll();
        $result = $this->services->generalService->handleIndex($request, $this->repository, 80, 'title_id');

        return view('lesson::index', array_merge($result, [
            'titles' => $titles,
            'activeLangsCount' => $this->repository->all_active()->count(),
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titles = $this->videLessonsTitleRepository->all_active();
        $languages = $this->services->langRepository->all_active();
        return view('lesson::create', compact('languages', 'titles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request) {
            $this->services->crudService->create(new Lesson(), $request, 'lesson');
            return redirect()->route('lesson.index')->with('status', 'Dərs uğurla əlavə edildi');
        }, 'lesson.index');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('lesson::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Lesson $lesson)
    {
        $languages = $this->services->langRepository->all_active();
        $titles = $this->videLessonsTitleRepository->all_active();
        return view('lesson::edit', compact('lesson', 'languages', 'titles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson): RedirectResponse
    {
        return $this->commonService->executeSafely(function () use ($request, $lesson) {
            $this->services->crudService->update($lesson, $request, 'lesson');
            return redirect()->route('lesson.index')->with('status', 'Dərs uğurla yeniləndi');
        }, 'lesson.index');
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
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Lesson(), true, 'lesson.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->commonService->changeStatus($id, $this->repository, $this->services->statusService, new Lesson(), false, 'lesson.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->commonService->deleteSelectedItems($this->repository, $request, $this->services->removeService, 'lesson.index');
    }

    public function deleteFile($id)
    {
        return $this->commonService->deleteFile($id, $this->services->imageService, 'lesson.index');
    }
}
