@extends('adminlte::page')

@section('title', '商品一覧')

@section('content_header')
    <h1>商品一覧</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="input-group input-group-sm mr-2 w-50 mx-auto">
                        <input type="text" name="table_search" class="form-control" placeholder="検索">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default btn-sm"><i class="fas fa-search"></i></button>
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
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
