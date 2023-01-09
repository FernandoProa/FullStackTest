<?php

namespace App\Http\Controllers;

use App\Imports\ZipCodeImport;

use App\Models\ZipCodeStates;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ZipCodeController extends Controller
{
    //
    public function search($zipCode)
    {
        try {
            $search = DB::table('zip_code_states')->select('id_asenta_cpcons', 'd_asenta', 'd_zona', 'd_tipo_asenta', 'd_codigo', 'c_estado', 'd_estado', 'c_mnpio', 'd_mnpio')
                ->where('d_codigo', $zipCode)->get();

            if($search->count() == 0){
                return response()->json([
                    'message' => 'not found'
                ], 400);

            }

            $result = $this->formatResponse($search);

            return response()->json($result, 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'server error',
                'done' => false
            ], 500);
        }


    }

    protected function formatResponse($data)
    {
        $settlements = [];

        foreach ($data as $settlement) {
            $settlements[] = ["key" => $settlement->id_asenta_cpcons,
                "name" => $settlement->d_asenta,
                "zone_type" => $settlement->d_zona,
                "settlement_type" => [
                    "name" => $settlement->d_tipo_asenta],

            ];
        }
        return [
            "zip_code" => $data[0]->d_codigo,
            "locality" => $data[0]->d_ciudad ?? '',
            "federal_entity" => [
                "key" => $data[0]->c_estado,
                "name" => $data[0]->d_estado,
                "code" => $data[0]->c_cp ?? ''
            ],
            "settlements" => [$settlements],
            "municipality" => [
                "key" => $data[0]->c_mnpio,
                "name" => $data[0]->d_mnpio
            ]

        ];

    }
}
