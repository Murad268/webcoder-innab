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
}
