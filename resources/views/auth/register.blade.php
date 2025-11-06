<x-guest-layout>
    <div class="auth-container">

        <h1>アカウント作成</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <label for="name">名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>

            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>

            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" required>

            <label for="password_confirmation">パスワード再入力</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>

            <button type="submit">登録する</button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}">ログインはこちら</a>
        </div>

    </div>
</x-guest-layout>
