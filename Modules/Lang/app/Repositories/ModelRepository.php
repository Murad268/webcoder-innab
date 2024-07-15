<?php

namespace Modules\Lang\Repositories;

use App\Repositories\Repository;
use Modules\Lang\Models\Lang;

class ModelRepository extends Repository
{
    protected $modelClass = Lang::class;


    public function search($q, $limit = 1)
    {
        return $this->modelClass::where('name', 'like', '%' . $q . '%')->orWhere('site_code', 'like', '%' . $q . '%')->orWhere('code', 'like', '%' . $q . '%')->paginate($limit);
    }
}
