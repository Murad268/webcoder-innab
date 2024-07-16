<?php

namespace Modules\SiteInfo\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SiteInfo\Models\SiteInfo;

class SiteInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas =
            [
                [
                    'facebook_link' => 'test',
                    'instagram_link' => 'test',
                    'linkedin_link' => 'test',
                    'twitter_link' => 'test',
                    'youtube_link' => 'test',
                    'phone1' => 'test',
                    'phone2' => 'test',
                    'email1' => 'test',
                    'email2' => 'test',
                    'address' => 'test',
                    'map' => 'test',
                ]
            ];


        foreach ($datas as $data) {
            SiteInfo::create($data);
        }
    }
}
