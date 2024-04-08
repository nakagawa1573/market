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
    {{-- おすすめとマイリストの切り替えはコントローラーでflagを持たせてifで切り替える --}}
    <section class="content" id="main">
        @if (isset($items))
            @foreach ($items as $item)
                <article class="content__item">
                    <a class="content__item--link" href="/item/{{ $item->id }}">
                        <img class="content__item--link__img"
                            src="{{ Storage::disk('public')->url('/items') . '/' . $item->img }}">
                    </a>
                </article>
            @endforeach
        @endif
    </section>
    <section class="content" id="modal">
        @if (isset($favorites))
            @foreach ($favorites as $favorite)
                <article class="content__item">
                    <a class="content__item--link" href="/item/{{$favorite->item->id}}">
                        <img class="content__item--link__img"
                            src="{{ Storage::disk('public')->url('/items') . '/' . $favorite->item->img }}">
                    </a>
                </article>
            @endforeach
        @endif
    </section>
    <script src="{{ asset('js/main.js') }}"></script>
@endsection
