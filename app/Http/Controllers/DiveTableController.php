<?php

namespace App\Http\Controllers;

use App\Models\DataDive;
use App\Models\DataDiveInterval;
use App\Models\DataDiveResidualNitrogen;
use App\Rules\checkDepth;
use App\Rules\checkRepetitiveGroup;
use http\Env\Response;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class DiveTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Builder|Model|object
     */

    //list all data about no stop limit in each depth to commercial dive.
    public function fullNoDescompressiveDiveTable()
    {
        return \response()->json([
            DataDive::all()
        ]);
    }

    public function noDescompressiveDive(Request $request)
    {
        $request->validate([
            'depth' => ['required', new checkDepth(0, 190)],
        ]);

        //"depth" parameter is informed in the URL, and it`s depth chose to dive
        //Ex: /api/tive-table-letter/?depth=11 returns only the dive profile of the consulted depth.
        $depth = (int)$request->query->get('depth');//type cast (int)

        $noLimitDescompressive = DataDive::query()
            ->where('maxfsw', '>=', $depth)
            ->orderBy('maxfsw')
            ->first();

        return response()->json([
            "data" => $noLimitDescompressive,
        ]);


    }

    //consult main dive table, and get repetitive group through depth reported.
    public function repetitiveGroup(Request $request)
    {

        $request->validate([
            'depth' => ['required', new checkDepth(0, 190)],
        ]);

        //Finding the table based on the given depth
        $repetitiveLetter = DataDive::query()
            ->where('maxfsw', '>=', (int)$request->query->get('depth')) //feet
            ->first()->getAttribute('values');

        //depth given by request
        $depthTime = (int)$request->query->get('depthTime');

        //After identify table cross depth, compare depth time and get Repetitive Group.
        foreach ($repetitiveLetter as $letter) {

            if ($depthTime >= $letter['minTime'] && $depthTime <= $letter['maxTime']) {
                return response()->json([
                    "data" => $letter['groupLetter']
                ]);

            };
        }

    }

    //Residual Nitrogen Time Table for Repetitive Air Dives.
    public function surfaceInterval(Request $request) //here we need get equivalent letter across surface interval after last dive.
    {

        $lastGroupRepetitive = (string)$request->query->get('lastLetter');
        $surfaceIntervalTime = (int)$request->query->get('intervalTime');

        $request->validate([
            'lastLetter' => ['required', new checkRepetitiveGroup()],
        ]);

        $initialGroup = DataDiveInterval::query()
            ->where('groupLetter', '=', $lastGroupRepetitive)
            ->where('maxTime', '>=', $surfaceIntervalTime) //focus to get first result  of consult, because we have others values with same letter.
            ->first();

        return response()->json([
            "data" => $initialGroup["repetLetter"],
        ]);
    }

    //Function responsible for returning the residual nitrogen value to calculate a successive dive
    public function calculateSuccessiveDive(Request $request)
    {


        $repetitiveGroupAfterSurfaceInterval = (string)$request->query->get('endGroup');
        $successiveDepth = (int)$request->query->get('successiveDepth'); //feets

        $request->validate([
            'endGroup' => ['required', new checkRepetitiveGroup()],
        ]);

        //Accessing residual nitrogen data equivalent to dive depth in the table
        $successiveDiveWithResidualNitrogen = DataDiveResidualNitrogen::query()
            ->where('repetLetter', '=', $repetitiveGroupAfterSurfaceInterval)
            ->first()->getAttribute('residualNitrogenTime');

        foreach ($successiveDiveWithResidualNitrogen as $residualNitrogen) {
            if ($successiveDepth >= $residualNitrogen['minDepth'] && $successiveDepth <= $residualNitrogen['maxDepth']) {
                $residualNitrogenTime = $residualNitrogen['residualNitrogenTime'];
            }
        }

        return response()->json([
            "residualNitrogenTime" => $residualNitrogenTime,
        ], 206);
    }


}
