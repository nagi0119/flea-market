<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>COACHTECH</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>

    @auth
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo">
                <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
            </a>
            <form action="/" method="get" class="header-search">

                @if(request('tab'))
                <input type="hidden" name="tab" value="{{ request('tab') }}">
                @endif

                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    class="header-search__input"
                    placeholder="なにをお探しですか？">
            </form>

            <nav class="header-nav">
                <form action="/logout" method="post" class="header-nav__form">
                    @csrf
                    <button class="header-nav__button" type="submit">ログアウト</button>
                </form>

                <a href="/mypage" class="header-nav__link">マイページ</a>
                <a href="/sell/create" class="header-nav__sell">出品</a>
            </nav>
        </div>
    </header>
    @endauth

    @guest
    <header class="header">
        <div class="header__inner">
            <a href="/" class="header__logo">
                <img src="{{ asset('images/logo.png') }}" alt="COACHTECH">
            </a>

            <form action="/" method="get" class="header-search">

                @if(request('tab'))
                <input type="hidden" name="tab" value="{{ request('tab') }}">
                @endif

                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    class="header-search__input"
                    placeholder="なにをお探しですか？">
            </form>

            <nav class="header-nav">
                <a href="/login" class="header-nav__link">ログイン</a>
                <a href="/mypage" class="header-nav__link">マイページ</a>
                <a href="/sell/create" class="header-nav__sell">出品</a>
            </nav>
        </div>
    </header>
    @endguest

    <main>
        @yield('content')
    </main>

</body>

</html>