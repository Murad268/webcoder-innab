<?php

namespace Modules\Workshop\Repositories;

use App\Repositories\Repository;
use Modules\Workshop\Models\Workshop;

class ModelRepository extends Repository
{
    protected $modelClass = Workshop::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('spikers->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('place->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
