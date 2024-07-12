<?php

namespace Modules\Lesson\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lesson\Database\Factories\LessonFactory;
use Spatie\Translatable\HasTranslations;

class Lesson extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];
    public $translatable = ['title', 'slug'];

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


    protected static function newFactory(): LessonFactory
    {
        //return LessonFactory::new();
    }
}
