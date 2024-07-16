<?php

namespace Modules\SiteInfo\Database\Seeders;

use Illuminate\Database\Seeder;

class SiteInfoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([SiteInfoSeeder::class]);
    }
}
