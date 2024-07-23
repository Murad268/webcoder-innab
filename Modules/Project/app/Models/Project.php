<?php

namespace Modules\Project\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Project\Database\Factories\ProjectFactory;
use Spatie\Translatable\HasTranslations;
class Project extends Model
{


    /**
     * The attributes that are mass assignable.
     */
    use HasFactory, HasTranslations;
    protected $guarded = [];
    public $translatable = ['title', 'slug', 'card_description', 'text', 'product_description', 'product_price', 'mobile_title', 'mobile_description', 'mobile_qr_text', 'seo_title', 'meta_keywords', 'meta_description', 'requirements'];


    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'project')->where('file_type', 'image');
    }

    public function image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'project')->where('file_type', 'image')->select('url', 'relation_id')->where('type', 'image');
    }

    public function mobile_product_image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'project')->where('file_type', 'image')->select('url', 'relation_id')->where('type', 'mobile_product_image');
    }
    public function product_image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'project')->where('file_type', 'image')->select('url', 'relation_id')->where('type', 'product_image');
    }

    public function mobile_product_qr()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'project')->where('file_type', 'image')->select('url', 'relation_id')->where('type', 'mobile_product_qr');
    }



    protected static function newFactory(): ProjectFactory
    {
        //return ProjectFactory::new();
    }
}
