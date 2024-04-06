@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <section class="profile">
        <article class="profile__item">
            <div class="profile__item--img">
                <img src="{{ Storage::disk('public')->url('/G-GEAR-G1.jpg') }}" alt="">
            </div>
            <h2 class="profile__item--name">
                ユーザー名
            </h2>
        </article>
        {{-- ユーザーの名前を表示。登録してなければ「ユーザー名」を表示 --}}
        <button class="profile__btn">
            プロフィールを編集
        </button>
    </section>
    <div class="tab__wrapper">
        <div class="tab">
            <a class="tab__item--select" href="">出品した商品</a>
            <a class="tab__item" href="">購入した商品</a>
        </div>
    </div>
    <section class="content">
        @for ($i = 0; $i < 12; $i++)
            <article class="content__item">
                <a class="content__item--link" href="">
                    <img class="content__item--link__img" src="{{ Storage::disk('public')->url('/items/G-GEAR-G1.jpg') }}"
                        alt="">
                </a>
            </article>
        @endfor
    </section>
@endsection
