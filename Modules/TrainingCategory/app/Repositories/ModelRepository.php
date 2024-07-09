<?php

namespace Modules\TrainingCategory\Repositories;

use Modules\TrainingCategory\Models\TrainingCategory;

class ModelRepository
{
    protected $modelClass = TrainingCategory::class;


    public function all_active()
    {
        return $this->modelClass::orderBy('order')->where('status', 1)->get();
    }

    public function all()
    {
        return $this-> modelClass::orderBy('order')->get();
    }
    public function search($query)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
        ->orWhere('seo_title->' . app()->getLocale(), 'like', "%{$query}%")
        ->orWhere('seo_keywords->' . app()->getLocale(), 'like', "%{$query}%")
        ->orWhere('seo_description->' . app()->getLocale(), 'like', "%{$query}%")
        ->get();
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
