@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address-page">
    <h1 class="address-page__title">住所の変更</h1>

    <form action="/order/address/{{ $item->id }}" method="post" class="address-form">
        @csrf

        <div class="address-form__group">
            <label class="address-form__label">郵便番号</label>
            <input
                type="text"
                name="postal_code"
                value="{{ old('postal_code', $profile->postal_code) }}"
                class="address-form__input">
        </div>

        <div class="address-form__group">
            <label class="address-form__label">住所</label>
            <input
                type="text"
                name="address"
                value="{{ old('address', $profile->address) }}"
                class="address-form__input">
        </div>

        <div class="address-form__group">
            <label class="address-form__label">建物名</label>
            <input
                type="text"
                name="building_name"
                value="{{ old('building_name', $profile->building_name) }}"
                class="address-form__input">
        </div>

        <button class="address-form__button" type="submit">
            更新する
        </button>
    </form>
</div>
@endsection