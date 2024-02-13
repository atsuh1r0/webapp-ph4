<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use App\Models\StudyTime;
use App\Models\Languages;
use App\Models\Contents;

class StudyTimeController extends Controller
{
    /**
     * 学習時間の一覧を表示
     */
    public function index()
    {
        // 現在が何周目かを取得
        $currentWeek = Date::now()->weekOfMonth;

        return view('study_time/index')
            ->with('currentWeek', $currentWeek)
            ->with('todayStudyHour', 0)
            ->with('monthStudyHour', 10)
            ->with('totalStudyHour', 20)
            ->with('displayYear', Date::now()->year)
            ->with('displayMonth', Date::now()->month);
    }

    /**
     * 棒グラフ用のデータを取得・整形して返す
     */
    public function getBarChartData()
    {
        // 今月の1日の0時0分0秒
        $startOfMonth = now()->startOfMonth();
        // 今月の最終日の23時59分59秒
        $endOfMonth = now()->endOfMonth();
        $studyTimes = StudyTime::whereBetween('created_at', [$startOfMonth, $endOfMonth])
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
        $languages = Languages::all();
        $data = collect();
        foreach ($languages as $language) {
            // ここで時間を計算する
            // 今月の1日の0時0分0秒
            $startOfMonth = now()->startOfMonth();
            // 今月の最終日の23時59分59秒
            $endOfMonth = now()->endOfMonth();
            $amount = StudyTime::whereBetween('created_at', [$startOfMonth, $endOfMonth])
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
        $contents = Contents::all();
        $data = collect();
        foreach ($contents as $content) {
            // ここで時間を計算する
            // 今月の1日の0時0分0秒
            $startOfMonth = now()->startOfMonth();
            // 今月の最終日の23時59分59秒
            $endOfMonth = now()->endOfMonth();
            $amount = StudyTime::whereBetween('created_at', [$startOfMonth, $endOfMonth])
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
}
