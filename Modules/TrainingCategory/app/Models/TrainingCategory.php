<?php

namespace Modules\TrainingCategory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TrainingCategory\Database\Factories\TrainingCategoryFactory;
use Spatie\Translatable\HasTranslations;
class TrainingCategory extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['title', 'seo_title', 'slug', 'seo_keywords', 'seo_description'];
       protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxOrder = self::max('order');
            $model->order = $maxOrder !== null ? $maxOrder + 1 : 1;
        });
    }
    protected static function newFactory(): TrainingCategoryFactory
    {
        //return TrainingCategoryFactory::new();
    }
}
