<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        try {
            $validateUser = validator::make($request->all(), [
                'name'      => 'required',
                'email'     => 'required|unique:users,email',
                'password'  => 'required',
                'password2' => 'required',
            ]);

            //失敗後回傳並終止
            if ($validateUser->fails()) {

                $errors = $validateUser->errors()->all();
                $message = "";

                for ($i = 0; $i < count($errors); $i++) {
                    if ($i === count($errors) - 1) {
                        $message = $message . $errors[$i];
                        continue;
                    }
                    $message = $message . $errors[$i] . '，';
                }

                return response()->json([
                    'status'    => false,
                    'message'   => $message
                ], 422);
            }

            if ($request->password !== $request->password2) {

                return response()->json([
                    'status'    => false,
                    'message'   => "密碼輸入不相等"
                ], 422);
            }

            $user = User::create([
                'name'          => $request->name,
                'password'   => Hash::make($request->password),
                'email'      => $request->email,
            ]);

            if ($user) {
                return response()->json([
                    'status'    => true,
                    'message'   => "註冊成功"
                ], 200);
            } else {
                return response()->json([
                    'status'    => false,
                    'message'   => "註冊失敗"
                ], 400);
            }
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([
                'status'    => false,
                'message'   => "註冊失敗"
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }

    public function login(Request $request)
    {

        try {
            $validateUser = validator::make($request->all(), [
                'email'     => 'required',
                'password'  => 'required',
            ]);

            //失敗後回傳並終止
            if ($validateUser->fails()) {

                $errors = $validateUser->errors()->all();
                $message = "";

                for ($i = 0; $i < count($errors); $i++) {
                    if ($i === count($errors) - 1) {
                        $message = $message . $errors[$i];
                        continue;
                    }
                    $message = $message . $errors[$i] . '，';
                }

                return response()->json([
                    'status'    => false,
                    'message'   => $message
                ], 422);
            }

            if (Auth::attempt($request->only(['email', 'password']))) {
                $user = Auth::user();

                $scopes = ['read:users', 'write:users'];
                $token =  $user->createToken('MyApp')->accessToken;
                $name =  $user->name;

                return response()->json([
                    'status'    => true,
                    'message'   => $name . "登入成功",
                    'token'     => $token
                ], 200);
            } else {

                return response()->json([
                    'status'    => false,
                    'message'   => "登入失敗"
                ], 400);
            }
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json([
                'status'    => false,
                'message'   => "登入失敗"
            ], 500);
        }
    }

    public function logout(Request $request)
    {

        try {

            $bearerToken = $request->bearerToken();
            $tokenRepository = app(TokenRepository::class);
            $tokenRepository->revokeAccessToken($bearerToken);

            return response()->json([
                'status' => true,
                'message' => "登出成功",
            ], 200);
            
        } catch (\Throwable $th) {

            return response()->json([
                'status' => true,
                'message' => "錯誤",
            ], 500);
        }
    }
}
