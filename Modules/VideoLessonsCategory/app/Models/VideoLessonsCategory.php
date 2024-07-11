<?php

namespace Modules\VideoLessonsCategory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\VideoLessonsCategory\Database\Factories\VideoLessonsCategoryFactory;
use Spatie\Translatable\HasTranslations;

class VideoLessonsCategory extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    use HasFactory, HasTranslations;
    protected $guarded = [];
    public $translatable = ['title', 'slug', 'seo_title', 'seo_keywords', 'seo_description'];

    /**
     * The attributes that are mass assignable.
     */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxOrder = self::max('order');
            $model->order = $maxOrder !== null ? $maxOrder + 1 : 1;
        });
    }

    protected static function newFactory(): VideoLessonsCategoryFactory
    {
        //return VideoLessonsCategoryFactory::new();
    }
}
