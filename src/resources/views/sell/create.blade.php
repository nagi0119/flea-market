@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-page">
    <div class="sell-page__inner">
        <h1 class="sell-page__title">商品の出品</h1>

        <form action="/sell" method="post" enctype="multipart/form-data" class="sell-form">
            @csrf

            <div class="sell-form__group">
                <label class="sell-form__label">商品画像</label>

                <div class="sell-form__image-box">
                    <label class="sell-form__image-button">
                        画像を選択する
                        <input type="file" name="image" class="sell-form__file">
                    </label>
                </div>
            </div>

            <div class="sell-form__section">
                <h2 class="sell-form__section-title">商品の詳細</h2>

                <div class="sell-form__group">
                    <label class="sell-form__label">カテゴリー</label>

                    <div class="category-list">
                        @foreach($categories as $category)
                        <label class="category-list__item">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                            <span>{{ $category->name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="sell-form__group">
                    <label class="sell-form__label">商品の状態</label>
                    <select name="item_condition" class="sell-form__select">
                        <option value="">選択してください</option>
                        <option value="1">良好</option>
                        <option value="2">目立った傷や汚れなし</option>
                        <option value="3">やや傷や汚れあり</option>
                        <option value="4">状態が悪い</option>
                    </select>
                </div>
            </div>

            <div class="sell-form__section">
                <h2 class="sell-form__section-title">商品名と説明</h2>

                <div class="sell-form__group">
                    <label class="sell-form__label">商品名</label>
                    <input type="text" name="name" class="sell-form__input">
                </div>

                <div class="sell-form__group">
                    <label class="sell-form__label">ブランド名</label>
                    <input type="text" name="brand_name" class="sell-form__input">
                </div>

                <div class="sell-form__group">
                    <label class="sell-form__label">商品の説明</label>
                    <textarea name="description" class="sell-form__textarea"></textarea>
                </div>

                <div class="sell-form__group">
                    <label class="sell-form__label">販売価格</label>
                    <div class="sell-form__price-wrap">
                        <span class="sell-form__price-mark">￥</span>
                        <input type="text" name="price" class="sell-form__input sell-form__input--price">
                    </div>
                </div>
            </div>

            <button type="submit" class="sell-form__button">出品する</button>
        </form>
    </div>
</div>
<script>
    const imageInput = document.querySelector('input[name="image"]');
    const imageBox = document.querySelector('.sell-form__image-box');
    const imageButton = document.querySelector('.sell-form__image-button');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function(event) {
            let preview = document.querySelector('.sell-form__preview');

            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'sell-form__preview';
                imageBox.prepend(preview);
            }

            preview.src = event.target.result;
            imageButton.style.display = 'none';
        };

        reader.readAsDataURL(file);
    });
</script>
@endsection