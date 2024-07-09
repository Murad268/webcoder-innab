<?php

namespace Modules\Training\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Training\Database\Factories\TrainingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TrainingCategory\Models\TrainingCategory;
use Spatie\Translatable\HasTranslations;

class Training extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['title', 'seo_title', 'slug', 'seo_keywords', 'seo_description', "short_description", 'list', "top_text_title", 'top_text', "bottom_text_title", 'bottom_text'];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxOrder = self::max('order');
            $model->order = $maxOrder !== null ? $maxOrder + 1 : 1;
        });
    }

    public function category() {
        return $this->belongsTo(TrainingCategory::class);
    }

    protected static function newFactory(): TrainingFactory
    {
        //return TrainingFactory::new();
    }
}
