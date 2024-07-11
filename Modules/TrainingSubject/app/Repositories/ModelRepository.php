<?php

namespace Modules\TrainingSubject\Repositories;

use Modules\Training\Models\Training;
use Modules\TrainingSubject\Models\TrainingSubject;

class ModelRepository
{
    protected $modelClass = TrainingSubject::class;


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
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_keywords->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%")
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
