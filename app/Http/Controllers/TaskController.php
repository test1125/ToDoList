<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    //タスクの表示
    public function index()
{
    if(Auth::check())
    {
        $user = Auth::user();
        $max = Task::all()->max('id');
        $tasks = Task::where('user_id', $user->id)->orderBy('order', 'asc')->get();
        $todos = $tasks->where('done', 0);
        $dones = $tasks->where('done', 1);
        
        return view('index', compact('tasks', 'todos', 'dones', 'user', 'max'));
    }
    else
    {
        $user = Auth::user();
        return view('index', compact('user'));
    }
}

    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    //タスクの作成
    public function store(Request $request)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;

            // return($request);
            $data = $request->all(); // リクエストデータを取得
    
            // データベースに登録
            $task = new Task();
            $task->id = $data['id'];
            $task->user_id = $user_id;
            $task->order = $data['order'];
            $task->task_name = $data['task_name'];
            $task->done = $data['done'];
            $task->save();
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    //タスクの更新
    public function update(Request $request)
    {
        if(Auth::check()){
            // リクエストデータを取得
            $data = $request->all();
            $ids = $data['id'];

            $user_id = Auth::user()->id;
            $tasks = Task::where('user_id', $user_id)->get();
        
            foreach ($ids as $id) {
                // 更新対象のモデルを取得
                $model = $tasks->find($id);
                // $model = Task::find($id);
        
                // orderとtask_nameとdoneの値を更新
                $index = array_search($id, $ids);
                $model->order = $index + 1;
                $model->task_name = $data['task_name'][$index];
                $model->done = $data['done'][$index];
        
                // モデルを保存
                $model->save();
            }
            // session()->flash('success', json_encode($data));
        }
        return redirect('/');
    }

    //タスクの削除
    public function destroy(Request $request)
    {
        if(Auth::check()){
            $user_id = Auth::user()->id;
            $tasks = Task::where('user_id', $user_id)->get();
            // return $request;
            //削除
            $id = $request->del;
            $model = $tasks->find($id);
            // $model = Task::find($id);
            $model -> delete();
        }
        return redirect('/');
    }
}
