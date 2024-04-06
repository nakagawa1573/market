@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="content__ttl">
            プロフィール設定
        </h1>
        <form class="content__form" action="">
            @csrf
            <div class="content__form--img">
                {{-- jsで画像を表示させる --}}
                <div class="content__form--img__view">
                    <img src="" alt="">
                </div>
                <input type="file" id="img">
                <button class="content__form--img__btn">
                    <label for="img">
                        画像を選択する
                    </label>
                </button>
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    ユーザー名
                </h3>
                <input type="text" class="content__form--item__input">
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    郵便番号
                </h3>
                <input type="text" class="content__form--item__input">
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    住所
                </h3>
                <input type="text" class="content__form--item__input">
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    建物名
                </h3>
                <input type="text" class="content__form--item__input">
            </div>
            <button class="form__btn" type="submit">
                更新する
            </button>
        </form>
    </section>
@endsection
