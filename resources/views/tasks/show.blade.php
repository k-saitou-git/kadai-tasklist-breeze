{{-- layouts/app.blade.phpを継承 --}}
@extends('layouts.app')

@section('content')
    <div class="prose ml-4">
        <h2>id = {{ $tasklists->id }}のタスク詳細</h2>
    </div>
    
    <table class="table w-full my-4">
        <tr>
            <th>id</th>
            <td>{{ $tasklists->id }}</td>
        </tr>
        
        <tr>
            <th>タスク</th>
            <td>{{ $tasklists->content }}</td>
        </tr>
        
        <tr>
            <th>ステータス</th>
            <td>{{ $tasklists->status }}</td>
        </tr>
    </table>
    
    {{-- メッセージ編集ページへのリンク --}}
    <a class="btn btn-outline" href="{{ route('tasks.edit', $tasklists->id) }}">このタスクを編集</a>
    
    {{-- メッセージ削除フォーム --}}
    <form method="POST" action="{{ route('tasks.destroy', $tasklists->id) }}" class="my-2">
        @csrf
        @method('DELETE')
        
        <button type="submit" class="btn btn-error btn-outline"
            onclick="return confirm('id = {{ $tasklists->id }}のタスクを削除します。よろしいですか？')">削除</button>
    </form>

@endsection