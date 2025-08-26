<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像ぼかし処理</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>画像ぼかしアップローダー</h1>

    <form id="upload-form" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple required>
        <button type="submit">画像アップロード</button>
    </form>

    <button id="run-button" disabled>画像処理を実行</button>

    <script>
        const uploadForm = document.getElementById('upload-form');
        const runButton = document.getElementById('run-button');

        uploadForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(uploadForm);

            fetch('/upload', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert('アップロード完了');
                runButton.disabled = false;
            })
            .catch(error => {
                console.error(error);
                alert('アップロードに失敗しました');
            });
        });

        runButton.addEventListener('click', function() {
            fetch('/process', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) throw new Error('画像処理に失敗しました');
                return response.blob();
            })
            .then(blob => {
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'processed.jpg';
                link.click();
            })
            .catch(error => {
                console.error(error);
                alert('処理に失敗しました');
            });
        });
    </script>
</body>
</html>
