<?php

namespace Tests\app\Http\Controllers;

use App\Http\Controllers\DiveTableController;
use App\Models\DataDive;
use Illuminate\Http\Request;
use Tests\TestCase; //do próprio laravel.

# php artisan test --filter=DiveTableControllerTest
class DiveTableControllerTest extends TestCase
{

    /**
     * First check getting all list in db
     * @return void
     */
    public function test_index(){
        $response = $this->get('/api/dive-table');
        $response->assertStatus(200);
    }
    public function test_no_descompressive_dive(){

        $diveTableList = $this->get('/api/no-descompressive-dive/', ['depth' => 80]);
        $this->assertIsObject($diveTableList, "The list must be a String!");
    }
}
