<?php

namespace Database\Seeders;

use App\Models\DataDiveResidualNitrogen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DataDiveResidualNitrogenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataResidualNitrogenTimesJson = Storage::disk('local')->get('/json/database3.json');

        $residualNitrogenTimes = json_decode($dataResidualNitrogenTimesJson, true);

        foreach ($residualNitrogenTimes as $residualNitrogenTime){
            DataDiveResidualNitrogen::query()->updateOrCreate([
                'repetLetter' => $residualNitrogenTime['repetLetter'],
                'residualNitrogenTime' => $residualNitrogenTime['residualNitrogenTime']
            ]);
        }
    }
}
