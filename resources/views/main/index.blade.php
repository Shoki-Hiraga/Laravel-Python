<!DOCTYPE html>
<html lang="ja">
<head>
@include('components.noindex')
@include('components.header')
    <title>{{ $python_title }}</title>
</head>
<body>
    <h1>bladeファイルからテキストベタ打ち </h1>
    <h2>以下はpyファイルから出力</h2>
    <p>{{ $python_title }}</p>
    <p>{{$python_h1}}</p>
    @include('components.link')
</body>
</html>
