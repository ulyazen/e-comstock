<?php

namespace App\Http\Controllers;

use App\Models\Sisa_malam;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class SisaMalamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sisa_malam = DB::table('sisa_malams')
        ->Join('pasiens', 'pasiens.id', '=', 'sisa_malams.id_pasien')
        ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
        ->select('sisa_malams.id', 'pasiens.nama as nama_pasien', 'pasiens.no_rekam_medis','bangsals.nama as nama_bangsal', 'bangsals.siklus', 'bangsals.tanggal', 'sisa_malams.makanan_pokok', 'sisa_malams.lauk_hewani', 'sisa_malams.lauk_nabati', 'sisa_malams.sayur', 'sisa_malams.buah', 'sisa_malams.snack')
        ->orderBy('sisa_malams.id', 'ASC')
        ->get();
        $response = [
            'message' => 'List data sisa_malam',
            'data' => $sisa_malam
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pasien' =>  ['required', 'unique:sisa_malams'],

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa_malam = Sisa_malam::create($request->all());
            $response = [
                'message' => 'Sisa_malam created',
                'data' => $sisa_malam
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sisa_malam = Sisa_malam::findOrFail($id);
        $response = [
            'message' => 'Detail data sisa_malam',
            'data' => $sisa_malam
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function showMalam($id_pasien)
    {
        $pasien = DB::table('sisa_malams')
            ->where('id_pasien', '=', $id_pasien)
            ->get();
        $response = [
            'message' => 'Detail data pasien malam',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $sisa_malam = Sisa_malam::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_pasien' => ['required'],

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa_malam->update($request->all());
            $response = [
                'message' => 'Sisa_malam updated',
                'data' => $sisa_malam
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sisa_malam = Sisa_malam::findOrFail($id);
        try {
            $sisa_malam->delete();
            $response = [
                'message' => 'Sisa_malam deleted',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}
