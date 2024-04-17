@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
    <section class="content">
        <h1 class="content__ttl">
            プロフィール設定
        </h1>
        {{ session('message') }}
        <form class="content__form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @csrf
            @if ($profile)
                @method('patch')
            @endif
            @error('img')
                <p class="error">
                    {{ $message }}
                </p>
            @enderror
            <div class="content__form--img">
                <div class="content__form--img__view">
                    @if (app()->isLocal())
                        <img src="{{ $profile ? Storage::disk('public')->url('/profiles/' . $profile->img) : '' }}">
                    @elseif(app()->isProduction())
                        <img src="{{ $profile ? Storage::disk('s3')->url('/profiles/' . $profile->img) : '' }}">
                    @endif
                </div>
                @error('img')
                    {{ $message }}
                @enderror
                <input type="file" id="img" name="img">
                <button class="content__form--img__btn" type="button">
                    <label for="img">
                        画像を選択する
                    </label>
                </button>
                <p id="any">
                    任意
                </p>
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    ユーザー名
                </h3>
                @error('name')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
                <input type="text" class="content__form--item__input" name="name"
                    value="{{ $profile ? $profile->name : '' }}">
            </div>
            <div class="content__form--item">
                <h3 class="content__form--item__ttl">
                    郵便番号
                </h3>
                @error('post_code')
                    <p class="error">
                        {{ $message }}
                    </p>
                @enderror
                <input type="text" class="content__form--item__input" name="post_code"
                    value="{{ $profile ? $profile->post_code : '' }}">
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
                <input type="text" class="content__form--item__input" name="address"
                    value="{{ $profile ? $profile->address : '' }}">
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
                <input type="text" class="content__form--item__input" name="building"
                    value="{{ $profile ? $profile->building : '' }}">
            </div>
            <button class="form__btn" type="submit">
                @if ($profile)
                    更新する
                @else
                    作成する
                @endif
            </button>
        </form>
    </section>
@endsection
