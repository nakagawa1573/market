@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="content__ttl">
            ログイン
        </h1>
        <div class="content__item">
            <form action="/login" method="post">
                @csrf
                <div class="content__item--box">
                    <h3 class="content__item--ttl">
                        メールアドレス
                    </h3>
                    @error('email')
                        <p class="error">
                            {{ $message }}
                        </p>
                    @enderror
                    <input class="content__item--input" type="text" name="email">
                </div>
                <div class="content__item--box">
                    <h3 class="content__item--ttl">
                        パスワード
                    </h3>
                    @error('password')
                        <p class="error">
                            {{ $message }}
                        </p>
                    @enderror
                    <input class="content__item--input" type="password" name="password">
                </div>
                <button class="content__item--btn">
                    ログインする
                </button>
            </form>
        </div>
        <a class="content__link" href="/register">
            会員登録はこちら
        </a>
    </section>
@endsection
