<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::create([
            'code' => 'C001',
            'name' => 'คู่ค้า',
            'created_by' => 1,
            'updated_by' => 1
        ]);
    }
}
