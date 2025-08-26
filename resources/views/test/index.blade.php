<!DOCTYPE html>
<html lang="ja">
<head>
@include('components.noindex')
@include('components.header')
@include('components.link')

<title>{{ $python_title }}</title>
</head>
<body>
    <h1>bladeファイルからテキストベタ打ち </h1>
    <h2>以下はpyファイルから出力</h2>
    <p>{{ $python_title }}</p>
    <p>{{$python_h1}}</p>

<br>
<br>
    <h1>以下よりテスト検証用</h1>
    <a href="{{ route('form') }}">
    <h2>テスト入力フォームへ</h2>
    </a>   

    <h2>twitter埋め込みテスト</h2>
    <style>
        .twitter_container {
            display: flex;
            justify-content: center; /* 中央寄せ */
            gap: 10px; /* 要素間のスペース */
        }
        .twitter_embed {
            flex: 1; /* 均等に並べる */
            max-width: 50%; /* 幅を調整 */
        }
    </style>
    <div class="twitter_container">
        <div class="twitter_embed" data-gtm-click="twitter_card">
        <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">数日限定入庫車速報
                <br>マークII IR-V
                <br>GH-JZX110改
                <br>2003年
                <br>9.0万km
                <br>載せ替え5MT
                <br>修復歴なし
                <br>総額291.1万円(税込)
                <br>ユーザー様買取車⭐︎実走行8万km台⭐︎レザーシート⭐︎載せ替え5MT⭐︎社外エアロ(F・S・R)⭐︎社外AW⭐︎追加メーター⭐︎1JZ-GTE⭐︎前置きインタークーラー
                <a href="https://twitter.com/hashtag/%E8%BB%8A%E5%A3%B2%E3%82%8A%E3%81%BE%E3%81%99?src=hash&amp;ref_src=twsrc%5Etfw">#車売ります</a>
                <a href="https://t.co/XKfo7wuvh3">pic.twitter.com/XKfo7wuvh3</a>
            </p>&mdash; ガレージカレント直販センタ (@GC__direct) 
            <a href="https://twitter.com/GC__direct/status/1901540333869207966?ref_src=twsrc%5Etfw">March 17, 2025</a>
            </blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="twitter_embed" data-gtm-click="twitter_card">
        <blockquote class="twitter-tweet">
            <p lang="ja" dir="ltr">数日限定入庫車速報
                <br>チェイサーツアラーV
                <br>GF-JZX100
                <br>1998年
                <br>15.4万km
                <br>5MT
                <br>修復歴あり
                <br>総額283万円(税込)
                <br>ユーザー様買取車⭐︎5MT⭐︎1JZ-GTE⭐︎社外AW⭐︎社外マフラー⭐︎追加メーター⭐︎GReddyインタークーラー
                <a href="https://twitter.com/hashtag/%E8%BB%8A%E5%A3%B2%E3%82%8A%E3%81%BE%E3%81%99?src=hash&amp;ref_src=twsrc%5Etfw">#車売ります</a>
                <a href="https://t.co/IYeRUA9zNZ">pic.twitter.com/IYeRUA9zNZ</a>
            </p>&mdash; ガレージカレント直販センタ (@GC__direct) 
            <a href="https://twitter.com/GC__direct/status/1901486317676167644?ref_src=twsrc%5Etfw">March 17, 2025</a>
            </blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>   
        </div>
    </div>


        <h2>data-gtm-clickテスト</h2>
    <div class="btn_test">
        <button type="submit" class="btn-click-DataGTM" data-gtm-click="button-test-click">送信</button>
    </div>
        <h2>class=click-btnテスト</h2>
    <div class="btn_test">
        <button type="submit" class="click-btn">送信</button>
    </div>

    <h2>URL_click_テスト</h2>
    <div class="btn_test">
        <a href>https://332web.com/</a>
    </div>
        <h2>テストテキスト</h2>

<p>
R32型 スカイラインといえば、16年ぶりにGT-Rが復活したことで人気を博した日産が世界に誇るスポーツカーです。走行性能はもちろん、シャープでスタイリッシュなデザインに魅せられ、「いつかは所有したい」と憧れを抱いている方も多いでしょう。

しかし、30年以上前に発売された古いクルマで、なおかつハイパフォーマンスモデルであるだけに、気になるのは維持費です。そこで本記事では、R32型 スカイライン GT-Rを維持するのにかかる費用の内訳を解説いたします。

reasons_to_choose_qshaoh

contact_button

R32型 スカイライン GT-Rの維持費の内訳


R32型 スカイライン GT-Rの維持費について、燃料代、自動車税種別割、任意保険料、車検代、メンテナンス費用の5項目に分けて解説します。

燃料代
R32型 スカイライン GT-Rのカタログ燃費は年式によって異なり、7〜8.2km/Lです。今回は8.2km/Lで燃料代を算出します。

たとえば、毎週末2時間ほどドライブした場合、走行距離はおおよそ400km程度まで伸び、約48Lの燃料を使用します。ハイオクガソリン1Lあたり184円（※）だとすると、1ヶ月あたりの燃料代は8,832円で、1年間に換算すると10万5,984円かかります。

※2024年7月11日時点のハイオクガソリン1Lあたりの価格

自動車税
続いて、自動車税種別割について解説します。

自動車税種別割は年に1回納める税金で、クルマの排気量で税額が決まります。R32型 スカイライン GT-Rには、日産の名機である「RB26DETT型エンジン」が搭載されており、排気量は2,568ccです。2,500cc超〜3,000cc以下の区分に該当し、年間で5万1,000円支払うことになります。（2019年9月30日以前に新規登録した場合）

しかし、新規登録から13年以上経過していると税額が高くなります。R32型 スカイライン GT-Rの最終モデルが発売されたのは1994年です。どんなに年式が新しい個体でも車齢は13年を超えます。そのため、自動車税種別割は重課されて年間で5万8,600円かかります。

</p>

</body>
</html>
