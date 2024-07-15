<?php

namespace Modules\CourseFAQ\Repositories;

use App\Repositories\Repository;
use Modules\CourseFAQ\Models\CourseFaq;


class ModelRepository extends Repository
{
    protected $modelClass = CourseFaq::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('question->' . app()->getLocale(), 'like', "%{$query}%")
            -> orWhere('answer->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
