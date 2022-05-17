<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $NOW = Carbon::now();
        User::insert([
            [
                'id'=> 1,
                'name' => 'Administrator',
                'group_id ='=>1,
                'email'=>'admin@test.net',
                'password'=>Hash::make('1111'),
                'remember_token'=>Hash::make(Hash::make('oK5sU4rM')),
                'activation'=>1,
                'created_at'=>$NOW,
                'updated_at'=>$NOW,
            ],
        ]);
    }
}
