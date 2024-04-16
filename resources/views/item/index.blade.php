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
                    <div class="row">
                        <div class="col-2">
                            <h3 class="card-title">商品一覧</h3>
                        </div>
                        <div class="col-8">
                            <div class="row">
                                <div class="col-2 px-0">
                                    <select id="typeSelect" name="type" class="form-control">
                                        <option value="">全ての種別</option>
                                        <option value="食料品">食料品</option>
                                        <option value="衛生用品">衛生用品</option>
                                        <option value="衣料品">衣料品</option>
                                        <option value="医療品">医療品</option>
                                        <option value="情報機器">情報機器</option>
                                        <option value="情報機器">情報機器</option>
                                        <option value="その他">その他</option>
                                    </select>
                                </div>
                                <div class="col-7 px-0">
                                    <input type="text" id="searchInput" name="table_search" class="form-control" placeholder="検索キーワード">
                                </div>
                                <div class="col-3 px-0">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                                        <button type="button" id="clearSearch" class="btn btn-default"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a href="{{ url('items/add') }}" class="btn btn-default">商品登録</a>
                        </div>
                    </div>
                    <div class="justify-content-end">
                        <a href="{{ url('items/add') }}" class="btn btn-default btn-sm">商品登録</a>
                    </div>
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
                                    <td>{{ $item->type }}</td>
                                    <td>{{ $item->detail }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <!-- ページネーションを配置 -->
                    {{ $items->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('clearSearch').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
        });
    });
</script>
@stop
