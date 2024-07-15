<?php

namespace Modules\ScholarshipProgram\Repositories;

use Modules\ScholarshipProgram\Models\ScholarshipProgram;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = ScholarshipProgram::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }

}
