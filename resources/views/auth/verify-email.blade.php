<x-guest-layout>
    <div class="auth-container">

        <h1>メールアドレス確認</h1>

        <p>登録メールアドレスへ確認用メールを送信しました。</p>
        <p>メール内のリンクからアカウントを有効にしてください。</p>

        @if (session('status') == 'verification-link-sent')
            <p style="color: green; text-align:center; margin-top:10px;">
                確認メールを再送しました。
            </p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit">確認メールを再送</button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top:10px;">
            @csrf
            <button type="submit">ログアウト</button>
        </form>

    </div>
</x-guest-layout>
