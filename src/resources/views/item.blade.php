@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="content__img">
            @if (app()->isLocal())
                <img id="img" src="{{ Storage::disk('public')->url('/items/' . $item->img) }}" alt="">
            @elseif(app()->isProduction())
                <img id="img" src="{{ Storage::disk('s3')->url('/items/' . $item->img) }}" alt="">
            @endif
        </div>
        <article class="content__item">
            <div class="content__item--box">
                <h1 id="name">
                    {{ $item->name }}
                </h1>
                <p id="brand">
                    {{ $item->brand }}
                </p>
                <p id="price">
                    ￥{{ number_format($item->price) }}
                </p>
                <div class="content__item--link__wrapper">
                    <div class="content__item--link">
                        <form action="/item/favorite/{{ $item->id }}" method="post">
                            @csrf
                            <button id="favorite" type="submit">
                                @if ($favoriteFlag)
                                    @method('DELETE')
                                    <img id="icon__img" src="{{ Storage::disk('public')->url('/icons/star_check.svg') }}">
                                @else
                                    <img id="icon__img" src="{{ Storage::disk('public')->url('/icons/star.svg') }}">
                                @endif
                            </button>
                        </form>
                        <p id="count">
                            {{ $favoriteCount }}
                        </p>
                    </div>
                    <div class="content__item--link">
                        <button id="switch" onclick="openModal();">
                            <img id="icon__img" src="{{ Storage::disk('public')->url('/icons/bubble.svg') }}">
                        </button>
                        <p id="count">
                            {{ $commentCount }}
                        </p>
                    </div>
                </div>
                @error('comment')
                    <p id="error">
                        {{ $message }}
                    </p>
                @enderror
                <p>
                    {{ session('message') }}
                </p>
            </div>
            <div class="content__item--box" id="modal">
                <form action="/item/comment/{{ $item->id }}" method="post">
                    @csrf
                    <h3 class="content__item--ttl">
                        商品へのコメント
                    </h3>
                    <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                    <button class="content__item--btn">
                        コメントを送信する
                    </button>
                </form>
            </div>
            <div id="main">
                @if (!$purchaseFlag)
                    <form action="/purchase/{{ $item->id }}" method="get">
                        @csrf
                        <button class="content__item--btn">
                            購入する
                        </button>
                    </form>
                @else
                    <div class="content__item--sold">
                        売り切れました
                    </div>
                @endif
                <div class="content__item--box">
                    <h2 class="content__item--ttl">
                        商品説明
                    </h2>
                    <p class="description">
                        {!! nl2br(htmlspecialchars($item->description)) !!}
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
                            @foreach ($item->category as $category)
                                <p id="category">
                                    {{ $category->name }}
                                </p>
                            @endforeach
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
        </article>
    </section>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
