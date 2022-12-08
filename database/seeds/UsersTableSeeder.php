<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'over_name' => '青木',
            'under_name' => '早穂',
            'over_name_kana' => 'アオキ',
            'under_name_kana' => 'サホ',
            'mail_address' => 'aoki@mail.com',
            'sex' => '2',
            'birth_day' => '99990101',
            'role' => '1',
            'password' => bcrypt('test1234'),
        ]);

         DB::table('users')->insert([
            'over_name' => '山田',
            'under_name' => '太郎',
            'over_name_kana' => 'ヤマダ',
            'under_name_kana' => 'タロウ',
            'mail_address' => 't@mail.com',
            'sex' => '1',
            'birth_day' => '99990101',
            'role' => '4',
            'password' => bcrypt('12345678'),
         ]);

    }
}
