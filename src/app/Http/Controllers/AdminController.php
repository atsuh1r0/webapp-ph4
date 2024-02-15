<?php

namespace App\Http\Controllers;

use App\Models\Languages;
use App\Models\Contents;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        $languages = Languages::all();
        $contents = Contents::all();
        return view('admin.index')
            ->with('users', $users)
            ->with('languages', $languages)
            ->with('contents', $contents);
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
            // 物理削除
            User::destroy($request->id);
            return redirect()->route('admin.index')->with('success_user_delete', 'ユーザーを削除しました');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error_user_delete', 'ユーザーの削除に失敗しました');
        }
    }

    public function registerLanguage(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string|max:255',
            ]);

            Languages::create([
                'name' => $request->name,
                'color' => $request->color,
            ]);

            return redirect()->route('admin.index')->with('success_language_register', '言語を登録しました');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error_language_register', '言語の登録に失敗しました');
        }
    }

    public function deleteLanguage(Request $request)
    {
        try {
            // 論理削除
            Languages::find($request->id)->delete();
            return redirect()->route('admin.index')->with('success_language_delete', '言語を削除しました');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error_language_delete', '言語の削除に失敗しました');
        }
    }

    public function registerContent(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string|max:255',
            ]);

            Contents::create([
                'name' => $request->name,
                'color' => $request->color,
            ]);

            return redirect()->route('admin.index')->with('success_content_register', 'コンテンツを登録しました');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error_content_register', 'コンテンツの登録に失敗しました');
        }
    }

    public function deleteContent(Request $request)
    {
        try {
            // 論理削除
            Contents::find($request->id)->delete();
            return redirect()->route('admin.index')->with('success_content_delete', 'コンテンツを削除しました');
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->with('error_content_delete', 'コンテンツの削除に失敗しました');
        }
    }
}
