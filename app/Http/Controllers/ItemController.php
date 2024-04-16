<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        // 1ページあたりの表示件数を設定
        $perPage = 10;

        // リクエストから検索キーワードを取得
        $keyword = $request->input('keyword');

        // リクエストから種別を取得
        $type = $request->input('type');

        // Itemモデルから新しいクエリビルダインスタンスを作成
        $query = Item::query();

        // 検索キーワードが空でない場合、名前と詳細で検索
        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                      ->orWhere('detail', 'LIKE', "%{$keyword}%");
            });
        }

        // 種別が空でない場合、種別で絞り込み
        if (!empty($type)) {
            $query->where('type', $type);
        }

        // ページネーションを適用して結果を取得
        $items = $query->paginate($perPage);

        // 結果をビューに渡して表示
        return view('item.index', compact('items', 'keyword', 'type'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }
}
