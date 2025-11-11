<x-app-layout>

<link rel="stylesheet" href="{{ asset('css/runpy.css') }}">

<div class="runpy-wrapper">

    <h1 class="runpy-header">Python 実行一覧</h1>

    @if (session('error'))
        <p class="error">{{ session('error') }}</p>
    @endif


    @php
        $folders = [];

        foreach ($files as $file) {

            // 「最初の階層だけ取得」
            $parts = explode('/', $file);

            if (count($parts) > 1) {
                $folder = $parts[0];     // ← GA4_scraping とか GSC_scraping
            } else {
                $folder = 'root';        // ← root 直下の .py
            }

            $folders[$folder][] = $file;
        }
    @endphp


    @foreach ($folders as $folder => $fileList)
        {{-- ▼ トグル（フォルダ名） --}}
        <div class="toggle-folder" data-folder="{{ $folder }}">
            ▶ {{ $folder }}
        </div>

        {{-- ▼ 最初は閉じる --}}
        <div id="folder-{{ $folder }}" class="folder-content">

            @foreach ($fileList as $file)

                <form action="{{ route('python.execute') }}" method="POST" class="runpy-item">
                    @csrf
                    <input type="hidden" name="file" value="{{ $file }}">
                    <button class="runpy-button">実行 / ログを見る：{{ basename($file) }}</button>
                </form>

            @endforeach

        </div>
    @endforeach

</div>


<script>
document.querySelectorAll('.toggle-folder').forEach(el => {
    el.addEventListener('click', () => {
        const area = document.getElementById('folder-' + el.dataset.folder);
        const isOpen = area.style.display === 'block';

        area.style.display = isOpen ? 'none' : 'block';
        el.textContent = (isOpen ? "▶ " : "▼ ") + el.dataset.folder;
    });
});
</script>

</x-app-layout>
