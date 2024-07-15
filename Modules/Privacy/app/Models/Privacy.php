<?php

namespace Modules\Privacy\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Privacy\Database\Factories\PrivacyFactory;
use Spatie\Translatable\HasTranslations;

class Privacy extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['page_title', 'text'];



    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'privacy')->where('file_type', 'image');
    }

    protected static function newFactory(): PrivacyFactory
    {
        //return PrivacyFactory::new();
    }
}
