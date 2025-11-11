<x-app-layout>
<link rel="stylesheet" href="{{ asset('css/runpy.css') }}">
<div class="runpy-wrapper">

    <h2>{{ $relative }} のログ</h2>

    @if ($isRunning)
        <form action="{{ route('python.stop', $relative) }}" method="POST" style="display:inline;">
            @csrf
            <button class="runpy-button">停止</button>
        </form>
    @else
        <p>実行中ではありません。</p>
    @endif

    <a href="{{ route('python.runner') }}" class="runpy-button">戻る</a>

    <div id="log-area" class="runpy-output"><pre>{{ $log }}</pre></div>

</div>

<script>
    const area = document.getElementById('log-area');
    area.scrollTop = area.scrollHeight;
</script>

</x-app-layout>
