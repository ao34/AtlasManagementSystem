<?php

use Illuminate\Database\Seeder;
use App\Models\Categories\SubCategory;


class SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_categories')->insert([
            'main_category_id' => '1',
            'sub_category' => '漢字',
        ]);
        DB::table('sub_categories')->insert([
            'main_category_id' => '2',
            'sub_category' => '足し算',
        ]);
    }
}
