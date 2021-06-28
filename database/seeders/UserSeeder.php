<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            "username" => "user01",
            "password" => "123456",
            "family_name" => "Vu",
            "middle_name" => "Duc",
            "last_name" => "Thuan",
            "card_id" => "12334568",
            "phone_number" => "0909700982",
            "birthday" => "1993/05/03",
            "sex" => 1,
            "email" => "user01@mail.com",
            "remember_token" => "",
            "created_at" => now(),
            "updated_at" => now(),
        ];

        User::insert($user);
    }
}
