<?php

namespace Database\Seeders;

use App\Models\Meal;
use Illuminate\Database\Seeder;

class MealsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $meals = ['Fried Chicken', 'Kofta', 'Koshary', 'Burger', 'Fish', 'Shawerma'];
        for ($i=0;$i<6;$i++)
            Meal::create(['name' => $meals[$i]]);
    }
}
