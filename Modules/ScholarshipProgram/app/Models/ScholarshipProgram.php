<?php

namespace Modules\ScholarshipProgram\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ScholarshipProgram\Database\Factories\ScholarshipProgramFactory;
use Spatie\Translatable\HasTranslations;

class ScholarshipProgram extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['name', 'short_description'];

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
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'scholarshipprogram')->where('file_type', 'image');
    }

    public function image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'scholarshipprogram')->where('file_type', 'image')->select('url', 'relation_id');
    }


    protected static function newFactory(): ScholarshipProgramFactory
    {
        //return ScholarshipProgramFactory::new();
    }
}
