<?php

namespace Database\Seeders;

use App\Models\LoansPackage;
use Illuminate\Database\Seeder;

class LoansPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            ['name' => 'Package A', 'frequency' => 3, 'interest_rate' => 0.05, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Package B', 'frequency' => 6, 'interest_rate' => 0.04, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Package C', 'frequency' => 9, 'interest_rate' => 0.03, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Package D', 'frequency' => 12, 'interest_rate' => 0.02, 'created_at' => now(), 'updated_at' => now()],
        ];

        $i = LoansPackage::insert($packages);
        dd($i);
    }
}
