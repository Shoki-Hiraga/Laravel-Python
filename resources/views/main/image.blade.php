<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像ぼかし一括処理</title>
    <link rel="stylesheet" href="{{ asset('css/image_python.css') }}">
</head>
<body>
    <div class="container">
        <h1>画像ぼかし一括処理</h1>
        <ul>
            <li>画像を1枚～複数アップロード</li>
            <li>画像を1枚～複数アップロードボタンを押下</li>
            <li>ぼかし強度を決める
            <ul>
                309が一番良く、数値が低いほどぼかし弱め</li>
            </ul>
            <li>実行ボタンを押下</li>
            <ul>
                <li>しばらくローディングし、Pythonが実行される</li>
            </ul>
            <li>ダウンロードリストが生成されるため画像をダウンロード</li>
            <ul>
                <li>※ダウンロードしたら画像は削除されるため要注意</li>
            </ul>
        </ul>
        @if (session('status'))
            <div class="alert">{{ session('status') }}</div>
        @endif

        <form action="/images/upload" method="POST" enctype="multipart/form-data" class="form-section">
            @csrf
            <input type="file" name="images[]" multiple required>
            <button type="submit">アップロード</button>
        </form>

        <form action="/images/process" method="POST" class="form-section">
            @csrf
            <label for="blur">ぼかし強度（奇数）:</label>
            <input type="number" name="blur" id="blur" min="1" max="999" step="2" value="309">
            <button type="submit">実行</button>
        </form>


        @if ($images->count())
            <h2>処理済み画像のダウンロード</h2>
            <ul class="image-list">
                @foreach ($images as $image)
                    <li>
                        {{ $image->original_name }}
                        <a href="{{ url('/images/download/' . $image->id) }}">ダウンロード</a>
                    </li>
                @endforeach
            </ul>
        @endif

        @if (isset($log))
            <h2>実行ログ</h2>
            <pre class="terminal-log">
@foreach ($log as $line)
<span>{{ $line }}</span>
@endforeach
            </pre>
        @endif
    </div>
</body>
</html>
