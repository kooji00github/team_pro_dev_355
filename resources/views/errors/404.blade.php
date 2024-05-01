@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-danger">
        <h1>404 - ページが見つかりません</h1>
        <p>お探しのページは存在しないか、移動した可能性があります。</p>
        <a href="{{ url('/') }}">ホームに戻る</a>
    </div>
</div>
@endsection
