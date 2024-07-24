<?php

namespace Modules\Room\Models;

use App\Models\SystemFiles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Room\Database\Factories\RoomFactory;

class Room extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    public function images()
    {
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'room')->where('file_type', 'image');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxOrder = self::max('order');
            $model->order = $maxOrder !== null ? $maxOrder + 1 : 1;
        });
    }

    public function image()
    {
        return $this->hasOne(SystemFiles::class, 'relation_id')->where('model_type', 'room')->where('file_type', 'image');
    }

    protected static function newFactory(): RoomFactory
    {
        //return RoomFactory::new();
    }
}
