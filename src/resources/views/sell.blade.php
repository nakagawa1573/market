@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="content__ttl">
            商品の出品
        </h1>
        <form action="">
            @csrf
            <div class="content__item">
                <h2 class="content__item--ttl">
                    商品画像
                </h2>
                <div id="img">
                    <button id="img__btn">
                        画像を選択する
                    </button>
                </div>
            </div>
            <div class="content__item">
                <h1 class="content__item--heading">
                    商品の詳細
                </h1>
                <div class="content__item--wrapper">
                    <h2 class="content__item--ttl">
                        カテゴリー
                    </h2>
                    <select class="content__item--input" name="" id="">
                        <option value=""></option>
                    </select>
                </div>
                <div class="content__item--wrapper">
                    <h2 class="content__item--ttl">
                        商品の状態
                    </h2>
                    <select class="content__item--input" name="" id="">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="content__item">
                <h1 class="content__item--heading">
                    商品名と説明
                </h1>
                <div class="content__item--wrapper">
                    <h2 class="content__item--ttl">
                        商品名
                    </h2>
                    <input class="content__item--input" type="text">
                </div>
                <div class="content__item--wrapper">
                    <h2 class="content__item--ttl">
                        商品の説明
                    </h2>
                    <textarea name="" id="description" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="content__item">
                <h1 class="content__item--heading">
                    販売価格
                </h1>
                <div class="content__item--wrapper">
                    <h2 class="content__item--ttl">
                        販売価格
                    </h2>
                    <div id="price">
                        <input class="content__item--input" type="text" >
                    </div>
                </div>
            </div>
            <button class="content__btn">
                出品する
            </button>
        </form>
    </section>
@endsection
