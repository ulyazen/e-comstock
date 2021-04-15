<?php

namespace App\Http\Controllers;

use App\Models\Sisa_pagi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class SisaPagiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_user)
    {
        $sisa_pagi = DB::table('sisa_pagis')
        ->Join('pasiens', 'pasiens.id', '=', 'sisa_pagis.id_pasien')
        ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
        ->select('sisa_pagis.id', 'pasiens.nama as nama_pasien', 'pasiens.no_rekam_medis','bangsals.nama as nama_bangsal', 'bangsals.siklus', 'bangsals.tanggal', 'sisa_pagis.makanan_pokok', 'sisa_pagis.lauk_hewani', 'sisa_pagis.lauk_nabati', 'sisa_pagis.sayur', 'sisa_pagis.buah', 'sisa_pagis.snack')
        ->orderBy('sisa_pagis.id', 'ASC')
        ->where('sisa_pagis.id_user', '=', $id_user)
        ->get();
        $response = [
            'message' => 'List data sisa_pagi',
            'data' => $sisa_pagi
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
            'id_pasien' => ['required', 'unique:sisa_pagis'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa_pagi = Sisa_pagi::create($request->all());
            $response = [
                'message' => 'Sisa_pagi created',
                'data' => $sisa_pagi
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
        $sisa_pagi = Sisa_pagi::findOrFail($id);
        $response = [
            'message' => 'Detail data sisa_pagi',
            'data' => $sisa_pagi
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function showPagi($id_pasien)
    {
        $pasien = DB::table('sisa_pagis')
            ->where('id_pasien', '=', $id_pasien)
            ->get();
        $response = [
            'message' => 'Detail data pasien pagi',
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
        $sisa_pagi = Sisa_pagi::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_pasien' => ['required'],

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa_pagi->update($request->all());
            $response = [
                'message' => 'Sisa_pagi updated',
                'data' => $sisa_pagi
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
        $sisa_pagi = Sisa_pagi::findOrFail($id);
        try {
            $sisa_pagi->delete();
            $response = [
                'message' => 'Sisa_pagi deleted',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}
