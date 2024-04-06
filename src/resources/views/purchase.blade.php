@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <section class="content">
        <article class="content__item">
            <div class="content__img--box">
                <div id="img">
                    <img src="{{ Storage::disk('public')->url('/G-GEAR-G1.jpg') }}" alt="">
                </div>
                <div class="item__wrapper">
                    <h1 id="name">
                        商品名
                    </h1>
                    <p id="price">
                        ￥47,000
                    </p>
                </div>
            </div>
            <div class="content__box">
                <h2 class="content__item--ttl">
                    支払い方法
                </h2>
                <a class="content__item--link" href="">
                    変更する
                </a>
            </div>
            <div class="content__box">
                <h2 class="content__item--ttl">
                    配送先
                </h2>
                <a class="content__item--link" href="">
                    変更する
                </a>
            </div>
        </article>
        <article class="content__item">
            <div class="content__item--box">
                <div class="content__item--group">
                    <p id="data__ttl">
                        商品代金
                    </p>
                    <p id="data">
                        ￥47,000
                    </p>
                </div>
                <div class="content__item--group">
                    <p id="data__ttl">
                        支払い金額
                    </p>
                    <p id="data">
                        ￥47,000
                    </p>
                </div>
                <div class="content__item--group">
                    <p id="data__ttl">
                        支払い方法
                    </p>
                    <p id="data">
                        コンビニ払い
                    </p>
                </div>
            </div>
            <form action="">
                @csrf
                <button class="content__item--btn" type="submit">
                    購入する
                </button>
            </form>
        </article>
    </section>
@endsection
