@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endsection

@section('content')
<div class="order-page">
    <div class="order-page__inner">



        <div class="order-page__left">
            <div class="order-item">
                <img
                    src="{{ $item->image_path }}"
                    alt="{{ $item->name }}"
                    class="order-item__image">

                <div class="order-item__text">
                    <h1 class="order-item__name">
                        {{ $item->name }}
                    </h1>

                    <p class="order-item__price">
                        ¥ {{ number_format($item->price) }}
                    </p>
                </div>
            </div>

            <section class="order-section">
                <h1 class="order-section__title">
                    支払い方法
                </h1>

                <select
                    name="payment_method"
                    form="order-form"
                    class="order-section__select"
                    id="payment-select">
                    <option value="">選択してください</option>
                    <option value="1">コンビニ払い</option>
                    <option value="2">カード支払い</option>
                </select>
            </section>

            <section class="order-section">
                <div class="order-section__heading">
                    <h1 class="order-section__title">
                        配送先
                    </h1>

                    <a href="/order/address/{{ $item->id }}" class="order-section__link">
                        変更する
                    </a>
                </div>

                <p class="order-address">
                    〒 {{ $profile->postal_code }}<br>

                    {{ $profile->address }}

                    {{ $profile->building_name }}
                </p>
            </section>
        </div>

        <div class="order-page__right">
            <div class="order-summary">
                <div class="order-summary__row">
                    <span>商品代金</span>

                    <span>
                        ¥ {{ number_format($item->price) }}
                    </span>
                </div>

                <div class="order-summary__row">
                    <span>支払い方法</span>

                    <span id="payment-method">
                        選択してください
                    </span>
                </div>
            </div>

            <form id="order-form" action="/item/{{ $item->id }}/order" method="post">
                @csrf
                <button class="order-button" type="submit">
                    購入する
                </button>
            </form>
        </div>

    </div>
</div>

<script>
    const paymentSelect = document.getElementById('payment-select');
    const paymentMethod = document.getElementById('payment-method');

    paymentSelect.addEventListener('change', function() {
        paymentMethod.textContent =
            paymentSelect.options[paymentSelect.selectedIndex].text;
        console.log(paymentSelect.value);
    });
</script>
@endsection