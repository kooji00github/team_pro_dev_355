@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    @if (session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="d-flex align-items-center" style="min-width: 100px;">
                            <h3 class="card-title">商品一覧</h3>
                        </div>
                        <form action="{{ route('items.index') }}" method="get" class="d-flex justify-content-start flex-grow-1 flex-wrap">
                            <div class="px-1" style="min-width: 130px;">
                                <select id="typeSelect" name="type" class="form-control">
                                    <option value="">全ての種別</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->name }}" {{ $selectedType == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-1 flex-grow-1" style="min-width: 200px;">
                                <input type="text" id="searchInput" name="keyword" class="form-control" placeholder="名前や詳細で検索" value="{{ $keyword }}">
                            </div>
                            <div class="px-1" style="min-width: 125px;">
                                <button type="submit" class="btn btn-success mr-1"><i class="fas fa-search"></i> 絞り込み</button>
                            </div>
                            <div class="px-1"  style="min-width: 110px;">
                                <button type="button" id="clearSearch" class="btn btn-default"><i class="fas fa-times"></i>リセット</button>
                            </div>
                        </form>
                        <div class="d-flex justify-content-end" style="min-width: 120px;">
                            <a href="{{ url('items/add') }}" class="btn btn-default"><i class="fas fa-plus"></i> 商品登録</a>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-fixed">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="name-column">名前</th>
                                <th>種別</th>
                                <th class="detail-column">詳細</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td class="cell" data-title="{{ $item->id }}">{{ $item->id }}</td>
                                <td class="cell name-column" data-title="{{ $item->name }}">{{ $item->name }}</td>
                                <td class="cell" data-title="{{ $item->type->name }}">{{ $item->type->name }}</td>
                                <td class="cell detail-column" data-title="{{ $item->detail }}">{{ $item->detail }}</td>
                                <td>
                                    @if (Auth::user()->id == $item->user_id && $item->status == 'active')
                                        <form action="{{ url('items/delete/' . $item->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger mr-1"><i class="fas fa-trash"></i> 削除</button>
                                        </form>
                                    @else
                                        <a href="#" class="btn btn-light text-muted disabled mr-1"><i class="fas fa-trash"></i> 削除</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between mx-3 mt-2">
                    @if($items->total() > 0)
                        <div>
                            {{ $items->firstItem() }} - {{ $items->lastItem() }} / {{ $items->total() }}
                        </div>
                    @endif
                    <div>
                        <!-- ページネーションを配置 -->
                        {{ $items->appends(['keyword' => $keyword, 'type' => $selectedType])->links('pagination::custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .tooltip .tooltip-inner {
        background-color: #333333; /* ツールチップの背景色を濃いグレーに設定 */
        color: #ffffff; /* ツールチップのテキスト色を白に設定 */
        max-width: 500px; /* ツールチップの最大横幅 */
        width: auto; /* ツールチップの横幅を自動に設定 */
        text-align: left; /* ツールチップのテキストを左寄せに設定 */
    }

    .tooltip.bs-tooltip-top .arrow::before {
        border-top-color: #333333; /* ツールチップが上向きの場合の矢印の色を濃いグレーに設定 */
    }

    .tooltip.bs-tooltip-bottom .arrow::before {
        border-bottom-color: #333333; /* ツールチップが下向きの場合の矢印の色を濃いグレーに設定 */
    }

    .col-1.5 {
        flex: 0 0 12.5%;
        max-width: 12.5%;
    }

    .table-fixed {
        table-layout: fixed;
    }

    .table-fixed td, .table-fixed th {
        overflow: hidden; /* セル内の内容がセルの領域を超えた場合、それを隠す */
        text-overflow: ellipsis; /* セル内の内容がセルの領域を超えた場合、それを省略記号で表示 */
        white-space: nowrap; /* セル内の内容がセルの領域を超えた場合、それを折り返しせずに表示 */
        position: relative; /* セル内の内容に対して相対位置を設定 */
    }

    .name-column {
        width: 30%;
    }

    .detail-column {
        width: 45%;
    }
</style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('clearSearch').addEventListener('click', function() {
            // 検索フィールドをクリア
            document.getElementById('searchInput').value = '';
            document.getElementById('typeSelect').value = '';

            // フォームを送信
            this.form.submit();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var cells = document.querySelectorAll('.cell');
        cells.forEach(function(cell) {
            $(cell).attr('data-toggle', 'tooltip');
            $(cell).attr('title', $(cell).attr('data-title'));
        });

        // ツールチップを有効にする
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop
