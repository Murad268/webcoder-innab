<?php

namespace Modules\About\Repositories;

use Modules\About\Models\About;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = About::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('description->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }

}
