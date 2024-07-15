<?php

namespace Modules\Customer\Repositories;

use App\Repositories\Repository;
use Modules\Customer\Models\Customer;


class ModelRepository extends Repository
{
    protected $modelClass = Customer::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('name->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
