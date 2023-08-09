{{-- layouts/app.blade.phpを継承 --}}
@extends('layouts.app')

@section('content')

    <div class="prose ml-4">
        <h2>タスク一覧</h2>
    </div>
    
    @if(isset($tasklists))
        <table class="table table-zebra w-full my-4">
            <thead>
                <tr>
                    <th>id</th>
                    <th>ステータス</th>
                    <th>メッセージ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasklists as $tasklist)
                    <tr>
                        <td><a class="link link-hover text-info" href="{{ route('tasks.show', $tasklist->id) }}">{{ $tasklist->id }}</a></td>
                        <td>{{ $tasklist->status }}</td>
                        <td>{{ $tasklist->content }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
    {{-- メッセージ作成ページへのリンク --}}
    <a class="btn btn-primary" href="{{ route('tasks.create') }}">新規タスクの投稿</a>


@endsection