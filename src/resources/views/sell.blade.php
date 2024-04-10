@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="content__ttl">
            商品の出品
        </h1>
        {{ session('message') }}
        <form action="/sell" method="post" enctype="multipart/form-data">
            @csrf
            <div class="content__item">
                <h2 class="content__item--ttl">
                    商品画像
                </h2>
                @error('img')
                    {{ $message }}
                @enderror
                <div id="img">
                    <input type="file" id="img__input" name="img">
                    <button id="img__btn" type="button">
                        <label for="img__input">
                            画像を選択する
                        </label>
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
                    @error('category_id')
                        {{ $message }}
                    @enderror
                    <button class="content__item--input pointer" id="btn__category" type="button">
                        カテゴリーを選択する
                    </button>
                    <div id="modal">
                        @foreach ($categories as $category)
                            <div id="category">
                                <input type="checkbox" id="{{ $category->id }}" name="category_id[]"
                                    value="{{ $category->id }}">
                                <label for="{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="content__item--wrapper">
                    <h2 class="content__item--ttl">
                        商品の状態
                    </h2>
                    @error('status_id')
                        {{ $message }}
                    @enderror
                    <select class="content__item--input pointer" name="status_id">
                        <option value="" disabled selected>選択してください</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="content__item--wrapper">
                    <div id="brand__wrapper">
                        <h2 class="content__item--ttl">
                            ブランド
                        </h2>
                        @error('brand')
                            {{ $message }}
                        @enderror
                        <p id="any">
                            任意
                        </p>
                    </div>
                    <input type="text" class="content__item--input" name="brand">
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
                    @error('name')
                        {{ $message }}
                    @enderror
                    <input class="content__item--input" type="text" name="name">
                </div>
                <div class="content__item--wrapper">
                    <h2 class="content__item--ttl">
                        商品の説明
                    </h2>
                    @error('description')
                        {{ $message }}
                    @enderror
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
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
                    @error('price')
                        {{ $message }}
                    @enderror
                    <div id="price">
                        <input class="content__item--input" type="text" name="price">
                    </div>
                </div>
            </div>
            <button class="content__btn" type="submit">
                出品する
            </button>
        </form>
    </section>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
