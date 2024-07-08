<?php

namespace Modules\Lang\Repositories;

use Modules\Lang\Models\Lang;

class ModelRepository
{
    protected $modelClass = Lang::class;


    public function all_active()
    {
        return $this->modelClass::orderBy('order')->where('status', 1)->get();
    }

    public function all()
    {
        return $this-> modelClass::orderBy('order')->get();
    }
    public function search($q)
    {
        return $this->modelClass::where('name', 'like', '%' . $q . '%')->orWhere('site_code', 'like', '%' . $q . '%')->orWhere('code', 'like', '%' . $q . '%')->get();
    }

    public function find($id)
    {
        return $this->modelClass::findOrFail($id);
    }

    public function findWhereInGet(array $data)
    {
        return $this->modelClass::whereIn('id', $data)->get();
    }

    public function getModel()
    {
        return $this->modelClass;
    }

    public function widthOrder($order)
    {
        return $this->modelClass::where('order', $order)->first();
    }

    public function where($key, $value) {
        return $this->modelClass::where($key, $value);
    }
}
