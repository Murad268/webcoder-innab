<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $modelClass = Model::class;
    public function all_active()
    {
        return $this->modelClass::orderBy('order')->where('status', 1)->get();
    }
    public function all_activeWith($relations = [])
    {
        return $this->modelClass::orderBy('order')->with($relations)->where('status', 1)->get();
    }
    public function getAll()
    {
        return $this->modelClass::orderBy('order')->get();
    }
    public function all($limit = 1)
    {
        return $this->modelClass::orderBy('order')->paginate($limit);
    }

    abstract public function search($query, $limit = 1);

    public function find($id)
    {
        return $this->modelClass::findOrFail($id);
    }
    public function findWith($id, $relation = [])
    {
        return $this->modelClass::with($relation)->findOrFail($id);
    }
    public function findWhereInGet(array $data)
    {
        return $this->modelClass::whereIn('id', $data)->get();
    }
    public function findWhereInGetPaginate(array $data, $limit, $relation_id)
    {
        return $this->modelClass::whereIn($relation_id, $data)->paginate($limit);
    }
    public function getModel()
    {
        return $this->modelClass;
    }
    public function widthOrder($order)
    {
        return $this->modelClass::where('order', $order)->first();
    }
    public function where($key, $value)
    {
        return $this->modelClass::where($key, $value);
    }

    public function getTrainingByCategory($categoryId)
    {
        return $this->modelClass::where('category_id', $categoryId)->orderBy('order')->where('status', 1)->get();
    }

    public function getTrainingByCategoryWith($relation, $categoryId, $relations = [])
    {
        return $this->modelClass::where($relation, $categoryId)->orderBy('order')->where('status', 1)->with($relations)->get();
    }
}
