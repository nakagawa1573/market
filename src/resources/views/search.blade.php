@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/search.css') }}">
@endsection

@section('content')
    <h1 class="ttl">
        @if ($items === null)
            検索結果
        @else
            {{ $keyword }}&nbsp;の検索結果
        @endif
    </h1>
    @if (isset($items))
        <section class="content">
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
        </section>
        @else
        <p class="content__nothing">
            キーワード検索、または絞り込みで商品を検索してください。
        </p>
    @endif
@endsection
