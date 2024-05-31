<?php

namespace Database\Seeders;

use App\Models\Contrey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class countryseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contrey::query()->create([
            "name"=> "syria",
            "photo"=> "/storage/66574f927d8d3.jpg",
            "Rate"=> "low"
        ]);
    }
}