<?php

namespace Database\Seeders;

use App\Models\Contrey;
use App\Models\FightCompany;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tripseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyid=FightCompany::query()->where('name','shamwings')->where('location','maze')->first();
        $countryid=Contrey::query()->where('name','syria')->first();

        Trip::query()->create([
            'TripPlace'=>'abbaseen',
            'Towards'=>'syria',
            'TimeTrip' => Carbon::parse('2024-05-29 10:30:00'),
            'fight_company_id'=> $companyid->id,
            'country_id'=>$countryid->id,
            'Price'=>2000,
            'amountpeople'=>250
        ]);
    }
}