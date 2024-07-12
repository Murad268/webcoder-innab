<?php

namespace Modules\Lesson\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RemoveService;
use App\Services\SimpleCrudService;
use App\Services\StatusService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Lesson\Repositories\ModelRepository;
use Modules\Lang\Repositories\ModelRepository as LangRepository;
use Modules\Lesson\Models\Lesson;
use Modules\VideoLessonsTitle\Repositories\ModelRepository as VideLessonsTitleRepository;
class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct(public ModelRepository $repository, public SimpleCrudService $crudService, public LangRepository $langRepository, public StatusService $statusService, public RemoveService $removeService, public VideLessonsTitleRepository $videLessonsTitleRepository)
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
        return view('lesson::index', compact('items', 'activeLangsCount', 'q'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $titles = $this->videLessonsTitleRepository->all_active();
        $languages = $this->langRepository->all_active();
        return view('lesson::create', compact('languages', 'titles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->executeSafely(function () use ($request) {
            $this->crudService->create(new Lesson(), $request, 'lesson');
            return redirect()->route('lesson.index')->with('status', 'Dərs uğurla əlavə edildi');
        }, 'lesson.index');
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
    public function edit(Request $request, Lesson $lesson)
    {
        $languages = $this->langRepository->all_active();
        $titles = $this->videLessonsTitleRepository->all_active();
        return view('lesson::edit', compact('lesson', 'languages', 'titles', 'titles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson): RedirectResponse
    {
        return $this->executeSafely(function () use ($request, $lesson) {
            $this->crudService->update($lesson, $request, 'image');
            return redirect()->route('lesson.index')->with('status', 'Dərs uğurla yeniləndi');
        }, 'lesson.index');
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
            $this->statusService->changeStatusTrue($model, new Lesson());
            return redirect()->route('lesson.index')->with('status', 'Dərs statusu uğurla yeniləndi');
        }, 'lesson.index');
    }

    public function changeStatusFalse($id)
    {
        return $this->executeSafely(function () use ($id) {
            $model = $this->repository->find($id);
            $this->statusService->changeStatusFalse($model, new Lesson());
            return redirect()->route('lesson.index')->with('status', 'Dərs statusu uğurla yeniləndi');
        }, 'lesson.index');
    }


    public function delete_selected_items(Request $request)
    {
        return $this->executeSafely(function () use ($request) {
            $models = $this->repository->findWhereInGet($request->ids);
            $this->removeService->removeAll($models);
            return response()->json(['success' => $models, 'message' => "məlumatlar uğurla silindilər"]);
        }, 'lesson.index', true);
    }
}
