<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//モデルを使う宣言 これを書くことでAppの名前空間を書かなくてよくなる
use App\Models\Task;
use App\Models\User;
use App\Models\Tasklist;

class TasksController extends Controller
{
    // GETでtasks/にアクセスされたときの一覧表示処理
    public function index()
    {
        $data = [];
        
        //認証済みユーザか判定
        if(\Auth::check()){
            //認証済みユーザを取得
            $user = \Auth::user();
            
            //ユーザ投稿の一覧を降順で取得
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
        }
        
        // タスク一覧ビューで表示
        //view(第1引数：表示したいいView，第２引数：Viewに渡したいデータの配列)
        return view('tasks.index', $data);
    }

    //GETでtasks/create/にアクセスされたときの新規登録画面表示処理
    public function create()
    {
        
        //認証済みユーザか判定
        if(\Auth::check()){
            $task = new Task;
        }
        
        //タスク作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    //POSTでtasks/にアクセスされたときの新規登録処理
    public function store(Request $request)
    {
        //バリデーション
        $request->validate([
            'status' => 'required | max:10',
            'content' => 'required | max:255',
        ]);
        
        //認証済みユーザとして投稿を作成
        $request->user()->tasklists()->create([
            'status' => $request->status,
            'content' => $request->content,
        ]);
        
        //タスク一覧に遷移
        return redirect('/dashboard');
    }

    //GETでtasks/（任意のid）にアクセスされたときの取得表示処理
    public function show($id)
    {
        
        //認証済みユーザか判定
        if(\Auth::check()){
            //認証済みユーザを取得
            $user = \Auth::user();
            
            //idの値でユーザ投稿を取得
            $tasklists = Task::findOrFail($id);
            $data = [
                'user' => $user,
                'tasklists' => $tasklists,
            ];
        }

        // タスク詳細ビューでそれを表示
        return view('tasks.show', $data);
    }

    //GETでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        if(\Auth::check()){
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
        }
        
        // メッセージ編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    //PUTまたはPATCHでtasks/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        //バリデーション
        $request->validate([
            'status' => 'required | max:10',
            'content' => 'required | max:255',
        ]);
        
        if(\Auth::check()){
            // idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
            
            //メッセージを更新
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        }
        
        //トップページへリダイレクト
        return redirect('/dashboard');
    }

    //DELETEでtasks/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $tasklist = Task::findOrFail($id);
        // 認証済みユーザがその投稿の所有者である場合は投稿を削除
        if (\Auth::id() === $tasklist->user_id) {
            $tasklist->delete();
            //タスク一覧に遷移
            return redirect('/dashboard')
                ->with('success','Delete Successful');
        }
    }
}
