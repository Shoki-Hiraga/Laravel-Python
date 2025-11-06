<x-guest-layout>
    <div class="auth-container">

        <h1>新しいパスワードを設定</h1>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email"
                value="{{ old('email', $request->email) }}" required autofocus />

            <label for="password">新しいパスワード</label>
            <input id="password" type="password" name="password" required />

            <label for="password_confirmation">パスワード再入力</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required />

            <button type="submit">更新する</button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}">ログインへ戻る</a>
        </div>

    </div>
</x-guest-layout>
