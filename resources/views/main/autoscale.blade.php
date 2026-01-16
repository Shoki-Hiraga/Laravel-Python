<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webサイト構成のオートスケーリング図解</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background-color: #e9ecef;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            box-sizing: border-box;
        }
        .container {
            width: 100%;
            max-width: 1400px;
            background-color: #fff;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 20px;
        }
        svg {
            width: 100%;
            height: auto;
            display: block;
        }
        .description {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            line-height: 1.6;
        }
        .description h3 {
            margin-top: 0;
            color: #333;
        }
        .description ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .description li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
<div class="container">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1300 550">
  <rect x="0" y="0" width="1300" height="550" fill="#ffffff" opacity="0" />
  <text x="650" y="35" font-size="24" font-weight="bold" text-anchor="middle" fill="#333">旧車王 Webサイト構成のオートスケーリング図解</text>
  
  <!-- 通常時 -->
  <rect x="30" y="70" width="600" height="450" fill="#f8f9fa" rx="10" ry="10" stroke="#ced4da" stroke-width="2"/>
  <text x="330" y="105" font-size="18" font-weight="bold" text-anchor="middle" fill="#555">通常時（低負荷）</text>
  
  <!-- ピーク時 -->
  <rect x="670" y="70" width="600" height="450" fill="#fff4e6" rx="10" ry="10" stroke="#ffc078" stroke-width="2"/>
  <text x="970" y="105" font-size="18" font-weight="bold" text-anchor="middle" fill="#d9480f">ピーク時（高負荷）</text>
  
  <!-- 通常時の構成 -->
  <g transform="translate(80, 140)">
    <!-- Client -->
    <g transform="translate(0, 80)">
      <circle cx="30" cy="30" r="20" fill="#adb5bd"/>
      <text x="30" y="65" font-size="12" text-anchor="middle" fill="#333">Client</text>
    </g>
    <path d="M 60 110 L 100 110" stroke="#333" stroke-width="2" marker-end="url(#arrow-normal)"/>
    
    <!-- ALB -->
    <g transform="translate(105, 70)">
      <rect x="0" y="0" width="80" height="80" fill="#ff9900" rx="5" ry="5"/>
      <text x="40" y="45" font-size="14" font-weight="bold" text-anchor="middle" fill="white">ALB</text>
      <text x="40" y="100" font-size="11" text-anchor="middle" fill="#555">標準処理能力</text>
      <text x="40" y="115" font-size="10" text-anchor="middle" fill="#666">自動スケール</text>
    </g>
    <path d="M 195 110 L 235 110" stroke="#333" stroke-width="2" marker-end="url(#arrow-normal)"/>
    
    <!-- EC2 Auto Scaling Group -->
    <g transform="translate(240, 40)">
      <rect x="0" y="0" width="110" height="140" fill="none" stroke="#248814" stroke-width="2" stroke-dasharray="4 2" rx="5" ry="5"/>
      <text x="55" y="-10" font-size="11" text-anchor="middle" fill="#248814" font-weight="bold">Auto Scaling Group</text>
      <rect x="20" y="20" width="45" height="45" fill="#248814" rx="3" ry="3"/>
      <text x="42.5" y="46" font-size="11" text-anchor="middle" fill="white" font-weight="bold">EC2</text>
      <rect x="45" y="75" width="45" height="45" fill="#248814" rx="3" ry="3" opacity="0.3"/>
      <text x="67.5" y="101" font-size="11" text-anchor="middle" fill="white">EC2</text>
      <text x="55" y="160" font-size="10" text-anchor="middle" fill="#555">最小台数で稼働</text>
    </g>
    <path d="M 360 110 L 400 110" stroke="#333" stroke-width="2" marker-end="url(#arrow-normal)"/>
    
    <!-- Lambda -->
    <g transform="translate(405, 70)">
      <rect x="0" y="0" width="60" height="80" fill="#ff9900" rx="5" ry="5"/>
      <text x="30" y="45" font-size="12" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      <text x="30" y="100" font-size="10" text-anchor="middle" fill="#555">少数の実行</text>
      <text x="30" y="115" font-size="10" text-anchor="middle" fill="#666">自動スケール</text>
    </g>
    <path d="M 475 110 L 515 110" stroke="#333" stroke-width="2" marker-end="url(#arrow-normal)"/>
    
    <!-- Aurora Serverless v2 -->
    <g transform="translate(520, 50)">
      <path d="M 0 20 C 0 5 60 5 60 20 L 60 90 C 60 105 0 105 0 90 Z" fill="#3B48CC"/>
      <ellipse cx="30" cy="20" rx="30" ry="7" fill="#6A75E6"/>
      <text x="30" y="60" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Aurora</text>
      <text x="30" y="73" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Serverless v2</text>
      
      <!-- ACUメーター -->
      <!-- <rect x="70" y="15" width="15" height="80" fill="#e9ecef" stroke="#ced4da"/>
      <rect x="70" y="65" width="15" height="30" fill="#248814"/>
      <text x="100" y="55" font-size="10" fill="#555" font-weight="bold">低ACU</text>
      <text x="100" y="120" font-size="10" text-anchor="start" fill="#666">自動スケール</text> -->
    </g>
  </g>
  
  <!-- ピーク時の構成 -->
  <g transform="translate(720, 140)">
    <!-- Multiple Clients -->
    <g transform="translate(0, 60)">
      <circle cx="25" cy="15" r="15" fill="#adb5bd"/>
      <circle cx="25" cy="45" r="15" fill="#adb5bd"/>
      <circle cx="25" cy="75" r="15" fill="#adb5bd"/>
      <circle cx="25" cy="105" r="15" fill="#adb5bd"/>
      <text x="25" y="140" font-size="12" text-anchor="middle" fill="#333" font-weight="bold">多数のClients</text>
    </g>
    <path d="M 50 75 L 90 85" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 50 90 L 90 95" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 50 105 L 90 105" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 50 120 L 90 115" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    
    <!-- ALB (拡張) -->
    <g transform="translate(95, 60)">
      <rect x="0" y="0" width="90" height="90" fill="#ff9900" rx="5" ry="5" stroke="#d9480f" stroke-width="3"/>
      <text x="45" y="50" font-size="14" font-weight="bold" text-anchor="middle" fill="white">ALB</text>
      <path d="M 15 25 L 75 25" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <path d="M 15 40 L 75 40" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <path d="M 15 55 L 75 55" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <path d="M 15 70 L 75 70" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <text x="45" y="110" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">内部キャパシティ</text>
      <text x="45" y="123" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">自動拡張</text>
    </g>
    <path d="M 190 90 L 230 90" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 190 105 L 230 105" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 190 120 L 230 120" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    
    <!-- EC2 Auto Scaling Group (拡張) -->
    <g transform="translate(235, 25)">
      <rect x="0" y="0" width="120" height="175" fill="none" stroke="#248814" stroke-width="3" stroke-dasharray="4 2" rx="5" ry="5"/>
      <text x="60" y="-10" font-size="11" text-anchor="middle" fill="#248814" font-weight="bold">Auto Scaling Group</text>
      
      <rect x="10" y="10" width="45" height="45" fill="#248814" rx="3" ry="3"/>
      <text x="32.5" y="36" font-size="11" text-anchor="middle" fill="white" font-weight="bold">EC2</text>
      
      <rect x="65" y="10" width="45" height="45" fill="#248814" rx="3" ry="3"/>
      <text x="87.5" y="36" font-size="11" text-anchor="middle" fill="white" font-weight="bold">EC2</text>
      
      <rect x="10" y="65" width="45" height="45" fill="#248814" rx="3" ry="3"/>
      <text x="32.5" y="91" font-size="11" text-anchor="middle" fill="white" font-weight="bold">EC2</text>
      
      <rect x="65" y="65" width="45" height="45" fill="#248814" rx="3" ry="3"/>
      <text x="87.5" y="91" font-size="11" text-anchor="middle" fill="white" font-weight="bold">EC2</text>
      
      <rect x="37.5" y="120" width="45" height="45" fill="#248814" rx="3" ry="3"/>
      <text x="60" y="146" font-size="11" text-anchor="middle" fill="white" font-weight="bold">EC2</text>
      
      <text x="60" y="193" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">スケールアウト</text>
      <text x="60" y="206" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">(台数増加)</text>
    </g>
    <path d="M 360 90 L 400 90" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 360 105 L 400 105" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 360 120 L 400 120" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    
    <!-- Lambda (多数実行) -->
    <g transform="translate(405, 40)">
      <rect x="0" y="10" width="50" height="40" fill="#ff9900" rx="5" ry="5"/>
      <text x="25" y="34" font-size="10" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <rect x="0" y="55" width="50" height="40" fill="#ff9900" rx="5" ry="5"/>
      <text x="25" y="79" font-size="10" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <rect x="0" y="100" width="50" height="40" fill="#ff9900" rx="5" ry="5"/>
      <text x="25" y="124" font-size="10" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <rect x="0" y="145" width="50" height="40" fill="#ff9900" rx="5" ry="5"/>
      <text x="25" y="169" font-size="10" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <text x="25" y="200" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">同時実行数</text>
      <text x="25" y="213" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">自動増加</text>
    </g>
    <path d="M 460 90 L 495 90" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 460 105 L 495 105" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 460 120 L 495 120" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    
    <!-- Aurora Serverless v2 (高ACU) -->
    <g transform="translate(500, 35)">
      <path d="M 0 25 C 0 5 70 5 70 25 L 70 110 C 70 130 0 130 0 110 Z" fill="#3B48CC" stroke="#d9480f" stroke-width="3"/>
      <ellipse cx="35" cy="25" rx="35" ry="9" fill="#6A75E6"/>
      <text x="35" y="72" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Aurora</text>
      <text x="35" y="87" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Serverless v2</text>
      
      <!-- ACUメーター(高負荷) -->
      <!-- <rect x="80" y="15" width="18" height="105" fill="#e9ecef" stroke="#ced4da"/>
      <rect x="80" y="15" width="18" height="105" fill="#d9480f"/>
      <text x="115" y="60" font-size="10" fill="#d9480f" font-weight="bold">高ACU</text>
      <text x="115" y="75" font-size="9" fill="#d9480f" font-weight="bold">スケールアップ</text>
      <text x="115" y="145" font-size="10" text-anchor="start" fill="#666">自動スケール</text> -->
    </g>
  </g>
  
  <defs>
    <marker id="arrow-normal" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
      <path d="M0,0 L0,6 L9,3 z" fill="#333" />
    </marker>
    <marker id="arrow-peak" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
      <path d="M0,0 L0,6 L9,3 z" fill="#d9480f" />
    </marker>
    <marker id="arrow-white" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
      <path d="M0,0 L0,6 L9,3 z" fill="white" />
    </marker>
  </defs>
</svg>

<div class="description">
  <h3>🔄 各コンポーネントのオートスケーリング特性</h3>
  <ul>
    <li><strong>ALB（Application Load Balancer）</strong>：内部キャパシティが自動的に拡張されます。ユーザーによる設定は不要で、AWSが自動的に負荷に応じて処理能力を増強します。</li>
    <li><strong>EC2（Auto Scaling Group）</strong>：CloudWatchのメトリクス（CPU使用率、リクエスト数など）に基づいて、EC2インスタンスの台数を自動的に増減します。最小・最大台数を設定できます。</li>
    <li><strong>Lambda</strong>：リクエストに応じて自動的に実行環境がスケールします。同時実行数の上限設定が可能で、デフォルトは1,000です（リージョンごと）。</li>
    <li><strong>Aurora Serverless v2</strong>：ACU（Aurora Capacity Units）という単位でスケールします。データベースの負荷に応じて、CPU・メモリが自動的に増減します。最小・最大ACUを設定できます。</li>
  </ul>
  <p><strong>ポイント</strong>：ご理解の通り、この構成では各レイヤーで独立してオートスケールが機能します。ALBは自動、EC2は台数でスケールアウト、Lambdaは同時実行数、Aurora Serverless v2はACU（処理能力）でスケールアップという形で、それぞれ異なる方式でスケーリングします。</p>
</div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            background-color: #e9ecef;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            box-sizing: border-box;
        }
        .container {
            width: 100%;
            max-width: 1400px;
            background-color: #fff;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 20px;
        }
        svg {
            width: 100%;
            height: auto;
            display: block;
        }
        .description {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            line-height: 1.6;
        }
        .description h3 {
            margin-top: 0;
            color: #333;
        }
        .description ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .description li {
            margin: 8px 0;
        }
    </style>
</head>
<body>
<div class="container">
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1300 550">
  <rect x="0" y="0" width="1300" height="550" fill="#ffffff" opacity="0" />
  <text x="650" y="35" font-size="24" font-weight="bold" text-anchor="middle" fill="#333">外車王 Webサイト構成のオートスケーリング図解</text>
  
  <!-- 通常時 -->
  <rect x="30" y="70" width="600" height="450" fill="#f8f9fa" rx="10" ry="10" stroke="#ced4da" stroke-width="2"/>
  <text x="330" y="105" font-size="18" font-weight="bold" text-anchor="middle" fill="#555">通常時（低負荷）</text>
  
  <!-- ピーク時 -->
  <rect x="670" y="70" width="600" height="450" fill="#fff4e6" rx="10" ry="10" stroke="#ffc078" stroke-width="2"/>
  <text x="970" y="105" font-size="18" font-weight="bold" text-anchor="middle" fill="#d9480f">ピーク時（高負荷）</text>
  
  <!-- 通常時の構成 -->
  <g transform="translate(100, 160)">
    <!-- Client -->
    <g transform="translate(0, 60)">
      <circle cx="30" cy="30" r="20" fill="#adb5bd"/>
      <text x="30" y="65" font-size="12" text-anchor="middle" fill="#333">Client</text>
    </g>
    <path d="M 60 90 L 110 90" stroke="#333" stroke-width="2" marker-end="url(#arrow-normal)"/>
    
    <!-- API Gateway -->
    <g transform="translate(115, 45)">
      <rect x="0" y="0" width="100" height="90" fill="#8C4FFF" rx="5" ry="5"/>
      <text x="50" y="40" font-size="13" font-weight="bold" text-anchor="middle" fill="white">API</text>
      <text x="50" y="57" font-size="13" font-weight="bold" text-anchor="middle" fill="white">Gateway</text>
      <text x="50" y="110" font-size="11" text-anchor="middle" fill="#555">標準スループット</text>
      <text x="50" y="125" font-size="10" text-anchor="middle" fill="#666">自動スケール</text>
    </g>
    <path d="M 225 90 L 275 90" stroke="#333" stroke-width="2" marker-end="url(#arrow-normal)"/>
    
    <!-- Lambda -->
    <g transform="translate(280, 50)">
      <rect x="0" y="0" width="80" height="80" fill="#ff9900" rx="5" ry="5"/>
      <text x="40" y="45" font-size="13" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      <text x="40" y="100" font-size="10" text-anchor="middle" fill="#555">少数の実行</text>
      <text x="40" y="115" font-size="10" text-anchor="middle" fill="#666">自動スケール</text>
    </g>
    <path d="M 370 90 L 420 90" stroke="#333" stroke-width="2" marker-end="url(#arrow-normal)"/>
    
    <!-- Aurora Serverless v2 -->
    <g transform="translate(425, 30)">
      <path d="M 0 20 C 0 5 80 5 80 20 L 80 100 C 80 115 0 115 0 100 Z" fill="#3B48CC"/>
      <ellipse cx="40" cy="20" rx="40" ry="8" fill="#6A75E6"/>
      <text x="40" y="65" font-size="12" font-weight="bold" text-anchor="middle" fill="white">Aurora</text>
      <text x="40" y="80" font-size="12" font-weight="bold" text-anchor="middle" fill="white">Serverless v2</text>
      
      <!-- ACUメーター -->
      <!-- <rect x="90" y="15" width="18" height="90" fill="#e9ecef" stroke="#ced4da"/>
      <rect x="90" y="70" width="18" height="35" fill="#248814"/>
      <text x="125" y="60" font-size="10" fill="#555" font-weight="bold">低ACU</text>
      <text x="125" y="130" font-size="10" text-anchor="start" fill="#666">自動スケール</text> -->
    </g>
  </g>
  
  <!-- ピーク時の構成 -->
  <g transform="translate(720, 160)">
    <!-- Multiple Clients -->
    <g transform="translate(0, 40)">
      <circle cx="25" cy="15" r="15" fill="#adb5bd"/>
      <circle cx="25" cy="45" r="15" fill="#adb5bd"/>
      <circle cx="25" cy="75" r="15" fill="#adb5bd"/>
      <circle cx="25" cy="105" r="15" fill="#adb5bd"/>
      <text x="25" y="140" font-size="12" text-anchor="middle" fill="#333" font-weight="bold">多数のClients</text>
    </g>
    <path d="M 50 55 L 95 65" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 50 70 L 95 75" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 50 90 L 95 90" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 50 120 L 95 110" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    
    <!-- API Gateway (拡張) -->
    <g transform="translate(100, 30)">
      <rect x="0" y="0" width="110" height="110" fill="#8C4FFF" rx="5" ry="5" stroke="#d9480f" stroke-width="3"/>
      <text x="55" y="48" font-size="13" font-weight="bold" text-anchor="middle" fill="white">API</text>
      <text x="55" y="65" font-size="13" font-weight="bold" text-anchor="middle" fill="white">Gateway</text>
      <path d="M 15 25 L 95 25" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <path d="M 15 40 L 95 40" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <path d="M 15 70 L 95 70" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <path d="M 15 85 L 95 85" stroke="white" stroke-width="2" marker-end="url(#arrow-white)"/>
      <text x="55" y="130" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">スループット</text>
      <text x="55" y="143" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">自動拡張</text>
    </g>
    <path d="M 215 70 L 265 70" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 215 85 L 265 85" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 215 100 L 265 100" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    
    <!-- Lambda (多数実行) -->
    <g transform="translate(270, 20)">
      <rect x="0" y="10" width="60" height="45" fill="#ff9900" rx="5" ry="5"/>
      <text x="30" y="37" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <rect x="0" y="60" width="60" height="45" fill="#ff9900" rx="5" ry="5"/>
      <text x="30" y="87" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <rect x="0" y="110" width="60" height="45" fill="#ff9900" rx="5" ry="5"/>
      <text x="30" y="137" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <rect x="0" y="160" width="60" height="45" fill="#ff9900" rx="5" ry="5"/>
      <text x="30" y="187" font-size="11" font-weight="bold" text-anchor="middle" fill="white">Lambda</text>
      
      <text x="30" y="220" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">同時実行数</text>
      <text x="30" y="233" font-size="10" text-anchor="middle" fill="#d9480f" font-weight="bold">自動増加</text>
    </g>
    <path d="M 335 70 L 380 70" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 335 85 L 380 85" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    <path d="M 335 100 L 380 100" stroke="#d9480f" stroke-width="3" marker-end="url(#arrow-peak)"/>
    
    <!-- Aurora Serverless v2 (高ACU) -->
    <g transform="translate(385, 15)">
      <path d="M 0 25 C 0 5 90 5 90 25 L 90 120 C 90 140 0 140 0 120 Z" fill="#3B48CC" stroke="#d9480f" stroke-width="3"/>
      <ellipse cx="45" cy="25" rx="45" ry="10" fill="#6A75E6"/>
      <text x="45" y="77" font-size="12" font-weight="bold" text-anchor="middle" fill="white">Aurora</text>
      <text x="45" y="93" font-size="12" font-weight="bold" text-anchor="middle" fill="white">Serverless v2</text>
      
      <!-- ACUメーター(高負荷) -->
      <!-- <rect x="100" y="15" width="20" height="115" fill="#e9ecef" stroke="#ced4da"/>
      <rect x="100" y="15" width="20" height="115" fill="#d9480f"/>
      <text x="140" y="65" font-size="10" fill="#d9480f" font-weight="bold">高ACU</text>
      <text x="140" y="80" font-size="9" fill="#d9480f" font-weight="bold">スケールアップ</text>
      <text x="140" y="155" font-size="10" text-anchor="start" fill="#666">自動スケール</text> -->
    </g>
  </g>
  
  <defs>
    <marker id="arrow-normal" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
      <path d="M0,0 L0,6 L9,3 z" fill="#333" />
    </marker>
    <marker id="arrow-peak" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
      <path d="M0,0 L0,6 L9,3 z" fill="#d9480f" />
    </marker>
    <marker id="arrow-white" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto" markerUnits="strokeWidth">
      <path d="M0,0 L0,6 L9,3 z" fill="white" />
    </marker>
  </defs>
</svg>

<div class="description">
  <h3>🔄 各コンポーネントのオートスケーリング特性</h3>
  <ul>
    <li><strong>API Gateway</strong>：リクエストスループットが自動的に拡張されます。ユーザーによる設定は不要で、AWSが自動的に負荷に応じて処理能力を増強します。デフォルトで10,000リクエスト/秒まで対応し、それ以上も自動スケールします。</li>
    <li><strong>Lambda</strong>：リクエストに応じて自動的に実行環境がスケールします。同時実行数の上限設定が可能で、デフォルトは1,000です（リージョンごと）。コールドスタート対策として予約済み同時実行数（Provisioned Concurrency）も設定可能です。</li>
    <li><strong>Aurora Serverless v2</strong>：ACU（Aurora Capacity Units）という単位でスケールします。データベースの負荷に応じて、CPU・メモリが自動的に増減します。最小・最大ACUを設定できます。</li>
  </ul>
  <p><strong>ポイント</strong>：この構成は完全サーバーレスアーキテクチャで、すべてのコンポーネントが自動スケールします。API Gatewayはスループットで、Lambdaは同時実行数で、Aurora Serverless v2はACU（処理能力）でスケールする形で、EC2のようなインスタンス管理が不要です。運用負荷が低く、使った分だけ課金される特徴があります。</p>
  
  <h3>💡 EC2+ALB構成との違い</h3>
  <ul>
    <li><strong>管理性</strong>：EC2は台数管理が必要ですが、API Gateway+Lambda構成は完全マネージドで管理不要です。</li>
    <li><strong>スケーリング速度</strong>：Lambdaはミリ秒単位でスケール可能。EC2は数分かかる場合があります。</li>
    <li><strong>コスト</strong>：API Gateway+Lambdaは使った分だけ課金。EC2は起動している間は常に課金されます。</li>
    <li><strong>適用場面</strong>：API Gateway構成は短時間処理やバースト的な負荷に最適。EC2構成は長時間処理や常時稼働が必要な場合に適しています。</li>
  </ul>
</div>
</div>
</body>
</html>