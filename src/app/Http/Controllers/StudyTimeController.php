<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudyTimeController extends Controller
{
    /**
     * 学習時間の一覧を表示
     */
    public function index()
    {
        return view('study_time/index');
    }
}
