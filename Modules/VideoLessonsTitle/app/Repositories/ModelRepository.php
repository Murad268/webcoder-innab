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
}
