<x-guest-layout>
    <div class="auth-container">

        <h1>パスワードリセット</h1>

        <p>登録されたメールアドレス宛に、パスワードリセット用のリンクを送信します。</p>

        @if (session('status'))
            <p style="color: green; text-align:center; margin-top:10px;">
                {{ session('status') }}
            </p>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                required autofocus />

            <button type="submit">
                送信する
            </button>
        </form>

        <div class="auth-links">
            <a href="{{ route('login') }}">ログインに戻る</a>
        </div>

    </div>
</x-guest-layout>
