<?php

namespace Modules\Corporative\Repositories;

use Modules\Corporative\Models\Corporative;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = Corporative::class;

    public function all_active()
    {
    }

    public function all($limit = 1)
    {
    }

    public function search($query, $limit = 1)
    {
    }

}
