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
        return $this->hasMany(SystemFiles::class, 'relation_id')->where('model_type', 'project')->where('file_type', 'image');
    }
    protected static function newFactory(): RoomFactory
    {
        //return RoomFactory::new();
    }
}
