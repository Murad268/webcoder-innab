<?php

namespace Modules\Training\Repositories;

use App\Repositories\Repository;
use Modules\Training\Models\Training;

class ModelRepository extends Repository
{
    protected $modelClass = Training::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_keywords->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
