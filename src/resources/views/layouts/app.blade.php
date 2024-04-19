<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>Coachtechフリマ</title>
</head>

<body>
    <header>
        <div class="header__ttl">
            <a href="/">
                <img class="header__ttl--img" src="{{ Storage::disk('public')->url('/icons/logo.svg') }}"
                    alt="">
            </a>
        </div>
        <div class="header__item--wrapper" id="search">
            <form action="/search" method="get">
                @csrf
                <input class="header__item--search" type="text" placeholder="なにをお探しですか？" name="keyword"
                    value="{{ $keyword ?? null }}">
                <button type="submit" id="search__btn">
                    <img src="{{ Storage::disk('public')->url('/icons/search.svg') }}">
                </button>
            </form>
        </div>
        <nav class="header__item--wrapper">
            <ul class="header__item--link__box">
                @if (Auth::check())
                    <li>
                        <form action="/logout" method="post">
                            @csrf
                            <button class="header__item--link" type="submit">
                                ログアウト
                            </button>
                        </form>
                    </li>
                    <li>
                        <a class="header__item--link" href="/mypage">
                            マイページ
                        </a>
                    </li>
                @else
                    <li>
                        <a class="header__item--link" href="/login">
                            ログイン
                        </a>
                    </li>
                    <li>
                        <a class="header__item--link" href="/register">
                            会員登録
                        </a>
                    </li>
                @endif
                <li>
                    @can('stripeAccountIdNull', Auth::user())
                        <form action="/stripe" method="post">
                            @csrf
                            <button class="header__item--link__btn" type="submit">
                                出品
                            </button>
                        </form>
                    @else
                        <button class="header__item--link__btn" onclick="location.href='/sell'">
                            出品
                        </button>
                    @endcan
                </li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
