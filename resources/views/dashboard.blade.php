<x-app-layout>
    <div class="card">
        <h1>Dashboard</h1>
        <p>ログイン中ユーザー：{{ auth()->user()->name }}</p>
    </div>
</x-app-layout>
