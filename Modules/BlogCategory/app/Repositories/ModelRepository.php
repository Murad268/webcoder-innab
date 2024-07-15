<?php

namespace Modules\BlogCategory\Repositories;

use App\Repositories\Repository;
use Modules\BlogCategory\Models\BlogCategory;

class ModelRepository extends Repository
{
    protected $modelClass = BlogCategory::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")

            ->paginate($limit);
    }
}
