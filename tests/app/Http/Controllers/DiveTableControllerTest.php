<?php

namespace Tests\app\Http\Controllers;

use App\Http\Controllers\DiveTableController;
use App\Models\DataDive;
use Illuminate\Http\Request;
use Tests\TestCase; //do próprio laravel.

# php artisan test --filter=DiveTableControllerTest
class DiveTableControllerTest extends TestCase
{

    # php artisan test --filter=DiveTableControllerTest::test_index
    public function test_index(){
        $response = $this->get('/api/dive-table');
        $response->assertStatus(200);
    }

    # php artisan test --filter=DiveTableControllerTest::test_no_descompressive_dive
    public function test_no_descompressive_dive(){

        $diveTableList = $this->get('/api/no-descompressive-dive/',
            ['depth' => 80]); #feets
        $this->assertIsObject($diveTableList, "The list must be a Object!");
    }

    # php artisan test --filter=DiveTableControllerTest::test_repetitive_group
    public function test_repetitive_group(){
        $repetitiveGroup = $this->get('/api/repetitiveGroup/',
            [
                'depth' => 80, #feets (fsw)
                'depthTime' => 22 #minutes
            ]);
        $this->assertIsObject($repetitiveGroup, "The item must be a Object");
    }

    # php artisan test --filter=DiveTableControllerTest::test_surface_interval
    public function test_surface_interval()
    {
        $surfaceInterval = $this->get('/api/surface-interval/',
            [
                'lastLetter' => 'D', #Last repetitive Group, by first or last dive.
                'intervalTime' => 120 #minutes
            ]);
        $this->assertIsObject($surfaceInterval, "The item must be a Object");
    }

    # php artisan test --filter=DiveTableControllerTest::test_successive_dive
    public function test_successive_dive()
    {
        $sucessiveDive = $this->get('/api/successive-dive/',
            [
                'endGroup' => 'c', #repetitive Group founded in surface-interval.
                'successiveDepth' => 60 #feets, dive schedule to next dive. (fsw)
            ]);

        $this->assertIsObject($sucessiveDive, "The item must be a Object");
    }
}
