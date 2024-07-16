<?php

namespace Modules\Translate\Repositories;

use Modules\Translate\Models\Translate;
use App\Repositories\Repository;

class ModelRepository extends Repository
{
    protected $modelClass = Translate::class;
    public function all_active()
    {
    }

    public function all($limit = 1)
    {
        return $this->modelClass::paginate($limit);
    }
    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('group->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('keyword->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('value->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
