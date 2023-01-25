<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\MainCategory;

class MainCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('main_categories')->insert([
            'main_category' => '国語',
        ]);
        DB::table('main_categories')->insert([
            'main_category' => '数学',
        ]);
        DB::table('main_categories')->insert([
            'main_category' => '英語',
        ]);
    }
}
