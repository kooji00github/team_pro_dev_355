@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('items.index') }}" method="get" class="row">
                        <div class="col-xl-2 d-flex align-items-center">
                            <h3 class="card-title">商品一覧</h3>
                        </div>
                        <div class="col-1.5 px-0">
                            <select id="typeSelect" name="type" class="form-control">
                                <option value="">全ての種別</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->name }}" {{ $selectedType == $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl px-0">
                            <input type="text" id="searchInput" name="keyword" class="form-control" placeholder="名前や詳細で検索" value="{{ $keyword }}">
                        </div>
                        <div class="col-xl-3 d-flex px-0">
                            <button type="submit" class="btn btn-success mr-1"><i class="fas fa-search"></i> 絞り込み</button>
                            <button type="button" id="clearSearch" class="btn btn-default"><i class="fas fa-times"></i>リセット</button>
                        </div>
                        <div class="col-1.5 d-flex justify-content-end">
                            <a href="{{ url('items/add') }}" class="btn btn-default"><i class="fas fa-plus"></i> 商品登録</a>
                        </div>
                    </form>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>種別</th>
                                <th>詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->type->name }}</td>
                                <td>{{ $item->detail }}</td>
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
    .col-1.5 {
        flex: 0 0 12.5%;
        max-width: 12.5%;
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
</script>
@stop
