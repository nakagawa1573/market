@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="content__img">
            <img id="img" src="{{ Storage::disk('public')->url('/G-GEAR-G1.jpg') }}" alt="">
        </div>
        <article class="content__item">
            <div class="content__item--box">
                <h1 id="name">
                    商品名
                </h1>
                <p id="brand">
                    ブランド名
                </p>
                <p id="price">
                    ￥47,000(値段)
                </p>
                <div class="content__item--link__wrapper">
                    <div class="content__item--link">
                        <a href="">
                            <img id="icon__img" src="{{ Storage::disk('public')->url('/icons/star.svg') }}" alt="">
                        </a>
                        <p id="count">
                            3
                        </p>
                    </div>
                    <div class="content__item--link">
                        {{-- コントローラーでflagを持たせてコメント表示を切り替える --}}
                        <a href="">
                            <img id="icon__img" src="{{ Storage::disk('public')->url('/icons/bubble.svg') }}"
                                alt="">
                        </a>
                        <p id="count">
                            14
                        </p>
                    </div>
                </div>
            </div>
            <div id="item__wrapper">
                <form action="">
                    @csrf
                    <button class="content__item--btn">
                        購入する
                    </button>
                </form>
                <div class="content__item--box">
                    <h2 class="content__item--ttl">
                        商品説明
                    </h2>
                    <p class="description">
                        カラー：グレー<br>
                        <br>
                        新品<br>
                        商品の状態は良好です。傷もありません。<br>
                        <br>
                        購入後、即発送いたします。
                    </p>
                </div>
                <div class="content__item--box">
                    <h2 class="content__item--ttl">
                        商品の情報
                    </h2>
                    <div class="content__item--group">
                        <h3 class="content__item--group__ttl">
                            カテゴリー
                        </h3>
                        <div id="category__wrapper">
                            {{-- カテゴリーが多く選ばれたときの表示、文字数の多いカテゴリーの表示 --}}
                            <p id="category">
                                洋服
                            </p>
                            <p id="category">
                                メンズ
                            </p>
                        </div>
                    </div>
                    <div class="content__item--group">
                        <h3 class="content__item--group__ttl">
                            商品の状態
                        </h3>
                        <p id="status">
                            良好
                        </p>
                    </div>
                </div>
            </div>
            <div class="content__item--box" id="comment__wrapper">
                <form action="">
                    @csrf
                    <h3 class="content__item--ttl">
                        商品へのコメント
                    </h3>
                    <textarea name="" id="comment" cols="30" rows="10"></textarea>
                    <button class="content__item--btn">
                        コメントを送信する
                    </button>
                </form>
            </div>
        </article>
    </section>
@endsection
