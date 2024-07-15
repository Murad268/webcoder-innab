<?php

namespace Modules\Vebinar\Repositories;

use App\Repositories\Repository;
use Modules\Vebinar\Models\Vebinar;

class ModelRepository extends Repository
{
    protected $modelClass = Vebinar::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('spikers->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('place->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
