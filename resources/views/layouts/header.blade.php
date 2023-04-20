<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo2</title>
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <h1><a href="/">To Do リスト</a></h1>
        <nav>
            <ul>
                @if(Auth::check())
                
                <li>
                    <i class="fa-solid fa-user fa-xl"></i>
                    <span>{{$user->name}}</span>
                </li>
                <li>
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                            ログアウト
                        </button>
                    </form>
                </li>
                @else
                <li>
                    <a href="/register">
                        <i class="fa-solid fa-user-plus fa-xl"></i>
                        <span>新規登録</span>
                    </a>
                </li>
                <li>
                    <a href="/login">
                        <i class="fa-solid fa-right-to-bracket fa-xl"></i>
                        <span>ログイン</span>
                    </a>
                </li>
                @endif

            </ul>
        </nav>
    </header>
    @yield('content')
</body>
</html>