@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">

    <div class="mypage-profile">
        @if($user->profile && $user->profile->image_path)
        <img
            src="{{ asset('storage/' . $user->profile->image_path) }}"
            alt="プロフィール画像"
            class="mypage-profile__image">
        @else
        <div class="mypage-profile__image"></div>
        @endif

        <h1 class="mypage-profile__name">
            {{ $user->name }}
        </h1>

        <a href="/mypage/profile" class="mypage-profile__button">
            プロフィールを編集
        </a>
    </div>

    <div class="mypage-tabs">
        <a href="/mypage"
            class="mypage-tabs__link {{ $tab === 'buy' ? '' : 'mypage-tabs__link--active' }}">
            出品した商品
        </a>

        <a href="/mypage?tab=buy"
            class="mypage-tabs__link {{ $tab === 'buy' ? 'mypage-tabs__link--active' : '' }}">
            購入した商品
        </a>
    </div>

    <div class="mypage-items">
        @foreach($items as $item)

        <a href="/item/{{ $item->id }}" class="mypage-item">
            <img
                src="{{ Str::startsWith($item->image_path, 'http')
        ? $item->image_path
        : asset('storage/' . $item->image_path) }}"
                alt="{{ $item->name }}"
                class="mypage-item__image">

            <p class="mypage-item__name">
                {{ $item->name }}
            </p>
        </a>

        @endforeach
    </div>

</div>
@endsection