<?php

namespace Modules\Room\Repositories;


use App\Repositories\Repository;
use Modules\Room\Models\Room;

class ModelRepository extends Repository
{
    protected $modelClass = Room::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('name->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
