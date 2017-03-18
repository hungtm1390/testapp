<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert(
        [
        	[
            'name' => "Hồ Ngọc Hà",
            'address' => "HCM",
            'age' => "34",
            'photo' => "hongocha.jpg",
            ],
            [
            'name' => "Hồ Ngọc Hà",
            'address' => "HCM",
            'age' => "34",
            'photo' => "hongocha.jpg",
            ],
            [
            'name' => "Hồ Ngọc Hà",
            'address' => "HCM",
            'age' => "34",
            'photo' => "hongocha.jpg",
            ],
            [
            'name' => "Hồ Ngọc Hà",
            'address' => "HCM",
            'age' => "34",
            'photo' => "hongocha.jpg",
            ],[
            'name' => "Hồ Ngọc Hà",
            'address' => "HCM",
            'age' => "34",
            'photo' => "hongocha.jpg",
            ],
            [
            'name' => "Hồ Ngọc Hà",
            'address' => "HCM",
            'age' => "34",
            'photo' => "hongocha.jpg",
            ]
    	]);
    }
}
