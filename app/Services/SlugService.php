<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugService
{
    public function sluggable($str)
    {
        return Str::slug($str);
    }

    public function sluggableArray($array)
    {
        $slugs = [];

        foreach ($array as $key => $value) {
            $slugs[$key] = $this->sluggable($value);
        }

        return $slugs;
    }

}
