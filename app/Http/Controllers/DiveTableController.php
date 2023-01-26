<?php

namespace App\Http\Controllers;

use App\Models\DataDive;
use Illuminate\Http\Request;

class DiveTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function index(Request $request) //Lista todas as tabelas, e se informar o parametro depth na URL ex: /api/tive-table-letter/?depth=11 retorna só o perfil do mergulho da profundidade consultada.
    {
        if ((int)$request->query->get('depth')) {
            return DataDive::query()
                ->where('maxfsw', '>=', (int)$request->query->get('depth')) //type cast -> forçando um tipo
                ->orderBy('maxfsw')
                ->first();
        }

        return DataDive::all();
    }

    public function repetitiveGroup(Request $request)
    {
        //Encontrando a tabela com base na profundidade informada
        $repetitiveLetter = DataDive::query()
            ->where('maxfsw', '>=', (int)$request->query->get('depth'))
            ->first()->getAttribute('values');

        //Aqui chega um inteiro, profundidade informada pelo client
        $depthTime = (int)$request->query->get('depthTime');

        //Após identificar a tabela através da profundidade, comparo o tempo de fundo para obter o Grupo Repetitivo
        foreach ($repetitiveLetter as $letter){

            if ($depthTime >= $letter['minTime'] && $depthTime <= $letter['maxTime']){
                return $letter['groupLetter'];
            };


        }
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
