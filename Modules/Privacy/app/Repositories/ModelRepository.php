<?php

namespace Modules\Privacy\Repositories;

use Modules\Privacy\Models\Privacy;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = Privacy::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
    public function all_active()
    {
    }

    public function all($limit = 1)
    {
    }
}
