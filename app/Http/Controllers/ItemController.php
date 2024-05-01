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

        // 検索条件と現在のページをセッションに保存
        session()->put('search_conditions', $request->all());
        session()->put('current_page', $request->get('page'));

        // Itemモデルから新しいクエリビルダインスタンスを作成
        $query = Item::query();

        // statusがactiveである商品のみを取得
        $query->where('status', 'active');

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
                'detail' => 'max:500', // 500文字以内
            ]);

            // 選択された種別のIDを取得
            $typeId = $request->type;

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'status' => 'active', // 初期値はactive
                'type_id' => $typeId,  // 選択された種別のIDを設定
                'detail' => $request->detail,
            ]);

            // フラッシュメッセージをセット
            session()->flash('message', '商品が登録されました。');

            return redirect('/items');
        }

        // typesテーブルから全ての種別を取得
        $types = Type::all();

        return view('item.add', compact('types'));
    }

    /**
     * 商品削除
     */
    public function delete(Request $request)
    {
        // 削除対象の商品を取得
        $item = Item::find($request->id);

        // 商品が存在しない場合は404エラー
        if (empty($item)) {
            abort(404, 'Item not found.');
        }

        // ログインユーザーの商品でない場合は403エラー
        if ($item->user_id !== Auth::user()->id) {
            abort(403, 'Item not owned by the user.');
        }

        // 商品のstatusがinactiveだった場合は403エラー
        if ($item->status === 'inactive') {
            abort(403, 'Item is inactive.');
        }

        // 商品削除(statusをinactiveに更新)
        $item->status = 'inactive';
        $item->save();

        // フラッシュメッセージをセット
        session()->flash('message', '商品を削除しました。');

        // 保存した検索条件と現在のページを取得
        $searchConditions = session()->get('search_conditions', []);
        $current_page = session()->get('current_page', 1);

        // ページネーションを適用して結果を取得
        $items = Item::where('status', 'active')->paginate(10, ['*'], 'page', $current_page);

        // 保持していたページがなくなった場合、一つ前のページに戻る
        while ($items->isEmpty() && $current_page > 1) {
            $current_page--;
            $items = Item::where('status', 'active')->paginate(10, ['*'], 'page', $current_page);
        }

        // 検索条件と現在のページを保持したままリダイレクト
        $query = http_build_query($searchConditions + ['page' => $current_page]);
        return redirect('/items?' . $query);
    }
}

