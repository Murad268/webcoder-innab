<?php

namespace Modules\Lesson\Repositories;

use App\Repositories\Repository;
use Modules\Lesson\Models\Lesson;

class ModelRepository extends Repository
{
    protected $modelClass = Lesson::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")

            ->paginate($limit);
    }
    public function getAllWithTitle($limit, $title_id)
    {
        return $this->modelClass::orderBy('order')
            ->where('title_id', $title_id)
            ->paginate($limit);
    }

    public function searchWithTitle($query, $limit = 1, $title_id)
    {
        return $this->modelClass::where('title_id', $title_id)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title->' . app()->getLocale(), 'like', "%{$query}%")
                    ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%");
            })
            ->paginate($limit);
    }
}
