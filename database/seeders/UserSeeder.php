<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(User::find(1) == null){
            User::insert([
                [
                    'id'=> 1,
                    'firstName' => 'System',
                    'lastName' => 'System',
                    'email' => 'admin@test.net',
                    'group_id'=>1,
                    'password'=>Hash::make('1111'),
                    'remember_token'=>Hash::make(Hash::make('oK5sU4rM')),
                    'activation'=>1,
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
            ]);
        }

    }
}
