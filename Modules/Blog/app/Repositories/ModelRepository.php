<?php

namespace Modules\Blog\Repositories;

use App\Repositories\Repository;
use Modules\Blog\Models\Blog;
use Modules\VideoLessons\Models\VideoLessons;

class ModelRepository extends Repository
{
    protected $modelClass = Blog::class;
    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
    public function getAllWidthCategory($limit, $category_id) {
        return $this->modelClass::orderBy('order')->where('category_id', $category_id)->paginate($limit);
    }
    public function searchWithCategory($query, $limit = 1, $category_id)
    {
        return $this->modelClass::where('category_id', $category_id)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title->' . app()->getLocale(), 'like', "%{$query}%")
                    ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%");
            })
            ->paginate($limit);
    }

}
