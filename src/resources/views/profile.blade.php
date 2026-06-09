@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-page">
    <h1 class="profile-page__title">プロフィール設定</h1>


    <form class="profile-form" method="post" action="/mypage/profile" enctype="multipart/form-data">
        @csrf

        <div class="profile-form__image-area">

            @if(!empty($profile?->image_path))
            <img
                src="{{ asset('storage/' . $profile->image_path) }}"
                alt="プロフィール画像"
                class="profile-form__image">
            @else
            <div class="profile-form__image"></div>
            @endif

            <label class="profile-form__image-button">
                画像を選択する
                <input type="file" name="image" hidden>
            </label>
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label">ユーザー名</label>
            <input class="profile-form__input" type="text" name="name"
                value="{{ old('name', auth()->user()->name) }}">

            @error('name')
            <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label">郵便番号</label>
            <input class="profile-form__input" type="text" name="postal_code"
                value="{{ old('postal_code', auth()->user()->profile->postal_code ?? '') }}">

            @error('postal_code')
            <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label">住所</label>
            <input class="profile-form__input" type="text" name="address"
                value="{{ old('address', auth()->user()->profile->address ?? '') }}">

            @error('address')
            <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <div class="profile-form__group">
            <label class="profile-form__label">建物名</label>
            <input class="profile-form__input" type="text" name="building"
                value="{{ old('building', auth()->user()->profile->building_name ?? '') }}">

            @error('building')
            <p style="color:red;">{{ $message }}</p>
            @enderror
        </div>

        <button class="profile-form__button" type="submit">更新する</button>
    </form>
</div>
<script>
    const imageInput = document.querySelector('input[name="image"]');
    const imageArea = document.querySelector('.profile-form__image-area');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (!file) {
            return;
        }

        const reader = new FileReader();

        reader.onload = function(event) {
            let image = document.querySelector('.profile-form__image');

            if (image.tagName.toLowerCase() !== 'img') {
                const newImage = document.createElement('img');
                newImage.className = 'profile-form__image';
                image.replaceWith(newImage);
                image = newImage;
            }

            image.src = event.target.result;
        };

        reader.readAsDataURL(file);
    });
</script>
@endsection