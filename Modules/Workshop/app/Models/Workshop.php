<?php

namespace Modules\Workshop\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Workshop\Database\Factories\WorkshopFactory;
use Spatie\Translatable\HasTranslations;

class Workshop extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['title', 'slug', 'spikers', 'place'];

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
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'workshop')->where('file_type', 'image');
    }

    protected static function newFactory(): WorkshopFactory
    {
        //return WorkshopFactory::new();
    }
}
