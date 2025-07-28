<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user=[
        [
            'name'=>'Jody Bell',
            'email'=>'jodybell@gmail.com',
            'password'=>Hash::make('jody123'),
            'is_admin'=>true,
            'student_id'=>null,

        ],
        [
            'name'=>'Mozayo Moloi',
            'email'=>'mozayomoloi@gmail.com',
            'password'=>Hash::make('iamstupid'),
            'is_admin'=>false,
            'student_id'=>'1231236',

        ],

       ];
       User::insert($user);
    }
}
