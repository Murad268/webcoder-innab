<?php

namespace Modules\CourseFAQ\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\CourseFAQ\Database\Factories\CourseFaqFactory;
use Spatie\Translatable\HasTranslations;

class CourseFaq extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['question', 'answer'];
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
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'customer')->where('file_type', 'image');
    }
    protected static function newFactory(): CourseFaqFactory
    {
        //return CourseFaqFactory::new();
    }
}
