@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
    <section class="content">
        @php
            $item = session('item');
        @endphp
        <article class="content__item">
            <div class="content__img--box">
                <div id="img">
                    @if (app()->isLocal())
                        <img src="{{ Storage::disk('public')->url('/items/' . $item->img) }}">
                    @elseif(app()->isProduction())
                        <img src="{{ Storage::disk('s3')->url('/items/' . $item->img) }}">
                    @endif
                </div>
                <div class="item__wrapper">
                    <h1 id="name">
                        {{ $item->name }}
                    </h1>
                </div>
            </div>
            <div class="content__box">
                <h2 class="content__item--ttl">
                    配送先
                </h2>
                @if ($delivery)
                    <p class="contetn__item--address">
                        {{ $delivery['post_code'] }}
                    </p>
                    <p class="contetn__item--address">
                        {{ $delivery['address'] }}
                    </p>
                    <p class="contetn__item--address">
                        {{ $delivery['building'] }}
                    </p>
                @else
                    <p class="contetn__item--address">
                        {{ $profile['post_code'] }}
                    </p>
                    <p class="contetn__item--address">
                        {{ $profile['address'] }}
                    </p>
                    <p class="contetn__item--address">
                        {{ $profile['building'] }}
                    </p>
                @endif
                <div id="wrapper__links">
                    <a class="content__item--link" href="/purchase/delivery">
                        変更する
                    </a>
                    @if ($delivery)
                        |
                        <form action="/purchase/delivery" method="post">
                            @csrf
                            @method('delete')
                            <button id="link__btn" type="submit">
                                元に戻す
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </article>
        <article class="content__item">
            <div class="content__item--box">
                <div class="content__item--group">
                    <p id="data__ttl">
                        商品代金
                    </p>
                    <p id="data">
                        ￥{{ number_format($item->price) }}
                    </p>
                </div>
                <div class="content__item--group">
                    <p id="data__ttl">
                        支払い金額
                    </p>
                    <p id="data">
                        @if ($item->price >= 3500)
                            ￥{{ number_format($item->price) }}
                        @else
                            ￥{{ number_format($item->price + 500) }}
                        @endif
                    </p>
                </div>
            </div>
            <article class="content__item--form">
                <form action="/purchase/{{ $item->id }}" method="post" id="purchase-form">
                    @csrf
                    <div id="payment-element"></div>
                    <button class="content__item--btn" type="button" id="card-button">
                        購入する
                    </button>
                </form>
            </article>
            <script src="https://js.stripe.com/v3/"></script>
            <script>
                const stripe = Stripe(@json(config('cashier.key')));
                const clientSecret = @json($clientSecret);
                const returnUrl = @json(config('app.return_url'));
            </script>
            <script src="{{ asset('js/stripe.js') }}"></script>
        </article>
    </section>
@endsection
