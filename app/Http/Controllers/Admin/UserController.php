<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //会員一覧ページ　
    class UserController extends Controller {
        public function index() {
            return view('index');
        }
    }
    //検索ボックスに入力されたキーワードが存在する場合は、氏名またはフリガナで部分一致検索を行う
    DB::table('users')->select('name','kana')->get();
    $users = User::where("name", "kana")->get();

    //検索ボックスに入力されたキーワード
     $keyword
    //取得したデータ（$users）の総数
     $total
}
