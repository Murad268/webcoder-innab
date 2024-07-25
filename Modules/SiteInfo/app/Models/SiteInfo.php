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
    public function header_top()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'siteinfo')->where('file_type', 'image')->where('type', 'nav_logo')->select('url','relation_id');
    }
    public function header_footer()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'siteinfo')->where('file_type', 'image')->where('type', 'footer_logo')->select('url','relation_id');
    }
    protected static function newFactory(): SiteInfoFactory
    {
        //return SiteInfoFactory::new();
    }
}
