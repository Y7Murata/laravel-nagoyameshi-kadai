<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// カテゴリーモデル追加
use App\Models\Category;

class CategoryController extends Controller
{
  // -----
  // index アクション
  // ------
  public function index(Request $request) {
    // 検索ボックスに入力されたキーワードを取得する
    $keyword = $request->input('keyword');

    // キーワードが存在すれば検索を行い、そうでなければ全件取得する
    if ($keyword) {
        $categories = Category::where('name', 'like', "%{$keyword}%")->paginate(15);
    } else {
        $categories = category::paginate(15);
    }

    $total = $categories->total();

    return view('admin.categories.index', compact('categories', 'keyword', 'total'));
}
  // -----
  // store アクション
  // ------
  
  //バリデーション
  public function store(Request $request) {
    $request->validate([
        'name' => 'required',
    ]);
  //処理の内容
    $category = new Category();
        $category->name = $request->input('name');
  //保存する
    $category->save();
  
  //リダイレクト先とフラッシュメッセージ
      return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを登録しました。');
    }

  // -----
  // update アクション
  // ------
   
  //バリデーション
   public function update(Request $request,Category $category) {
    $request->validate([
        'name' => 'required',
    ]);

  //処理内容
        $category->name = $request->input('name');
        $category->save();

  //リダイレクト先とフラッシュメッセージ
      return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを編集しました。');
    }

  // -----
  // destroyアクション
  // ------
    public function destroy(Category $category) {
          
  //処理内容 削除処理
        $category->delete();

  // リダイレクト先とフラッシュメッセージ
      return redirect()->route('admin.categories.index')->with('flash_message', 'カテゴリを削除しました。');
    }

}
