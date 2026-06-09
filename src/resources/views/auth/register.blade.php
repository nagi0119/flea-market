@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register-page">
    <div class="register-card">
        <h1 class="register-card__title">会員登録</h1>

        <form action="/register" method="post" class="register-form">
            @csrf

            <div class="register-form__group">
                <label class="register-form__label">ユーザー名</label>
                <input class="register-form__input" type="text" name="name" value="{{ old('name') }}">
                @error('name')
                <p class="register-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="register-form__group">
                <label class="register-form__label">メールアドレス</label>
                <input class="register-form__input" type="email" name="email" value="{{ old('email') }}">
                @error('email')
                <p class="register-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="register-form__group">
                <label class="register-form__label">パスワード</label>
                <input class="register-form__input" type="password" name="password">
                @error('password')
                <p class="register-form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="register-form__group">
                <label>確認用パスワード</label>
                <input class="register-form__input" type="password" name="password_confirmation">

                @error('password_confirmation')
                <p class="register-form__error">{{ $message }}</p>
                @enderror
            </div>

            <button class="register-form__button" type="submit">登録する</button>
        </form>


        <a href="/login" class="register-card__login-link">ログインはこちら</a>
    </div>
</div>
@endsection