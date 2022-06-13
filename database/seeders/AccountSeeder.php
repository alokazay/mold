<?php

namespace Database\Seeders;

use App\Models\Account_setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AccountSeeder  extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(Account_setting::find(1) == null){
            Account_setting::insert([
                [
                    'id'=> 1,
                    'nip' => '',
                    'name1' => '',
                    'name2' => '',
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                ],
            ]);
        }

    }
}
