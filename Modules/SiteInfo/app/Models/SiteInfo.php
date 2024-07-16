<?php

namespace Modules\SiteInfo\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SiteInfo\Database\Factories\SiteInfoFactory;
use Spatie\Translatable\HasTranslations;

class SiteInfo extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['address'];

    protected static function boot()
    {
        parent::boot();

        
    }

    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'siteinfo')->where('file_type', 'image');
    }

    protected static function newFactory(): SiteInfoFactory
    {
        //return SiteInfoFactory::new();
    }
}
