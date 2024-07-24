<?php

namespace Modules\Blog\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Blog\Database\Factories\BlogFactory;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['title', 'slug', 'short_description', 'seo_title', 'seo_keywords', 'seo_description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxOrder = self::max('order');
            $model->order = $maxOrder !== null ? $maxOrder + 1 : 1;
        });
    }


    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'blog')->where('file_type', 'image');
    }

    public function image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'blog')->where('file_type', 'image')->select('relation_id', 'url');
    }


    protected static function newFactory(): BlogFactory
    {
        //return BlogFactory::new();
    }
}
