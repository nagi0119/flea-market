@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verify-email">
    <p>
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>

    <form method="POST" action="/email/verification-notification">
        @csrf
        <button type="submit" class="verify-email__button">
            認証はこちらから
        </button>
    </form>

    <a href="#" class="verify-email__link">
        認証メールを再送する
    </a>
</div>
@endsection