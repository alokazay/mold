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
                    'name' => 'Отрасль',
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
                    'name' => 'Национальность',
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
                    'name' => 'Город',
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

        if(Handbook_category::find(5) == null){
            Handbook_category::insert([
                [
                    'id'=> 5,
                    'name' => 'Страна',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }
        if(Handbook_category::find(6) == null){
            Handbook_category::insert([
                [
                    'id'=> 6,
                    'name' => 'Тип документа',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }
        if(Handbook_category::find(7) == null){
            Handbook_category::insert([
                [
                    'id'=> 7,
                    'name' => 'Транспортные расходы',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }
        if(Handbook_category::find(8) == null){
            Handbook_category::insert([
                [
                    'id'=> 8,
                    'name' => 'Место приезда',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }

        if(Handbook_category::find(9) == null){
            Handbook_category::insert([
                [
                    'id'=> 9,
                    'name' => 'Статус трудоустройства',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }
        if(Handbook_category::find(10) == null){
            Handbook_category::insert([
                [
                    'id'=> 10,
                    'name' => 'Гражданство',
                    'active'=>1,
                    'created_at'=>$NOW,
                    'updated_at'=>$NOW,
                ],
            ]);
        }

    }
}
