<?php

namespace Modules\Vacancy\Repositories;

use Modules\Vacancy\Models\Vacancy;
use App\Repositories\Repository;
class ModelRepository extends Repository
{
    protected $modelClass = Vacancy::class;

    public function search($query, $limit = 1)
    {
        $locale = app()->getLocale();
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
        ->orWhere('slug->' . $locale, 'like', "%{$query}%")
        ->orWhere('vacancy_header_text->' . $locale, 'like', "%{$query}%")
        ->orWhere('vacancy_footer_text->' . $locale, 'like', "%{$query}%")
        ->orWhere('obligations->' . $locale, 'like', "%{$query}%")
        ->orWhere('skills->' . $locale, 'like', "%{$query}%")
        ->orWhere('seo_title->' . $locale, 'like', "%{$query}%")
        ->orWhere('seo_keywords->' . $locale, 'like', "%{$query}%")
        ->orWhere('seo_description->' . $locale, 'like', "%{$query}%")
        ->paginate($limit);
    }

}
