<?php

namespace Database\Seeders;

use App\Models\Handbook;
use App\Models\Handbook_category;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class HandbookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $NOW = Carbon::now();
        if(Handbook_category::find(1) == null){
            Handbook_category::insert([
                [
                    'id'=> 1,
                    'name' => 'Отрасли',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }
        if(Handbook_category::find(2) == null){
            Handbook_category::insert([
                [
                    'id'=> 2,
                    'name' => 'Национальности',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }
        if(Handbook_category::find(3) == null){
            Handbook_category::insert([
                [
                    'id'=> 3,
                    'name' => 'Города',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }
        if(Handbook_category::find(4) == null){
            Handbook_category::insert([
                [
                    'id'=> 4,
                    'name' => 'Тип договора',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }

    }
}
