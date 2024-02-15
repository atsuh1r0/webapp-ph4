<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index')->with('users', $users);
    }

    public function registerUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
                'is_admin' => 'required|int',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'is_admin' => $request->is_admin,
            ]);

            return redirect()->route('admin.index')->with('success_user_register', '学習時間を記録しました');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error_user_register', '学習時間の記録に失敗しました');
        }
    }

    public function deleteUser(Request $request)
    {
        try {
            User::destroy($request->id);
            return redirect()->route('admin.index')->with('success_user_delete', 'ユーザーを削除しました');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error_user_delete', 'ユーザーの削除に失敗しました');
        }
    }
}
