<?php

namespace Database\Seeders;

use App\Models\DataDive;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DataDiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataDiveJson = Storage::disk('local')->get('/json/database1.json');

        $diveTables = json_decode($dataDiveJson, true); //to be associated array

        foreach ($diveTables as $diveTable){
            DataDive::query()->updateOrCreate([
                'minfsw' => $diveTable['minfsw'],
                'maxfsw' => $diveTable['maxfsw'],
                'unlimited' => $diveTable['unlimited'],
                'noStopLimit' => $diveTable['noStopLimit'],
                'values' => $diveTable['values']
            ]);
        }
    }
}
