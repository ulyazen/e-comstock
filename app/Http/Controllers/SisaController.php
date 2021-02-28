<?php

namespace App\Http\Controllers;

use App\Models\Sisa;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sisa = Sisa::get();
        $response = [
            'message' => 'List data sisa',
            'data' => $sisa
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
            'nilai' => ['required'],
            'jenis_makanan' => ['required', 'in:Makanan Pokok,Lauk Hewani,Lauk Nabati,Sayur,Buah,Minum,Snack'],
            'waktu' => ['required', 'in:Pagi,Siang,Malam'],
            'id_pasien' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa = Sisa::create($request->all());
            $response = [
                'message' => 'Sisa created',
                'data' => $sisa
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
        $sisa = Sisa::findOrFail($id);
        $response = [
            'message' => 'Detail data sisa',
            'data' => $sisa
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
        $sisa = Sisa::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nilai' => ['required'],
            'jenis_makanan' => ['required', 'in:Makanan Pokok,Lauk Hewani,Lauk Nabati,Sayur,Buah,Minum,Snack'],
            'waktu' => ['required', 'in:Pagi,Siang,Malam'],
            'id_pasien' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $sisa->update($request->all());
            $response = [
                'message' => 'Sisa updated',
                'data' => $sisa
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
        $sisa = Sisa::findOrFail($id);
        try {
            $sisa->delete();
            $response = [
                'message' => 'Sisa deleted',
            ];
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
}
