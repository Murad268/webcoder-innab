<?php

namespace Modules\About\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\About\Database\Factories\AboutFactory;
use Spatie\Translatable\HasTranslations;

class About extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['description'];

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
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'about')->where('file_type', 'image');
    }
    public function icon()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'about')->where('file_type', 'image')->where(
            'type',
            'icon'
        )->select('url', 'relation_id');
    }

    public function image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'about')->where('file_type', 'image')->where(
            'type',
            'image'
        )->select('url', 'relation_id');
    }
    protected static function newFactory(): AboutFactory
    {
        //return AboutFactory::new();
    }
}
