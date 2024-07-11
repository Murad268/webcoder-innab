<?php

namespace Modules\Customer\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Database\Factories\CustomerFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
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
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'customer')->where('file_type', 'image');
    }
    protected static function newFactory(): CustomerFactory
    {
        //return CustomerFactory::new();
    }
}
