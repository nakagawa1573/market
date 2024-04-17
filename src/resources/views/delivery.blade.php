@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="content__ttl">
            配送先の変更
        </h1>
        {{ session('message') }}
        <form class="content__form" action="/purchase/delivery" method="post">
            @csrf
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    郵便番号
                </h3>
                @error('post_code')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
                <input type="text" class="content__form--item__input" name="post_code" value="{{ $delivery->post_code ?? '' }}">
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    住所
                </h3>
                @error('address')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
                <input type="text" class="content__form--item__input" name="address" value="{{ $delivery->address ?? '' }}">
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    建物名
                </h3>
                @error('building')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
                <input type="text" class="content__form--item__input" name="building" value="{{ $delivery->building ?? '' }}">
            </div>
            <button class="form__btn" type="submit">
                更新する
            </button>
        </form>
    </section>
@endsection
