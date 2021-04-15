<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;


class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id_user)
    {
        $pasien = Pasien::where('id_user', '=', $id_user)->get();
        $response = [
            'message' => 'List data pasien',
            'data' => $pasien
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
            'nama' => ['required'],
            'id_bangsal' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $pasien = Pasien::create($request->all());
            $response = [
                'message' => 'Pasien created',
                'data' => $pasien
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
        $pasien = Pasien::findOrFail($id);
        $response = [
            'message' => 'Detail data pasien',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function avgSisa($id_user)
    {
        $pasien = DB::table('sisa_pagis')
            ->Join('pasiens', 'pasiens.id', '=', 'sisa_pagis.id_pasien')
            ->Join('sisa_siangs', 'pasiens.id', '=', 'sisa_siangs.id_pasien')
            ->Join('sisa_malams', 'pasiens.id', '=', 'sisa_malams.id_pasien')
            ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
            ->select('bangsals.siklus', DB::raw('(((avg(sisa_pagis.makanan_pokok)+avg(sisa_siangs.makanan_pokok)+avg(sisa_malams.makanan_pokok))/3)+((avg(sisa_pagis.lauk_hewani)+avg(sisa_siangs.lauk_hewani)+avg(sisa_malams.lauk_hewani))/3)+((avg(sisa_pagis.lauk_nabati)+avg(sisa_siangs.lauk_nabati)+avg(sisa_malams.lauk_nabati))/3)+((avg(sisa_pagis.sayur)+avg(sisa_siangs.sayur)+avg(sisa_malams.sayur))/3)+((avg(sisa_pagis.buah)+avg(sisa_siangs.buah)+avg(sisa_malams.buah))/3)+((avg(sisa_pagis.snack)+avg(sisa_siangs.snack)+avg(sisa_malams.snack))/3))/6 as ratarata'))
            ->orderBy('bangsals.siklus', 'ASC')
            ->groupBy('bangsals.siklus')
            ->where('id_user', '=', $id_user)
            ->get();
        $response = [
            'message' => 'Rata-rata sisa makanan keseluruhan',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function avgSisaMakanan($id_user)
    {
        $pasien = DB::table('sisa_pagis')
            ->Join('pasiens', 'pasiens.id', '=', 'sisa_pagis.id_pasien')
            ->Join('sisa_siangs', 'pasiens.id', '=', 'sisa_siangs.id_pasien')
            ->Join('sisa_malams', 'pasiens.id', '=', 'sisa_malams.id_pasien')
            ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
            ->select('bangsals.siklus', DB::raw('(avg(sisa_pagis.makanan_pokok)+avg(sisa_siangs.makanan_pokok)+avg(sisa_malams.makanan_pokok))/3 as makanan_pokok, (avg(sisa_pagis.lauk_hewani)+avg(sisa_siangs.lauk_hewani)+avg(sisa_malams.lauk_hewani))/3 as lauk_hewani, (avg(sisa_pagis.lauk_nabati)+avg(sisa_siangs.lauk_nabati)+avg(sisa_malams.lauk_nabati))/3 as lauk_nabati,(avg(sisa_pagis.sayur)+avg(sisa_siangs.sayur)+avg(sisa_malams.sayur))/3 as sayur,(avg(sisa_pagis.buah)+avg(sisa_siangs.buah)+avg(sisa_malams.buah))/3 as buah,(avg(sisa_pagis.snack)+avg(sisa_siangs.snack)+avg(sisa_malams.snack))/3 as snack'))
            ->orderBy('bangsals.siklus', 'ASC')
            ->groupBy('bangsals.siklus')
            ->where('id_user', '=', $id_user)
            ->get();
        $response = [
            'message' => 'Rata-rata sisa makanan menurut kelompok makanan keseluruhan',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function avgLengkap($id_user)
    {
        $pasien = DB::table('sisa_pagis')
            ->Join('pasiens', 'pasiens.id', '=', 'sisa_pagis.id_pasien')
            ->Join('sisa_siangs', 'pasiens.id', '=', 'sisa_siangs.id_pasien')
            ->Join('sisa_malams', 'pasiens.id', '=', 'sisa_malams.id_pasien')
            ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
            ->select(DB::raw('bangsals.siklus, avg(sisa_pagis.makanan_pokok) as makanan_pokok_pagi, avg(sisa_siangs.makanan_pokok) as makanan_pokok_siang, avg(sisa_malams.makanan_pokok) as makanan_pokok_malam, avg(sisa_pagis.lauk_hewani) as lauk_hewani_pagi,avg(sisa_siangs.lauk_hewani) as lauk_hewani_siang, avg(sisa_malams.lauk_hewani) as lauk_hewani_malam, avg(sisa_pagis.lauk_nabati) as lauk_nabati_pagi,avg(sisa_siangs.lauk_nabati) as lauk_nabati_siang,avg(sisa_malams.lauk_nabati) as lauk_nabati_malam,avg(sisa_pagis.sayur) as sayur_pagi,avg(sisa_siangs.sayur) as sayur_siang,avg(sisa_malams.sayur) as sayur_malam,avg(sisa_pagis.buah) as buah_pagi,avg(sisa_siangs.buah) as buah_siang,avg(sisa_malams.buah) as buah_malam,avg(sisa_pagis.snack) as snack_pagi,avg(sisa_siangs.snack) as snack_siang, avg(sisa_malams.snack) as snack_malam,(avg(sisa_pagis.makanan_pokok)+avg(sisa_pagis.lauk_hewani)+avg(sisa_pagis.lauk_nabati)+avg(sisa_pagis.sayur)+avg(sisa_pagis.buah)+avg(sisa_pagis.snack))/6 as ratarata_pagi, (avg(sisa_siangs.makanan_pokok)+avg(sisa_siangs.lauk_hewani)+avg(sisa_siangs.lauk_nabati)+avg(sisa_siangs.sayur)+avg(sisa_siangs.buah)+avg(sisa_siangs.snack))/6 as ratarata_siang,(avg(sisa_malams.makanan_pokok)+avg(sisa_malams.lauk_hewani)+avg(sisa_malams.lauk_nabati)+avg(sisa_malams.sayur)+avg(sisa_malams.buah)+avg(sisa_malams.snack))/6 as ratarata_malam,(((avg(sisa_pagis.makanan_pokok)+avg(sisa_siangs.makanan_pokok)+avg(sisa_malams.makanan_pokok))/3)+((avg(sisa_pagis.lauk_hewani)+avg(sisa_siangs.lauk_hewani)+avg(sisa_malams.lauk_hewani))/3)+((avg(sisa_pagis.lauk_nabati)+avg(sisa_siangs.lauk_nabati)+avg(sisa_malams.lauk_nabati))/3)+((avg(sisa_pagis.sayur)+avg(sisa_siangs.sayur)+avg(sisa_malams.sayur))/3)+((avg(sisa_pagis.buah)+avg(sisa_siangs.buah)+avg(sisa_malams.buah))/3)+((avg(sisa_pagis.snack)+avg(sisa_siangs.snack)+avg(sisa_malams.snack))/3))/6 as ratarata'))
            ->orderBy('bangsals.siklus', 'ASC')
            ->groupBy('bangsals.siklus')
            ->where('id_user', '=', $id_user)
            ->get();
        $response = [
            'message' => 'Rata-rata lengkap',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function avgSisaBangsal($id_bangsal)
    {
        $pasien = DB::table('sisa_pagis')
            ->Join('pasiens', 'pasiens.id', '=', 'sisa_pagis.id_pasien')
            ->Join('sisa_siangs', 'pasiens.id', '=', 'sisa_siangs.id_pasien')
            ->Join('sisa_malams', 'pasiens.id', '=', 'sisa_malams.id_pasien')
            ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
            ->select('bangsals.siklus', DB::raw('bangsals.nama, (((avg(sisa_pagis.makanan_pokok)+avg(sisa_siangs.makanan_pokok)+avg(sisa_malams.makanan_pokok))/3)+((avg(sisa_pagis.lauk_hewani)+avg(sisa_siangs.lauk_hewani)+avg(sisa_malams.lauk_hewani))/3)+((avg(sisa_pagis.lauk_nabati)+avg(sisa_siangs.lauk_nabati)+avg(sisa_malams.lauk_nabati))/3)+((avg(sisa_pagis.sayur)+avg(sisa_siangs.sayur)+avg(sisa_malams.sayur))/3)+((avg(sisa_pagis.buah)+avg(sisa_siangs.buah)+avg(sisa_malams.buah))/3)+((avg(sisa_pagis.snack)+avg(sisa_siangs.snack)+avg(sisa_malams.snack))/3))/6 as ratarata'))
            ->where('bangsals.id', '=', $id_bangsal)
            ->groupBy('bangsals.id')
            ->get();
        $response = [
            'message' => 'Rata-rata sisa makanan keseluruhan bangsal',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function avgSisaMakananBangsal($id_bangsal)
    {
        $pasien = DB::table('sisa_pagis')
            ->Join('pasiens', 'pasiens.id', '=', 'sisa_pagis.id_pasien')
            ->Join('sisa_siangs', 'pasiens.id', '=', 'sisa_siangs.id_pasien')
            ->Join('sisa_malams', 'pasiens.id', '=', 'sisa_malams.id_pasien')
            ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
            ->select('bangsals.siklus', DB::raw('bangsals.nama,(avg(sisa_pagis.makanan_pokok)+avg(sisa_siangs.makanan_pokok)+avg(sisa_malams.makanan_pokok))/3 as makanan_pokok, (avg(sisa_pagis.lauk_hewani)+avg(sisa_siangs.lauk_hewani)+avg(sisa_malams.lauk_hewani))/3 as lauk_hewani, (avg(sisa_pagis.lauk_nabati)+avg(sisa_siangs.lauk_nabati)+avg(sisa_malams.lauk_nabati))/3 as lauk_nabati,(avg(sisa_pagis.sayur)+avg(sisa_siangs.sayur)+avg(sisa_malams.sayur))/3 as sayur,(avg(sisa_pagis.buah)+avg(sisa_siangs.buah)+avg(sisa_malams.buah))/3 as buah,(avg(sisa_pagis.snack)+avg(sisa_siangs.snack)+avg(sisa_malams.snack))/3 as snack'))
            ->where('bangsals.id', '=', $id_bangsal)
            ->groupBy('bangsals.id')
            ->get();
        $response = [
            'message' => 'Rata-rata sisa makanan menurut kelompok makanan keseluruhan bangsal',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }
    public function avgLengkapBangsal($id_bangsal)
    {
        $pasien = DB::table('sisa_pagis')
            ->Join('pasiens', 'pasiens.id', '=', 'sisa_pagis.id_pasien')
            ->Join('sisa_siangs', 'pasiens.id', '=', 'sisa_siangs.id_pasien')
            ->Join('sisa_malams', 'pasiens.id', '=', 'sisa_malams.id_pasien')
            ->Join('bangsals', 'bangsals.id', '=', 'pasiens.id_bangsal')
            ->select(DB::raw('bangsals.nama as nama_bangsal, bangsals.id, bangsals.siklus, pasiens.nama, pasiens.no_rekam_medis, (sisa_pagis.makanan_pokok) as makanan_pokok_pagi, (sisa_siangs.makanan_pokok) as makanan_pokok_siang, (sisa_malams.makanan_pokok) as makanan_pokok_malam, (sisa_pagis.lauk_hewani) as lauk_hewani_pagi,(sisa_siangs.lauk_hewani) as lauk_hewani_siang, (sisa_malams.lauk_hewani) as lauk_hewani_malam, (sisa_pagis.lauk_nabati) as lauk_nabati_pagi,(sisa_siangs.lauk_nabati) as lauk_nabati_siang,(sisa_malams.lauk_nabati) as lauk_nabati_malam,(sisa_pagis.sayur) as sayur_pagi,(sisa_siangs.sayur) as sayur_siang,(sisa_malams.sayur) as sayur_malam,(sisa_pagis.buah) as buah_pagi,(sisa_siangs.buah) as buah_siang,(sisa_malams.buah) as buah_malam,(sisa_pagis.snack) as snack_pagi,(sisa_siangs.snack) as snack_siang, (sisa_malams.snack) as snack_malam'))
            ->where('bangsals.id', '=', $id_bangsal)
            ->orderBy('pasiens.no_rekam_medis', 'ASC')
            ->get();
        $response = [
            'message' => 'Rata-rata lengkap bangsal',
            'data' => $pasien
        ];
        return response()->json($response, Response::HTTP_OK);
    }

    public function showBangsal($id_bangsal)
    {
        $pasien = DB::table('pasiens')
            ->where('id_bangsal', '=', $id_bangsal)
            ->get();
        $response = [
            'message' => 'Data pasien bangsal',
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
        $pasien = Pasien::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama' => ['required'],
            'id_bangsal' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $pasien->update($request->all());
            $response = [
                'message' => 'Pasien updated',
                'data' => $pasien
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
        $pasien = Pasien::findOrFail($id);
        try {
            $pasien->delete();
            $response = [
                'message' => 'Pasien deleted',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}
