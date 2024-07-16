<?php

namespace Modules\Translate\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Translate\Database\Factories\TranslateFactory;
use Spatie\Translatable\HasTranslations;

class Translate extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['value'];

    protected static function boot()
    {
        parent::boot();

       
    }

    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'translate')->where('file_type', 'image');
    }

    protected static function newFactory(): TranslateFactory
    {
        //return TranslateFactory::new();
    }
}
