<?php

namespace Modules\Project\Repositories;

use App\Repositories\Repository;
use Modules\Partners\Models\Partners;
use Modules\Project\Models\Project;

class ModelRepository extends Repository
{
    protected $modelClass = Project::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('name->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
