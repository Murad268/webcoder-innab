<?php

namespace Modules\TrainingSubject\Repositories;

use App\Repositories\Repository;
use Modules\Training\Models\Training;
use Modules\TrainingSubject\Models\TrainingSubject;

class ModelRepository extends Repository
{
    protected $modelClass = TrainingSubject::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('description->' . app()->getLocale(), 'like', "%{$query}%")

            ->paginate($limit);
    }
}
