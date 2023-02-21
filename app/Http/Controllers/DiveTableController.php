<?php

namespace App\Http\Controllers;

use App\Models\DataDive;
use App\Models\DataDiveInterval;
use Illuminate\Http\Request;

class DiveTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */


    //list all data about no stop limit in each depth to commercial dive.
    public function index(Request $request) //Lista todas as tabelas, e se informar o parametro depth na URL Ewx: /api/tive-table-letter/?depth=11 retorna só o perfil do mergulho da profundidade consultada.
    {
        if ((int)$request->query->get('depth')) {
            return DataDive::query()
                ->where('maxfsw', '>=', (int)$request->query->get('depth')) //type cast -> forçando um tipo
                ->orderBy('maxfsw')
                ->first();
        }

        return DataDive::all();
    }

    //consult main dive table, and get repetitive group through depth reported.
    public function repetitiveGroup(Request $request)
    {
        //Encontrando a tabela com base na profundidade informada
        $repetitiveLetter = DataDive::query()
            ->where('maxfsw', '>=', (int)$request->query->get('depth'))
            ->first()->getAttribute('values');

        //Aqui chega um inteiro, profundidade informada pelo usuário
        $depthTime = (int)$request->query->get('depthTime');

        //Após identificar a tabela através da profundidade, comparo o tempo de fundo para obter o Grupo Repetitivo
        foreach ($repetitiveLetter as $letter) {

            if ($depthTime >= $letter['minTime'] && $depthTime <= $letter['maxTime']) {
                return $letter['groupLetter'];
            };


        }
    }

    //Residual Nitrogen Time Table for Repetitive Air Dives.
    public function surfaceInterval(Request $request) //here i need get equivalent letter across surface interval after last dive.
    {
        $lastGroupRepetitive = (string)$request->query->get('lastLetter');
        $surfaceIntervalTime = (int)$request->query->get('intervalTime');

        $initialGroup =  DataDiveInterval::query()
            ->where('groupLetter', '=', $lastGroupRepetitive)
            ->where('maxTime', '>=', $surfaceIntervalTime) //focus to get first resulf of consult, because we have others values with same letter.
            ->first();

        return $initialGroup["repetLetter"];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $table
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function show(Request $request, $table)
    {
        dd($request->query->get('depth'));
    }

//        return \response()->json([
//            'message' => 'Tabela não localizada no banco de dados'
//        ], 404);
//    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
