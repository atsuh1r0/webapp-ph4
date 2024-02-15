<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class NewsController extends Controller
{

    public function index()
    {
        // apiでNewsを取得する
        $client = new Client();

        try {
            $response = $client->get('https://bkrs3waxwg.execute-api.ap-northeast-1.amazonaws.com/default/news');
            $data = json_decode($response->getBody(), true);
            // 取得したデータを処理するなどのロジックを追加する
        } catch (\Exception $e) {
            // エラーハンドリング
            return view('news.index')->with('error', 'ニュースの取得に失敗しました');
        }

        return view('news.index')->with('data', $data);
    }

    public function detail($id)
    {
        // apiでNewsの詳細を取得する
        $client = new Client();

        try {
            $response = $client->get('https://bkrs3waxwg.execute-api.ap-northeast-1.amazonaws.com/default/news/' . $id);
            $data = json_decode($response->getBody(), true);
            // 取得したデータを処理するなどのロジックを追加する
        } catch (\Exception $e) {
            // エラーハンドリング
            return view('news.detail')->with('error', 'ニュースの取得に失敗しました');
        }

        return view('news.detail')->with('data', $data[0]);
    }
}
