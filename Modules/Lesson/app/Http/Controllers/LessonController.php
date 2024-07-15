<?php

namespace Modules\Lesson\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ServiceContainer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Lesson\Repositories\ModelRepository;
use Modules\Lesson\Models\Lesson;
use Modules\VideoLessonsTitle\Repositories\ModelRepository as VideLessonsTitleRepository;

class LessonController extends Controller
{
    public function __construct(
        public ServiceContainer $services,
        public ModelRepository $repository,
        public VideLessonsTitleRepository $videLessonsTitleRepository
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
        return view('lesson::index', compact('items', 'activeLangsCount', 'q'));
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
        return $this->executeSafely(function () use ($request) {
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
        return $this->executeSafely(function () use ($request, $lesson) {
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
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusTrue($model, new Lesson());
            return redirect()->route('lesson.index')->with('status', 'Dərs statusu uğurla yeniləndi');
        }, 'lesson.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->services->statusService->changeStatusFalse($model, new Lesson());
            return redirect()->route('lesson.index')->with('status', 'Dərs statusu uğurla yeniləndi');
        }, 'lesson.index');
    }

    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->services->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'lesson.index', true);
    }
}
