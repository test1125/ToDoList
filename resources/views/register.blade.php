@extends('layouts.header')
@section('content')
    <link rel="stylesheet" href="login.css">
    <main>
        <div class="login">
        <h1>会員登録</h1>
        @if($errors->any())
            <div class="error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="/user/store" method="POST">
            @csrf
                <label>ユーザー名<br>
                    <input name="name" type="name" value="{{ old('name') }}">
                </label>
                <label>パスワード<br>
                    <input name="password" type="password">
                </label>
                <button type="submit">会員登録</button>
        </form>
        </div>
    </main>
@endsection
   
</body>
</html>