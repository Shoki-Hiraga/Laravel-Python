<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/runpy.css') }}">

<div class="runpy-wrapper">

    <h2>{{ $relative }} のログ</h2>

    @if ($isRunning)
        <form action="{{ route('python.stop', $relative) }}" method="POST" style="display:inline;">
            @csrf
            <button class="runpy-button" style="background:red;">停止</button>
        </form>
    @else
        <p>現在実行中ではありません。</p>
    @endif

    <a href="{{ route('python.runner') }}" class="runpy-button">戻る</a>

    <div id="log-container"
         style="background-color: #000; color: #0f0; font-family: monospace;
                padding: 15px; border-radius: 5px; white-space: pre-wrap;
                overflow-y: auto; height: 500px;">
        <pre id="log-content">{{ $log }}</pre>
    </div>
</div>

<script>
// ✅ 1秒おきにログ更新
setInterval(function () {
    fetch("{{ route('python.log', $relative) }}")
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");
            const newLog = doc.querySelector("#log-content").innerText;
            const current = document.querySelector("#log-content");

            if (current.innerText !== newLog) {
                current.innerText = newLog;
                document.querySelector("#log-container").scrollTop =
                    document.querySelector("#log-container").scrollHeight;
            }
        });
}, 1000);

// 初回だけ最下部へ
document.addEventListener("DOMContentLoaded", () => {
    const logContainer = document.getElementById('log-container');
    logContainer.scrollTop = logContainer.scrollHeight;
});
</script>
</x-app-layout>
