<?php

namespace Modules\SiteInfo\Repositories;

use Modules\SiteInfo\Models\SiteInfo;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = SiteInfo::class;
    public function all_active()
    {

    }

    public function all($limit = 1)
    {
    }
    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }

}
