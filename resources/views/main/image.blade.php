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

        <!-- 機能セクション -->
        <div class="functional-section">
        <h2>ぼかし機能</h2>
            @if (session('status'))
                <div class="alert">{{ session('status') }}</div>
            @endif

            <form action="/images/upload" method="POST" enctype="multipart/form-data" class="form-section">
                @csrf
                <input type="file" id="fileInput" name="images[]" multiple required>
                <div id="fileList"></div>
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

                            <!-- 削除ボタン -->
                            <form action="{{ route('images.destroy', $image->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button" onclick="return confirm('この画像を削除しますか？')">削除</button>
                            </form>
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

        <!-- 案内セクション -->
        <div class="info-section">
        <h2>操作ガイド</h2>
            <ul>
                <li>画像を1枚～複数アップロード</li>
                <li>アップロードボタンを押下</li>
                <li>ぼかし強度を決める
                    <ul>
                        <li>309が一番良く、数値が低いほどぼかし弱め</li>
                    </ul>
                </li>
                <li>実行ボタンを押下
                    <ul>
                        <li>しばらくローディングし、Pythonが実行される</li>
                    </ul>
                </li>
                <li>ダウンロードリストが生成されるため画像をダウンロード
                    <ul>
                        <li>※ダウンロードした画像は削除されるため要注意</li>
                    </ul>
                </li>
            </ul>

            <p>以下の点に注意の上ダウンロード後の画像はよく確認すること</p>
            <ul class="warning-list">
                <li>車輌のウィングが消える</li>
                <li>隣あった車輌にはぼかしが効かない</li>
                <li>ナンバープレートはそのまま</li>
            </ul>
        </div>
    </div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("fileInput");
    const fileList = document.getElementById("fileList");

    let selectedFiles = [];

    fileInput.addEventListener("change", function () {
        selectedFiles = Array.from(fileInput.files);
        renderFileList();
    });

    function renderFileList() {
        fileList.innerHTML = "";

        selectedFiles.forEach((file, index) => {
            const item = document.createElement("div");
            item.classList.add("file-item");
            item.innerHTML = `
                ${file.name}
                <button type="button" onclick="removeFile(${index})">削除</button>
            `;
            fileList.appendChild(item);
        });

        // create new DataTransfer and re-attach files
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    window.removeFile = function (index) {
        selectedFiles.splice(index, 1);
        renderFileList();
    }
});
</script>

</body>
</html>
