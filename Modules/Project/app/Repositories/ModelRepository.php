<?php

namespace Modules\Project\Repositories;

use App\Repositories\Repository;
use Modules\Project\Models\Project;

class ModelRepository extends Repository
{
    protected $modelClass = Project::class;

    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('card_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('text->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('product_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('product_price', 'like', "%{$query}%")
            ->orWhere('mobile_title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('mobile_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('mobile_qr_text->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('requirements->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('meta_keywords->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('meta_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_links->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('seo_scripts->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
