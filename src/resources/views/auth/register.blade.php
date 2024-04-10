@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="content__ttl">
            会員登録
        </h1>
        <div class="content__item">
            <form action="/register" method="post">
                @csrf
                <div class="content__item--box">
                    <h3 class="content__item--ttl">
                        メールアドレス
                    </h3>
                    @error('email')
                        {{ $message }}
                    @enderror
                    <input class="content__item--input" type="text" name="email">
                </div>
                <div class="content__item--box">
                    <h3 class="content__item--ttl">
                        パスワード
                    </h3>
                    @error('password')
                        {{ $message }}
                    @enderror
                    <input class="content__item--input" type="password" name="password">
                </div>
                <button class="content__item--btn" type="submit">
                    登録する
                </button>
            </form>
        </div>
        <a class="content__link" href="/login">
            ログインはこちら
        </a>
    </section>
@endsection
