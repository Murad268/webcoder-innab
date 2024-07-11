<?php

namespace Modules\CourseFAQ\Repositories;

use Modules\CourseFAQ\Models\CourseFaq;


class ModelRepository
{
    protected $modelClass = CourseFaq::class;


    public function all_active()
    {
        return $this->modelClass::orderBy('order')->where('status', 1)->get();
    }

    public function all($limit = 1)
    {
        return $this->modelClass::orderBy('order')->paginate($limit);
    }
    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('question->' . app()->getLocale(), 'like', "%{$query}%")
        -> orWhere('answer->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
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

    public function where($key, $value)
    {
        return $this->modelClass::where($key, $value);
    }
}
