<?php

namespace App\Http\Controllers;

use App\Models\Sisa_malam;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SisaMalamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sisa_malam = Sisa_malam::get();
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