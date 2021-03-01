<?php

namespace App\Http\Controllers;

use App\Models\Sisa_siang;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SisaSiangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sisa_siang = Sisa_siang::get();
        $response = [
            'message' => 'List data sisa_siang',
            'data' => $sisa_siang
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
            'id_pasien' => ['required'],
            'makanan_pokok' => ['required'],
            'lauk_hewani' => ['required'],
            'lauk_nabati' => ['required'],
            'sayur' => ['required'],
            'buah' => ['required'],
            'minum' => ['required'],
            'snack' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa_siang = Sisa_siang::create($request->all());
            $response = [
                'message' => 'Sisa_siang created',
                'data' => $sisa_siang
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
        $sisa_siang = Sisa_siang::findOrFail($id);
        $response = [
            'message' => 'Detail data sisa_siang',
            'data' => $sisa_siang
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
        $sisa_siang = Sisa_siang::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'id_pasien' => ['required'],
            'makanan_pokok' => ['required'],
            'lauk_hewani' => ['required'],
            'lauk_nabati' => ['required'],
            'sayur' => ['required'],
            'buah' => ['required'],
            'minum' => ['required'],
            'snack' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa_siang->update($request->all());
            $response = [
                'message' => 'Sisa_siang updated',
                'data' => $sisa_siang
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
        $sisa_siang = Sisa_siang::findOrFail($id);
        try {
            $sisa_siang->delete();
            $response = [
                'message' => 'Sisa_siang deleted',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}