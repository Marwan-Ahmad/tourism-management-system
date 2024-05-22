<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Adminloginseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=User::query()->create([
            'Firstname'=>'Marwan',
            'Lastname'=>'Ahmad',
            'visaphoto'=>"D:\MY THINGS\image\wallpaperbetter.com_7680x4320.jpg",
            'phone'=>'0938156382',
            'email'=>'ahmdmrwan47@gmail.com',
            'password'=>bcrypt('8220168Aa'),
            'Nationalty'=>'syrian',
            'role'=>'manager'
        ]);
    }
}
