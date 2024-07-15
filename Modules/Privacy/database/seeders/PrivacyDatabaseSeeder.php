<?php

namespace Modules\Privacy\Database\Seeders;

use Illuminate\Database\Seeder;

class PrivacyDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([PrivacySeeder::class]);
    }
}
