@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
    <section class="profile">
        <article class="profile__item">
            <div class="profile__item--img">
                <img src="{{ Storage::disk('public')->url('/items') . '/' . 'PXL_20240406_014732240.jpg' }}">
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
            <button class="tab__item" id="select">出品した商品</button>
            <button class="tab__item" id="none" onclick="switchTab();">購入した商品</button>
        </div>
    </div>
    <section class="content" id="main">
        @if (isset($sells))
            @foreach ($sells as $sell)
                <article class="content__item">
                    <a class="content__item--link" href="/item/{{ $sell->id }}">
                        <img class="content__item--link__img"
                            src="{{ Storage::disk('public')->url('/items') . '/' . $sell->img }}">
                    </a>
                </article>
            @endforeach
        @endif
    </section>

    <section class="content" id="modal">
        @if (isset($purchases))
            @foreach ($purchases as $purchase)
                <article class="content__item">
                    <a class="content__item--link" href="/item/{{$purchase->item->id}}">
                        <img class="content__item--link__img"
                            src="{{ Storage::disk('public')->url('/items') . '/' . $purchase->item->img }}">
                    </a>
                </article>
            @endforeach
        @endif
    </section>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
