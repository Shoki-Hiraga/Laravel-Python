<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    {{-- 管理画面レイアウト --}}
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="#">Users</a>
        {{-- 必要に応じてメニューを追加 --}}
    </div>

    <div class="content">
        {{ $slot }}
    </div>

</body>
</html>
