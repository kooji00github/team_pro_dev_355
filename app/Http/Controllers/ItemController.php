<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Type;

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

        // リクエストから検索キーワードと種別を取得
        $keyword = $request->input('keyword');
        $selectedType = $request->input('type');

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
        if (!empty($selectedType)) {
            $query->whereHas('type', function ($query) use ($selectedType) {
                $query->where('name', $selectedType);
            });
        }

        // 新着順に並べ替え
        $query->orderBy('created_at', 'desc');

        // ページネーションを適用して結果を取得
        $items = $query->paginate($perPage);

        // typesテーブルから全ての種別を取得
        $types = Type::all();

        // 結果をビューに渡して表示
        return view('item.index', compact('items', 'types', 'keyword', 'selectedType'));
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
                'name' => 'required|max:100', // 必須、100文字以内
                'type' => 'required', // 必須
            ]);

            // 選択された種別のIDを取得
            $typeId = $request->type;

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'type_id' => $typeId,  // 選択された種別のIDを設定
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        // typesテーブルから全ての種別を取得
        $types = Type::all();

        return view('item.add', compact('types'));
    }
}
