<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像ぼかし一括処理</title>
    <link rel="stylesheet" href="{{ asset('css/image_python.css') }}">

</head>
<body>
    <div id="loading-overlay" style="display: none;">
        <div class="spinner"></div>
        <p>画像処理を実行中です。<br>しばらくお待ちください...</p>
    </div>

    @if (isset($log))
    <div id="result-modal" class="modal-overlay">
        <div class="modal-content">
            <h2>画像処理が完了しました</h2>
            <div class="modal-buttons">
                <button id="return-top-btn">TOPに戻って画像をダウンロードする</button>
                <button id="view-log-btn">開発ログを見る</button>
            </div>
        </div>
    </div>
    @endif

    <div class="container">
        <h1>画像ぼかし一括処理</h1>

        @if (!isset($log))
        <div class="functional-section">
            <h2>ぼかし機能 ※1実行10件まで</h2>
            @if (session('status'))
                <div class="alert">{{ session('status') }}</div>
            @endif

            <form action="/images/upload" method="POST" enctype="multipart/form-data" class="form-section">
                @csrf
                <input type="file" id="fileInput" name="images[]" multiple required>
                <div id="fileList"></div>
                <button type="submit">アップロード</button>
            </form>

            <form action="/images/process" method="POST" class="form-section" id="process-form">
                @csrf
                <label for="blur">ぼかし強度（奇数）:</label>
                <input type="number" name="blur" id="blur" min="1" max="999" step="2" value="309">
                <button type="submit">実行</button>
            </form>
        </div>
        @endif


        @if (!isset($log))
            @if ($images->count())
                <div class="download-section">
                    <h2>処理済み画像のダウンロード</h2>
                    <ul class="image-list">
                        @foreach ($images as $image)
                            <li>
                                {{ $image->original_name }}
                                <a href="{{ url('/images/download/' . $image->id) }}">ダウンロード</a>

                                <form action="{{ route('images.destroy', $image->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-button" onclick="return confirm('この画像を削除しますか？')">削除</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif


        @if (isset($log))
            <div class="log-section">
                <h2>実行ログ</h2>
                <h3><a href="{{ route('images') }}">TOPページへ</a></h3>
                <pre class="terminal-log">
                    @foreach ($log as $line)
                        <span>{{ $line }}</span>
                    @endforeach
                </pre>
            </div>
        @endif

        @if (!isset($log))
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
        @endif
    </div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("fileInput");
    const fileList = document.getElementById("fileList");

    let selectedFiles = [];

    // fileInputが存在する場合のみイベントリスナーを設定
    if(fileInput) {
        fileInput.addEventListener("change", function () {
            selectedFiles = Array.from(fileInput.files);
            renderFileList();
        });
    }

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

        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    window.removeFile = function (index) {
        selectedFiles.splice(index, 1);
        renderFileList();
    }

    const processForm = document.getElementById('process-form');
    if (processForm) {
        processForm.addEventListener('submit', function(event) {
            const imageList = document.querySelector('.image-list');
            if (!imageList || imageList.children.length === 0) {
                alert('画像がアップロードされていません。先に画像をアップロードしてください。');
                event.preventDefault();
                return;
            }
            document.getElementById('loading-overlay').style.display = 'flex';
            const buttons = document.querySelectorAll('button');
            buttons.forEach(button => {
                button.disabled = true;
            });
        });
    }

    @if (isset($log))
        const resultModal = document.getElementById('result-modal');
        const returnTopBtn = document.getElementById('return-top-btn');
        const viewLogBtn = document.getElementById('view-log-btn');

        // TOPに戻るボタンの処理
        returnTopBtn.addEventListener('click', function() {
            window.location.href = '/images';
        });

        // ログを見るボタンの処理
        viewLogBtn.addEventListener('click', function() {
            resultModal.style.display = 'none'; // モーダルを非表示にする
        });
    @endif
});
</script>

</body>
</html>