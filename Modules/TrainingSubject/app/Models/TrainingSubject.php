<?php

namespace Modules\TrainingSubject\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\TrainingSubject\Database\Factories\TrainingSubjectFactory;
use Spatie\Translatable\HasTranslations;

class TrainingSubject extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];
    public $translatable = ['name', 'description'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxOrder = self::max('order');
            $model->order = $maxOrder !== null ? $maxOrder + 1 : 1;
        });
    }
    protected static function newFactory(): TrainingSubjectFactory
    {
        //return TrainingSubjectFactory::new();
    }
}
