<x-app-layout>

    <link rel="stylesheet" href="{{ asset('css/runpy.css') }}">

    <div class="runpy-wrapper">

        <h1 class="runpy-header">Python 実行ツール</h1>

        {{-- 実行結果 --}}
        @if (session('output'))
            <div class="runpy-output">
                <strong>{{ session('selected_file') }}</strong><br><br>
                {{ session('output') }}
            </div>
        @endif


        {{-- ✅ フォルダごとにまとめて表示 --}}
        @php
            $folderGrouped = [];
            foreach ($files as $file) {
                $parts = explode('/', $file);
                $folder = $parts[0];
                $folderGrouped[$folder][] = $file;
            }
        @endphp

        <div class="runpy-list">
            @foreach ($folderGrouped as $folder => $fileList)

                {{-- ▼ フォルダ名クリックでトグル --}}
                <div class="toggle-folder" data-target="{{ $folder }}">
                    ▼ {{ $folder }}
                </div>

                <div id="folder-{{ $folder }}" class="folder-content">

                    @foreach ($fileList as $file)
                        <form action="{{ route('python.execute') }}" method="POST" class="runpy-item">
                            @csrf
                            <input type="hidden" name="file" value="{{ $file }}">
                            <button class="runpy-button">▶ 実行 : {{ $file }}</button>
                        </form>
                    @endforeach

                </div>

            @endforeach
        </div>

        <a href="javascript:history.back()" class="runpy-button">戻る</a>

    </div>

    {{-- ✅ トグル開閉用 JS --}}
    <script>
        document.querySelectorAll('.toggle-folder').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const target = document.getElementById('folder-' + toggle.dataset.target);
                target.style.display = target.style.display === 'none' ? 'block' : 'none';
            });
        });
    </script>

</x-app-layout>
