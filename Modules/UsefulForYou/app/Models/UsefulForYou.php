<?php

namespace Modules\UsefulForYou\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\UsefulForYou\Database\Factories\UsefulForYouFactory;

class UsefulForYou extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): UsefulForYouFactory
    {
        //return UsefulForYouFactory::new();
    }
}
