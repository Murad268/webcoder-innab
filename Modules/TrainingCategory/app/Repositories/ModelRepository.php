<?php

namespace Modules\TrainingCategory\Repositories;

use App\Repositories\Repository;
use Modules\TrainingCategory\Models\TrainingCategory;

class ModelRepository extends Repository
{
    protected $modelClass = TrainingCategory::class;


    public function search($query)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_keywords->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->get();
    }
}
