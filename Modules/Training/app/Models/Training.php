<?php

namespace Modules\Training\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Modules\Training\Database\Factories\TrainingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TrainingCategory\Models\TrainingCategory;
use Spatie\Translatable\HasTranslations;

class Training extends Model
{


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
    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'training')->where('file_type', 'image');
    }


    public function image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'training')->where('file_type', 'image')->select('url', 'relation_id');
    }






    public function files()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'training')->where('file_type', 'application');
    }


    public function file()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'training')->where('file_type', 'application')->select('url', 'relation_id');
    }


    protected static function newFactory(): TrainingFactory
    {
        //return TrainingFactory::new();
    }
}
