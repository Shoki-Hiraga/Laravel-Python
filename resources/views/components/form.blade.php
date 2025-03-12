<!DOCTYPE html>
<html lang="ja">
<head>
@include('components.noindex')
@include('components.header')
@include('components.link')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>車情報入力フォーム</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>車情報入力フォーム</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ url('/form') }}" method="post">
            @csrf

            <!-- メーカー/車種 -->
            <div class="mb-3">
                <label class="form-label">メーカー/車種</label>
                <select name="maker" class="form-select">
                    <option value="トヨタ/マークⅡ JZX100">トヨタ/マークⅡ JZX100</option>
                    <option value="日産/スカイライン">日産/スカイライン</option>
                </select>
            </div>

            <!-- 年式 -->
            <div class="mb-3">
                <label class="form-label">年式</label>
                <select name="year" class="form-select">
                    @for ($i = 1992; $i <= 2000; $i++)
                        <option value="{{ $i }}">{{ $i }}年</option>
                    @endfor
                </select>
            </div>

            <!-- 走行距離 -->
            <div class="mb-3">
                <label class="form-label">走行距離</label>
                <select name="mileage" class="form-select">
                    <option value="5,001〜10,000">5,001〜10,000</option>
                    <option value="10,001〜15,000">10,001〜15,000</option>
                    <option value="15,001〜20,000">15,001〜20,000</option>
                    <option value="20,001〜25,000">20,001〜25,000</option>
                    <option value="25,001〜30,000">25,001〜30,000</option>
                    <option value="30,001〜35,000">30,001〜35,000</option>
                    <option value="35,001〜40,000">35,001〜40,000</option>
                    <option value="40,001〜45,000">40,001〜45,000</option>
                    <option value="45,001〜50,000">45,001〜50,000</option>
                </select>
            </div>

            <!-- 検討中の売却先 -->
            <div class="mb-3">
                <label class="form-label">検討中の売却先</label>
                <select name="sell_target" class="form-select">
                    <option value="当社のみ">当社のみ</option>
                    <option value="当社以外も検討">当社以外も検討</option>
                </select>
            </div>

            <!-- ご売却時期 -->
            <div class="mb-3">
                <label class="form-label">ご売却時期</label>
                <select name="sell_period" class="form-select">
                    <option value="1ヶ月以内">1ヶ月以内</option>
                    <option value="2ヶ月以内">2ヶ月以内</option>
                </select>
            </div>

            <!-- お名前 -->
            <div class="mb-3">
                <label class="form-label">お名前</label>
                <input type="text" name="name" class="form-control">
            </div>

            <!-- 電話番号 -->
            <div class="mb-3">
                <label class="form-label">電話番号</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <!-- ご年代 -->
            <div class="mb-3">
                <label class="form-label">ご年代</label>
                <select name="age" class="form-select">
                    <option value="10代">10代</option>
                    <option value="20代">20代</option>
                    <option value="30代">30代</option>
                    <option value="40代">40代</option>
                </select>
            </div>

            <!-- お申込者 -->
            <div class="mb-3">
                <label class="form-label">お申込者</label>
                <select name="applicant" class="form-select">
                    <option value="ご本人">ご本人</option>
                    <option value="ご家族の代理">ご家族の代理</option>
                    <option value="友人の代理">友人の代理</option>
                </select>
            </div>

            <!-- 都道府県 -->
            <div class="mb-3">
                <label class="form-label">都道府県</label>
                <select name="prefecture" class="form-select">
                    <option value="東京都">東京都</option>
                    <option value="神奈川県">神奈川県</option>
                    <option value="千葉県">千葉県</option>
                    <option value="埼玉県">埼玉県</option>
                </select>
            </div>

            <!-- メールアドレス -->
            <div class="mb-3">
                <label class="form-label">メールアドレス</label>
                <input type="email" name="email" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">送信</button>
        </form>
    </div>
</body>
</html>
