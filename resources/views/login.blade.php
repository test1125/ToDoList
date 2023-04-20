@extends('layouts.header')
@section('content')
<link rel="stylesheet" href="login.css">
<main>
    <div class="login">
        <h1>ログイン</h1>
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <form action="/user/login" method="POST">
            @csrf
            <label>ユーザー名<br>
                <input name="name" type="name" value="{{ old('name') }}">
            </label>
            <label>パスワード<br>
                <input name="password" type="password">
            </label>
            <button type="submit">ログイン</button>
        </form>
    </div>
</main>
@endsection
   
</body>
</html>