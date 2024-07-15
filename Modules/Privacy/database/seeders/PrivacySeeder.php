<?php

namespace Modules\Privacy\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Privacy\Models\Privacy;

class PrivacySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas =
            [
                [
                    'page_title' => 'test',
                    'text' => 'This is the first entry.',
                ]
            ];


        foreach ($datas as $data) {
            Privacy::create($data);
        }
    }
}
