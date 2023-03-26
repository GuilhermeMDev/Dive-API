<?php

namespace Tests\app\Http\Controllers;

use App\Http\Controllers\DiveTableController;
use App\Models\DataDive;
use Illuminate\Http\Request;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

//do próprio laravel.

# php artisan test --filter=DiveTableControllerTest
class DiveTableControllerTest extends TestCase
{

    # php artisan test --filter=DiveTableControllerTest::test_index
    public function test_full_no_descompressive_dive_table()
    {
        $noDescompressiveTable = $this->getJson('/api/dive-table');

        $noDescompressiveTable->assertHeader('Content-Type', 'application/json');
        $noDescompressiveTable->assertStatus(200);
    }

    # php artisan test --filter=DiveTableControllerTest::test_no_descompressive_dive
    public function test_no_descompressive_dive()
    {

        $diveTableList = $this->getJson('/api/no-descompressive-dive/',
            ['depth' => 80]); #feets

        $diveTableList->assertHeader('Content-Type', 'application/json');
        $this->assertIsObject($diveTableList, "The list must be a Object!");
    }

    # php artisan test --filter=DiveTableControllerTest::test_repetitive_group
    public function test_repetitive_group()
    {
        $repetitiveGroup = $this->getJson('/api/repetitiveGroup/',
            [
                'depth' => 80, #feets (fsw)
                'depthTime' => 22 #minutes
            ]);

        $repetitiveGroup->assertHeader('Content-Type', 'application/json');
        $this->assertIsObject($repetitiveGroup, "The item must be a Object");
    }

    # php artisan test --filter=DiveTableControllerTest::test_surface_interval
    public function test_surface_interval()
    {
        $surfaceInterval = $this->getJson('/api/surface-interval/',
            [
                'lastLetter' => 'D', #Last repetitive Group, by first or last dive.
                'intervalTime' => 120 #minutes
            ]);

        $surfaceInterval->assertHeader('Content-Type', 'application/json');
        $this->assertIsObject($surfaceInterval, "The item must be a Object");
    }

    # php artisan test --filter=DiveTableControllerTest::test_successive_dive
    public function test_successive_dive()
    {
        $successiveDive = $this->getJson('/api/successive-dive/',
            [
                'endGroup' => 'c', #repetitive Group founded in surface-interval.
                'successiveDepth' => 60 #feets, dive schedule to next dive. (fsw)
            ]);

//        $successiveDive->assertJson(array $successiveDive,false);
        $successiveDive->assertHeader('Content-Type', 'application/json');
        $this->assertIsObject($successiveDive, "The item must be a Object");

    }

    # php artisan test --filter=DiveTableControllerTest::test_last_repetitive_group
    public function test_last_repetitive_group()
    {
        $depth = rand(0,190);
        $response = $this->get("/api/no-descompressive-dive/?depth={$depth}");
        $response->assertStatus(200);
    }
}
