@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="item-detail">
    <div class="item-detail__inner">

        <div class="item-detail__image-area">
            <img
                src="{{ Str::startsWith($item->image_path, 'http')
        ? $item->image_path
        : asset('storage/' . $item->image_path) }}"
                alt="{{ $item->name }}"
                class="item-detail__image">
        </div>

        <div class="item-detail__content">
            <h1 class="item-detail__name">{{ $item->name }}</h1>

            <p class="item-detail__brand">
                {{ $item->brand_name ?? 'ブランドなし' }}
            </p>

            <p class="item-detail__price">
                ¥{{ number_format($item->price) }} <span>税込</span>
            </p>

            <div class="item-detail__icons">

                <div class="item-detail__icon">
                    <form action="/item/{{ $item->id }}/favorite" method="post" class="favorite-form">
                        @csrf

                        <button type="submit" class="favorite-button">
                            @if($isLiked)
                            <img
                                src="{{ asset('images/icon/heart-active.png') }}"
                                alt="いいね済み"
                                class="item-detail__icon-image">
                            @else
                            <img
                                src="{{ asset('images/icon/heart.png') }}"
                                alt="いいね"
                                class="item-detail__icon-image">
                            @endif
                        </button>
                    </form>

                    <p>{{ $likesCount }}</p>
                </div>


                <div class="item-detail__icon">
                    <img
                        src="{{ asset('images/icon/comment.png') }}"
                        alt="コメント"
                        class="item-detail__icon-image">

                    <p>{{ $commentsCount }}</p>
                </div>

            </div>

            @if(auth()->check() && auth()->id() !== $item->user_id && !$item->is_sold)
            <a href="/item/{{ $item->id }}/order" class="item-detail__button">
                購入手続きへ
            </a>
            @endif

            <section class="item-section">
                <h1 class="item-section__title">商品説明</h1>
                <p class="item-section__text">{{ $item->description }}</p>
            </section>

            <section class="item-section">
                <h1 class="item-section__title">商品の情報</h1>

                <div class="item-info">
                    <p class="item-info__label">カテゴリー</p>
                    <div class="item-info__tags">
                        @foreach ($item->categories as $category)
                        <span>{{ $category->name }}</span>
                        @endforeach
                    </div>
                </div>

                <div class="item-info">
                    <p class="item-info__label">商品の状態</p>
                    <p class="item-info__text">
                        @switch($item->item_condition)
                        @case(1)
                        良好
                        @break
                        @case(2)
                        目立った傷や汚れなし
                        @break
                        @case(3)
                        やや傷や汚れあり
                        @break
                        @case(4)
                        状態が悪い
                        @break
                        @endswitch
                    </p>
                </div>
            </section>

            <section class="comment-section">
                <h1 class="comment-section__title">
                    コメント({{ $commentsCount }})
                </h1>

                @foreach($item->comments as $comment)
                <div class="comment-user">
                    <div class="comment-user__image"></div>

                    <p class="comment-user__name">
                        {{ $comment->user->name }}
                    </p>
                </div>

                <div class="comment-box">
                    {{ $comment->content }}
                </div>
                @endforeach

                <form
                    action="/item/{{ $item->id }}/comment"
                    method="post"
                    class="comment-form">

                    @csrf

                    <label class="comment-form__label">
                        商品へのコメント
                    </label>

                    <textarea
                        name="content"
                        class="comment-form__textarea">{{ old('content') }}</textarea>

                    @error('content')
                    <p class="form-error">{{ $message }}</p>
                    @enderror

                    <button class="comment-form__button" type="submit">
                        コメントを送信する
                    </button>
                </form>
            </section>
        </div>

    </div>
</div>
@endsection