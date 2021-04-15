<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\QueryException;
class UserController extends Controller
{
    // 

    public function index(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' =>  ['required', 'email'],
            'password' => 'required',
        ]);
        if ($validate->fails()) {
            $respon = [
                'status' => 'error',
                'message' => 'Validator error',
                'errors' => $validate->errors(),
            ];
            return response()->json($respon, 200);
        } else {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                return response()->json([
                    'success'   => false,
                    'message' => ['Email tidak terdaftar.']
                ]);
            }
            else if(!Hash::check($request->password, $user->password)){
                return response()->json([
                    'success'   => false,
                    'message' => ['Password yang anda masukkan salah.']
                ]);
            }

            $id_user = $user->id;
            $tokenResult = $user->createToken('token-auth')->plainTextToken;
            
            $respon = [
                'success'   => true,
                'message' => 'Berhasil login',
                'content' => [
                    'id_user' => $id_user,
                    'status_code' => 200,
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                ]
            ];
            return response()->json($respon, 200);
        }
    }
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' =>  ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            $response = [
                'message' => 'user created',
                'data' => $user
            ];
            return response()->json($response, Response::HTTP_CREATED);
        } catch (QueryException $e) {
            return response()->json([
                'message' => "Failed" . $e->errorInfo
            ]);
        }
    }
    
    /**
     * logout
     *
     * @return void
     */
    public function logout(Request $request) {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        $respon = [
            'status' => 'success',
            'message' => 'Berhasil logout',
        ];
        return response()->json($respon, 200);
    }
}