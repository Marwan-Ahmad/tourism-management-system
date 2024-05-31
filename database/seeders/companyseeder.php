<?php

namespace Database\Seeders;

use App\Models\Contrey;
use App\Models\FightCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class companyseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countryid=Contrey::query()->where('name','syria')->first();
        FightCompany::query()->create([
            'name'=>'shamwings',
            'location'=>'maze',
            'description'=>'yes is the best company ever',
            'Comforts'=>'low',
            'photo'=>'/storage/66574f927d8d3.jpg',
            'food'=>'low',
            'safe'=>'low',
            'service'=>'low',
            'Country_id'=>$countryid->id,
            'Rate'=>'low',
        ]);
    }
}