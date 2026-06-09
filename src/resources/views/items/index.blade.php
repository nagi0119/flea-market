@php
use Illuminate\Support\Str;
@endphp
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection


@section('content')
<div class="item-page">
    <div class="item-tabs">
        <a href="/"
            class="item-tabs__link {{ $isMylist ? '' : 'item-tabs__link--active' }}">
            おすすめ
        </a>

        <a href="/?tab=mylist"
            class="item-tabs__link {{ $isMylist ? 'item-tabs__link--active' : '' }}">
            マイリスト
        </a>
    </div>

    <div class="item-list">
        @foreach ($items as $item)
        <div class="item-card">
            <a href="/item/{{ $item->id }}" class="item-card__link">
                <div class="item-card__image-wrap">
                    <img
                        src="{{ Str::startsWith($item->image_path, 'http')
        ? $item->image_path
        : asset('storage/' . $item->image_path) }}"
                        alt="{{ $item->name }}"
                        class="item-card__image">

                    @if ($item->is_sold)
                    <span class="item-card__sold">Sold</span>
                    @endif
                </div>

                <p class="item-card__name">{{ $item->name }}</p>

            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection