<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Clientseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            'Firstname'=>'hamed',
            'Lastname'=>'Ahmad',
            'visaphoto'=>"D:\MY THINGS\image\wallpaperbetter.com_7680x4320.jpg",
            'phone'=>'0938156383',
            'email'=>'meroahmad@gmail.com',
            'password'=>bcrypt('8220168Aa'),
            'Nationalty'=>'syrian',
            'role'=>'client'
        ]);
    }
}