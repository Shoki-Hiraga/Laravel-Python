<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像アップロードと処理</title>
</head>
<body>
    <h1>画像アップロード</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form action="/images/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple required>
        <button type="submit">アップロード</button>
    </form>

    @if ($images->count())
        <form action="/images/process" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit">実行</button>
        </form>

        <h2>処理済み画像のダウンロード</h2>
        <ul>
        @foreach ($images as $image)
            <li>
                {{ $image->original_name }}
                <a href="{{ url('/images/download/' . $image->id) }}">ダウンロード</a>
            </li>
        @endforeach
        </ul>
    @endif
</body>
</html>
