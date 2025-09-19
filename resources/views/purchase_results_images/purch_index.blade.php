<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>画像一覧</title>
    <link rel="stylesheet" href="{{ asset('css/PurchaseResultsImage.css') }}">
</head>
<body>
<div class="container">
    <h1>アップロード済み画像一覧</h1>
    <h2><a href="{{ route('purchase_results_images.create') }}">買取実績画像入稿</a></h2>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    <div class="nav-links">
        <a href="{{ route('purchase_results_images.create') }}" class="btn">新規アップロード</a>
    </div>

    <table class="image-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>purchase_results_id</th>
                <th>k_number</th>
                <th>プレビュー</th>
                <th>image_path</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse($images as $image)
                <tr>
                    <td>{{ $image->id }}</td>
                    <td>{{ $image->purchase_results_id }}</td>
                    <td>{{ $image->k_number }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="画像" class="thumb">
                    </td>
                    <td>
                        {{ $image->image_path }}
                    </td>
                    <td>
                        <a href="{{ route('purchase_results_images.download', $image->id) }}" class="btn btn-download">ダウンロード</a>

                        <form action="{{ route('purchase_results_images.destroy', $image->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" onclick="return confirm('削除してもよろしいですか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">アップロードされた画像はありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ページネーションリンク --}}
    <div class="pagination">
        {{ $images->links() }}
    </div>
</div>
</body>
</html>
