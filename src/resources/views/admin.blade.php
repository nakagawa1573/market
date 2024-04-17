@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('content')
    <section class="content">
        {{session('message')}}
        @if ($errors->any())
            {{$errors->first()}}
        @endif
        <form action="?" method="post" id="form">
            @csrf
            <button id="btn" type="submint" formaction="/admin/delete" onclick="submitDelete();">
                削除
            </button>
            <a id="open" onclick="openModal();">
                メール
            </a>
            <table>
                <tr class="header__row">
                    <th id="header__checkbox">
                        <input type="checkbox" id="all__check" onclick="allCheck();">
                    </th>
                    <th>
                        ID
                    </th>
                    <th>
                        メールアドレス
                    </th>
                    <th>
                        管理者
                    </th>
                    <th>
                        作成日
                    </th>
                    <th>
                        最終ログイン
                    </th>
                </tr>
                @foreach ($users as $user)
                    <tr class="data__row">
                        <td id="check">
                            <input type="checkbox" name="id[]" value="{{ $user->id }}">
                        </td>
                        <td id="id">
                            {{ $user->id }}
                        </td>
                        <td id="email">
                            {{ $user->email }}
                        </td>
                        <td id="role">
                            @if ($user->role === 'admin')
                                はい
                            @else
                                いいえ
                            @endif
                        </td>
                        <td id="date">
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td id="date">
                            {{ $user->login_at !== null ? Carbon\Carbon::parse($user->login_at)->format('Y-m-d H:i') : '' }}
                        </td>
                    </tr>
                @endforeach
            </table>
            <article id="modal">
                <div class="email__box">
                    <div class="email__wrapper">
                        <input type="text" id="subject" name="subject">
                    </div>
                    <textarea id="text" name="text"></textarea>
                </div>
                <div class="email__btn--wrapper">
                    <button class="email__btn--submit" formaction="/admin/email">
                        送信
                    </button>
                    <button type="button" class="email__btn--delete" id="close" onclick="closeModal();">
                        <img src="{{ Storage::disk('public')->url('/icons/delete.svg') }}">
                    </button>
                </div>
            </article>
        </form>
    </section>
    <script src="{{ asset('js/admin.js') }}"></script>
@endsection
