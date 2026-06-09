@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-page">
    <div class="login-card">

        <h1 class="login-card__title">ログイン</h1>

        <form action="/login" method="post" class="login-form">
            @csrf

            <div class="login-form__group">
                <label class="login-form__label">メールアドレス</label>
                <input class="login-form__input" type="email" name="email">
                @error('email')
                <p class="login-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="login-form__group">
                <label class="login-form__label">パスワード</label>
                <input class="login-form__input" type="password" name="password">
                @error('password')
                <p class="login-form__error">{{ $message }}</p>
                @enderror
            </div>

            <button class="login-form__button" type="submit">ログインする</button>
        </form>

        <a href="/register" class="login-card__link">会員登録はこちら</a>

    </div>
</div>
@endsection