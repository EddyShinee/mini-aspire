<?php

namespace Database\Seeders;

use App\Models\Loans;
use Illuminate\Database\Seeder;

class LoansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loan = [
            "id" =>  1,
            "user_id" => 2,
            "loans_package_id" => 4,
            "loan" => 8000000,
            "duration" => "2022-10-10",
            "frequency"=> 12,
            "interest_rate" => 0,
            "fee"=> 10000,
            "status" => 1,
            "payment_period" => 0,
            "total" => 8010000,
            "remain" => 0,
            "created_at" => null,
            "updated_at"=> null
        ];

        Loans::insert($loan);
    }
}
