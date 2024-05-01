@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-danger">
        <h1>403 - アクセスが拒否されました</h1>
        <p>このページへのアクセス権限がありません。</p>
        <a href="{{ url('/') }}">ホームに戻る</a>
    </div>
</div>
@endsection
