<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class Userseeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $NOW = Carbon::now();
        if(User::find(1) == null){
            User::insert([
                [
                    'id'=> 1,
                    'firstName' => 'System',
                    'lastName' => 'System',
                    'email' => 'admin@test.net',
                    'group_id'=>1,
                    'password'=>Hash::make('oK5sU4rM'),
                    'remember_token'=>Hash::make(Hash::make('oK5sU4rM')),
                    'activation'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }

    }
}
