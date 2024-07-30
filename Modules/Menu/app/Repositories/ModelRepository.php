<?php

namespace Modules\Menu\Repositories;

use Modules\Menu\Models\Menu;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = Menu::class;
    public function all_active()
    {
        return $this->modelClass::all();
    }
    public function all_activeWith($relations = [])
    {
        return $this->modelClass::with($relations)->where('status', 1)->get();
    }
    public function getAllPaginate($limit)
    {
        return $this->modelClass::paginate($limit);
    }
    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }

}
