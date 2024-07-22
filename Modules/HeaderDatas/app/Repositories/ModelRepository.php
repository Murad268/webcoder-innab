<?php

namespace Modules\HeaderDatas\Repositories;

use Modules\HeaderDatas\Models\HeaderDatas;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = HeaderDatas::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }

}
