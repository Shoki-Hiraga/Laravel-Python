<x-guest-layout>
    <div class="auth-container">

        <h1>ログイン</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>

            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">ログイン</button>
        </form>

        <div class="auth-links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">パスワードを忘れた方はこちら</a>
            @endif

            <br>

            <a href="{{ route('register') }}">アカウント作成はこちら</a>
        </div>

    </div>
</x-guest-layout>
