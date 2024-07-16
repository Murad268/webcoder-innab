<?php

namespace Modules\BlogContent\Repositories;

use App\Repositories\Repository;
use Modules\BlogContent\Models\BlogContent;
use Modules\VideoLessons\Models\VideoLessons;

class ModelRepository extends Repository
{
    protected $modelClass = BlogContent::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
    public function getAllWidthBlog($limit, $blog_id)
    {
        return $this->modelClass::orderBy('order')->where('blog_id', $blog_id)->paginate($limit);
    }
    public function searchWithBlog($query, $limit = 1, $blog_id)
    {
        return $this->modelClass::where('blog_id', $blog_id)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title->' . app()->getLocale(), 'like', "%{$query}%")
                    ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%");
            })
            ->paginate($limit);
    }
}
