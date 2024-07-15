<?php

namespace Modules\Vacancy\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Vacancy\Database\Factories\VacancyFactory;
use Spatie\Translatable\HasTranslations;

class Vacancy extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = [
        'title',
        'slug',
        'page_title',
        'text',
        'short_description',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'vacancy_header_text',
        'vacancy_footer_text',
        'obligations',
        'skills'
    ];


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
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'vacancy')->where('file_type', 'image');
    }

    protected static function newFactory(): VacancyFactory
    {
        //return VacancyFactory::new();
    }
}
