<?php

namespace Modules\BlogCategory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BlogCategory\Database\Factories\BlogCategoryFactory;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
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

    /**
     * The attributes that are mass assignable.
     */


    protected static function newFactory(): BlogCategoryFactory
    {
        //return BlogCategoryFactory::new();
    }
}
