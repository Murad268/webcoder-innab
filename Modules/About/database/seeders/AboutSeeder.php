<?php

namespace Modules\About\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\About\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas =
            [
               [
                'date' => 'First Entry',
                'description' => 'This is the first entry.',
               ]
            ];


        foreach ($datas as $data) {
            About::create($data);
        }
    }
}
