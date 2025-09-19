<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像入稿フォーム</title>
    <link rel="stylesheet" href="{{ asset('css/PurchaseResultsImage.css') }}">
</head>
<body>
    <div class="container">
        <h1>画像入稿フォーム</h1>

        {{-- 成功メッセージ --}}
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        {{-- バリデーションエラー --}}
        @if ($errors->any())
            <div class="alert error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('purchase_results_images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="purchase_results_id">purchase_results_ID</label>
                <input type="number" name="purchase_results_id" id="purchase_results_id" required>
            </div>

            <div class="form-group">
                <label for="k_number">k_number</label>
                <input type="text" name="k_number" id="k_number" required>
            </div>

            <div class="form-group">
                <label for="image">画像ファイル</label>
                <input type="file" name="image" id="image" accept="image/*" required>
            </div>

            <div class="form-group">
                <button type="submit">アップロード</button>
            </div>
        </form>
    </div>
</body>
</html>
