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
            <form action="">
                @csrf
                <div class="content__item--box">
                    <h3 class="content__item--ttl">
                        メールアドレス
                    </h3>
                    <input class="content__item--input" type="text">
                </div>
                <div class="content__item--box">
                    <h3 class="content__item--ttl">
                        パスワード
                    </h3>
                    <input class="content__item--input" type="password">
                </div>
                <button class="content__item--btn">
                    登録する
                </button>
            </form>
        </div>
        <a class="content__link" href="">
            会員登録はこちら
        </a>
    </section>
@endsection