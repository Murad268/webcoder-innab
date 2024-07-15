<?php

namespace Modules\VideoLessons\Repositories;

use App\Repositories\Repository;
use Modules\VideoLessons\Models\VideoLessons;

class ModelRepository extends Repository
{
    protected $modelClass = VideoLessons::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")
            ->orWhere('short_description->' . app()->getLocale(), 'like', "%{$query}%")
            ->paginate($limit);
    }
}
