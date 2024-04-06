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
                <img class="header__ttl--img" src="{{ Storage::disk('public')->url('/icons/logo.svg') }}" alt="">
            </a>
        </div>
        <div class="header__item--wrapper" id="search">
            <form action="">
                <input class="header__item--search" type="text" placeholder="なにをお探しですか？">
            </form>
        </div>
        <nav class="header__item--wrapper">
            <ul class="header__item--link__box">
                <li>
                    @if (Auth::check())
                        <a class="header__item--link" href="">
                            ログアウト
                        </a>
                    @else
                        <a class="header__item--link" href="">
                            ログイン
                        </a>
                    @endif
                </li>
                <li>
                    @if (Auth::check())
                        <a class="header__item--link" href="">
                            マイページ
                        </a>
                    @else
                        <a class="header__item--link" href="">
                            会員登録
                        </a>
                    @endif
                </li>
                <li>
                    <button class="header__item--link__btn">
                        出品
                    </button>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
