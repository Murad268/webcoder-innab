<?php

namespace Modules\Menu\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Menu\Database\Factories\MenuFactory;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public $translatable = ['title', 'slug','seo_title', 'seo_keywords', 'seo_description'];


    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'menu')->where('file_type', 'image');
    }

    protected static function newFactory(): MenuFactory
    {
        //return MenuFactory::new();
    }
}
