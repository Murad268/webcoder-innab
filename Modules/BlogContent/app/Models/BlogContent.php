<?php

namespace Modules\BlogContent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\BlogContent\Database\Factories\BlogContentFactory;
use Spatie\Translatable\HasTranslations;

class BlogContent extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['title', 'slug', 'text'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxOrder = self::max('order');
            $model->order = $maxOrder !== null ? $maxOrder + 1 : 1;
        });
    }

    protected static function newFactory(): BlogContentFactory
    {
        //return BlogContentFactory::new();
    }
}
