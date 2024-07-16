<?php

namespace Modules\VideoLessonsTitle\Repositories;

use App\Repositories\Repository;
use Modules\VideoLessonsTitle\Models\VideoLessonsTitle;

class ModelRepository extends Repository
{
    protected $modelClass = VideoLessonsTitle::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
    public function getAllWithVideoLesson($limit, $video_lesson_id)
    {
        return $this->modelClass::orderBy('order')
            ->where('lesson_id', $video_lesson_id)
            ->paginate($limit);
    }

    public function searchWithVideoLesson($query, $limit = 1, $video_lesson_id)
    {
        return $this->modelClass::where('lesson_id', $video_lesson_id)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title->' . app()->getLocale(), 'like', "%{$query}%")
                    ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%");
            })
            ->paginate($limit);
    }
}
