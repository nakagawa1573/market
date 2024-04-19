@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="tab__wrapper">
        <div class="tab">
            <button class="tab__item" id="select">おすすめ</button>
            <button class="tab__item" id="none" onclick="switchTab();">マイリスト</button>
        </div>
    </div>
    <section class="content" id="main">
        @if (isset($items))
            @foreach ($items as $item)
                <article class="content__item">
                    <a class="content__item--link" href="/item/{{ $item->id }}">
                        @if (app()->isLocal())
                            <img class="content__item--link__img"
                                src="{{ Storage::disk('public')->url('/items/' . $item->img) }}">
                        @elseif(app()->isProduction())
                            <img class="content__item--link__img"
                                src="{{ Storage::disk('s3')->url('/items/' . $item->img) }}">
                        @endif
                    </a>
                    <p class="content__item--name">
                        {{ Illuminate\Support\Str::limit($item->name, 40, '...') }}
                    </p>
                    <div class="content__item--price">
                        ￥{{ number_format($item->price) }}
                    </div>
                </article>
            @endforeach
        @endif
    </section>
    <section class="content" id="modal">
        @if (isset($favorites))
            @foreach ($favorites as $favorite)
                <article class="content__item">
                    <a class="content__item--link" href="/item/{{ $favorite->item->id }}">
                        @if (app()->isLocal())
                            <img class="content__item--link__img"
                                src="{{ Storage::disk('public')->url('/items/' . $favorite->item->img) }}">
                        @elseif(app()->isProduction())
                            <img class="content__item--link__img"
                                src="{{ Storage::disk('s3')->url('/items/' . $favorite->item->img) }}">
                        @endif
                    </a>
                    <p class="content__item--name">
                        {{ Illuminate\Support\Str::limit($favorite->item->name, 40, '...') }}
                    </p>
                    <div class="content__item--price">
                        ￥{{ number_format($favorite->item->price) }}
                    </div>
                </article>
            @endforeach
        @endif
    </section>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
