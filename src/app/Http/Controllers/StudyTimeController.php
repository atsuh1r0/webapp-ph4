<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\StudyTime;
use App\Models\Languages;
use App\Models\Contents;
use Illuminate\Support\Facades\Auth;

class StudyTimeController extends Controller
{
    /**
     * 学習時間の一覧を表示
     */
    public function index()
    {
        $user = Auth::user();

        // 現在が何周目かを取得
        $currentWeek = Date::now()->weekOfMonth;

        // 学習時間を取得
        $todayStudyHour = $user->studyTimes()->whereDate('created_at', Date::now())->sum('time');
        $monthStudyHour = $user->studyTimes()->whereMonth('created_at', Date::now()->month)->sum('time');
        $totalStudyHour = $user->studyTimes()->sum('time');

        return view('study_time/index')
            ->with('currentWeek', $currentWeek)
            ->with('todayStudyHour', $todayStudyHour)
            ->with('monthStudyHour', $monthStudyHour)
            ->with('totalStudyHour', $totalStudyHour)
            ->with('displayYear', Date::now()->year)
            ->with('displayMonth', Date::now()->month);
    }

    /**
     * 棒グラフ用のデータを取得・整形して返す
     */
    public function getBarChartData()
    {
        $user = Auth::user();

        // 今月の1日の0時0分0秒
        $startOfMonth = now()->startOfMonth();
        // 今月の最終日の23時59分59秒
        $endOfMonth = now()->endOfMonth();
        $studyTimes = $user->studyTimes()->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE_FORMAT(created_at, "%d") AS date')
            ->selectRaw('SUM(time) AS timeOfDay')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        $data = collect();
        for ($day = 1; $day <= $endOfMonth->day; $day++) {
            $studyTime = $studyTimes->firstWhere('date', $day);
            if ($studyTime) {
                $data->push([
                    'date' => $day,
                    'time' => (int)$studyTime->timeOfDay,
                ]);
            } else {
                $data->push([
                    'date' => $day,
                    'time' => 0,
                ]);
            }
        }
        return response()->json($data);
    }

    /**
     * 言語の円グラフ用のデータを取得・整形して返す
     */
    public function getLanguagesPieChartData()
    {
        $user = Auth::user();

        $languages = Languages::all();
        $data = collect();
        foreach ($languages as $language) {
            // ここで時間を計算する
            // 今月の1日の0時0分0秒
            $startOfMonth = now()->startOfMonth();
            // 今月の最終日の23時59分59秒
            $endOfMonth = now()->endOfMonth();
            $amount = $user->studyTimes()->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('language_id', $language->id)
                ->sum('time');
            $data->push([
                'name' => $language->name,
                'hour' => $amount,
                'color' => $language->color,
            ]);
        }
        return response()->json($data);
    }

    /**
     * コンテンツの円グラフ用のデータを取得・整形して返す
     */
    public function getContentsPieChartData()
    {
        $user = Auth::user();

        $contents = Contents::all();
        $data = collect();
        foreach ($contents as $content) {
            // ここで時間を計算する
            // 今月の1日の0時0分0秒
            $startOfMonth = now()->startOfMonth();
            // 今月の最終日の23時59分59秒
            $endOfMonth = now()->endOfMonth();
            $amount = $user->studyTimes()->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('content_id', $content->id)
                ->sum('time');
            $data->push([
                'name' => $content->name,
                'hour' => $amount,
                'color' => $content->color,
            ]);
        }
        return response()->json($data);
    }

    /**
     * 学習時間の記録を追加
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        try {
            foreach ($request->languages as $language) {
                foreach ($request->contents as $content) {
                    $studyTime = new StudyTime();
                    $studyTime->created_at = $request->date;
                    $studyTime->time = $request->time / (count($request->languages) * count($request->contents));
                    $studyTime->language_id = $language;
                    $studyTime->content_id = $content;
                    $studyTime->user_id = $user->id;
                    $studyTime->save();
                }
            }
            return redirect('/')->with('success', '学習時間を記録しました');
        } catch (\Exception $e) {
            return redirect('/')->with('error', '学習時間の記録に失敗しました');
        }
    }
}
