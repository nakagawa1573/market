@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="tab__wrapper">
        <div class="tab">
            <a class="tab__item--select" href="">おすすめ</a>
            <a class="tab__item" href="">マイリスト</a>
        </div>
    </div>
    {{-- おすすめとマイリストの切り替えはコントローラーでflagを持たせてifで切り替える --}}
    <section class="content">
        @for ($i = 0; $i < 12; $i++)
            <article class="content__item">
                <a class="content__item--link" href="">
                    <img class="content__item--link__img" src="{{ Storage::disk('public')->url('/G-GEAR-G1.jpg') }}"
                        alt="">
                </a>
            </article>
        @endfor
    </section>
    <section class="content">
        @for ($i = 0; $i < 7; $i++)
            <article class="content__item">
                <a class="content__item--link" href="">
                    <img class="content__item--link__img" src="{{ Storage::disk('public')->url('/items/G-GEAR-G2.jpg') }}"
                        alt="">
                </a>
            </article>
        @endfor
    </section>
@endsection
