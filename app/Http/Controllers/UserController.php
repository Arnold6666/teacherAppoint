<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
                session()->flash('status', false);
                session()->flash('message', '所有欄位必填');
                session()->flash('errors', $validateUser->errors());

                return redirect()->back()->withInput();
            }

            if ($request->password !== $request->password2) {
                session()->flash('status', false);
                session()->flash('message', '密碼不相等');
                session()->flash('errors', $validateUser->errors());

                return redirect()->back()->withInput();
            }

            $user = User::create([
                'name'          => $request->name,
                'password'   => Hash::make($request->password),
                'email'      => $request->email,
            ]);

            if ($user) {
                session()->flash('status', true);
                session()->flash('message', '註冊成功');

                return redirect()->back();
            } else {
                session()->flash('status', false);
                session()->flash('message', '註冊失敗');

                return redirect()->back();
            }
        } catch (\Throwable $th) {
            //throw $th;

            session()->flash('message', $th->getMessage());

            return redirect()->back();
        }

        // return "OK";
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
                session()->flash('status', false);
                session()->flash('message', '沒有填寫帳號或密碼');

                return redirect()->back()->withInput();
            }

            if (Auth::attempt($request->only(['email', 'password']))) {
                session()->flash('status', true);
                session()->flash('message', '登入成功');
                $userId = Auth::user()->id;
                $userName = Auth::user()->name;

                Session::put('userId', $userId);
                Session::put('userName', $userName);

                return redirect()->back();
            } else {

                session()->flash('status', true);
                session()->flash('message', '帳號或密碼錯誤');
                return redirect()->back()->withInput();
            }
        } catch (\Throwable $th) {
            //throw $th;

            session()->flash('message', $th->getMessage());

            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->flush();

        // 重定向到登出後的頁面或首頁
        return redirect('/');
    }
}
