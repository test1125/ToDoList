@extends('layouts.header')

@section('content')
<link rel="stylesheet" href="index.css">
@if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<main>
    <form name="list" action="/update" method="POST">
    <!-- <form name="todo" action="/update" method="POST"> -->
        @csrf
        <div class="todo">
            <h2>未完了のタスク</h2>
            <table class="todo__table">
                <tbody id="todo">
                    @if(Auth::check())
                    @foreach($todos as $todo)
                    <tr id="{{  $todo->id  }}" class="item offdrag">
                        <td class="item__handle">
                            <img class="item__drag_icon" src="drag_indicator.svg">
                        </td>
                        <td class="item__task-info">
                            <input class="item__delete-value" type="hidden" name="delete[]" value="0">
                            <input class="item__id-value" type="hidden" name="id[]" value="{{  $todo->id  }}">
                            <input class="item__order" type="hidden" name="order[]" value="{{  $todo->order  }}">
                            <input class="item__task-name" type="text" name="task_name[]" value="{{  $todo->task_name  }}">
                            <input class="item__done-value" type="hidden" name="done[]" value="{{  $todo->done  }}">
                        </td>
                        <td class="item__complete">
                            <button>完了</button>
                        </td>
                        <td class="item__delete">
                            <button name="del[]" value="{{  $todo->id  }}">削除</button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    <!-- </form> -->
    <!-- <form name="done" action="/update" method="POST"> -->
        <div class="done">
            <h2>完了済みのタスク</h2>
            <table class="done__table">
                <tbody id="done">
                @if(Auth::check())
                @foreach($dones as $done)
                    <tr id="{{  $done->id  }}" class="item offdrag">
                        <td class="item__handle">
                            <img class="item__drag_icon" src="drag_indicator.svg">
                        </td>
                        <td class="item__task-info">
                            <input class="item__delete-value" type="hidden" name="delete[]" value="0">
                            <input class="item__id-value" type="hidden" name="id[]" value="{{  $done->id  }}">
                            <input class="item__order" type="hidden" name="order[]" value="{{  $done->order  }}">
                            <input class="item__task-name" type="text" name="task_name[]" value="{{  $done->task_name  }}">
                            <input class="item__done-value" type="hidden" name="done[]" value="{{  $done->done  }}">
                        </td>
                        <td class="item__complete">
                            <button>戻す</button>
                        </td>
                        <td class="item__delete">
                            <button name="del[]" value="{{  $done->id  }}">削除</button>
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
    <!-- </form> -->
    </form>

    <form action="/destroy" name="delTask" method="POST">
        @csrf
        <input class="del-task__input" type="hidden" name=del value="0">
    </form>
</main>
<footer>
        <form name="addTask" action="/store" method="POST" class="add-task__form" id="form_task">
            @csrf
            <input class="add-task__id-value" type="hidden" name="id" value="0">
            <input class="add-task__order" type="hidden" name="order" value="0">
            <input class="add-task__input" id="task-name" type="text" name="task_name">
            <input class="add-task__done-value" type="hidden" name="done" value="0">
            <!-- input type=textが1つだけの場合、type=buttonにしてもenterで送信されてしまう。これを防ぐためにdummyを設置 -->
            <input type="text" name="dummy" style="position:absolute;visibility:hidden">
            <button type="button" class="add-task__button" id="add_task">追加</button>
        </form>
</footer>
<script>
    @if(Auth::check()){
        idNum = {{  $max + 1}};
        login = true;
    }
    @else
        idNum = 1;
        login = false;
    @endif
    
</script>
<!-- @if (Auth::check())
    <script src="/logged-in.js"></script>
@else
    <script src="/logged-out.js"></script>
@endif -->

<script src="index.js"></script>
@endsection