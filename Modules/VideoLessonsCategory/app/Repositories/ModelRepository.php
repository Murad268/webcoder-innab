<?php

namespace Modules\VideoLessonsCategory\Repositories;

use App\Repositories\Repository;
use Modules\VideoLessonsCategory\Models\VideoLessonsCategory;

class ModelRepository extends Repository
{
    protected $modelClass = VideoLessonsCategory::class;


    public function search($query, $limit = 1)
    {
        return $this->modelClass::where('title->' . app()->getLocale(), 'like', "%{$query}%")

            ->paginate($limit);
    }

}
