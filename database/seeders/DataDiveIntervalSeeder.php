<?php

namespace Database\Seeders;

use App\Models\DataDive;
use App\Models\DataDiveInterval;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DataDiveIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataDiveSurfaceIntervalJson = Storage::disk('local')->get('/json/database2.json');

        $diveTableSurfaceInterval = json_decode($dataDiveSurfaceIntervalJson, true); //to be associated array

        foreach ($diveTableSurfaceInterval as $surfaceInterval){
            DataDiveInterval::query()->updateOrCreate([
                'groupLetter' => $surfaceInterval['groupLetter'],
                'minTime' => $surfaceInterval['minTime'],
                'maxTime' => $surfaceInterval['maxTime'],
                'repetLetter' => $surfaceInterval['repetLetter'],
            ]);
        }
    }
}
