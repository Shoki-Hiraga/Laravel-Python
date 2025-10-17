<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Amazon_Web_Services_Logo.svg/512px-Amazon_Web_Services_Logo.svg.png">

    <title>AWSインフラコスト最適化レポート</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Hiragino Sans', 'Yu Gothic', sans-serif;
            line-height: 1.8;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }

        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            text-align: center;
        }

        header h1 {
            font-size: 2.5em;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        header p {
            font-size: 1.2em;
            opacity: 0.95;
        }

        nav {
            background: #f8f9fa;
            padding: 20px 40px;
            border-bottom: 3px solid #667eea;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        nav button {
            background: white;
            border: 2px solid #667eea;
            color: #667eea;
            padding: 12px 24px;
            margin: 5px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 0.95em;
            font-weight: 600;
            transition: all 0.3s;
        }

        nav button:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102,126,234,0.3);
        }

        nav button.active {
            background: #667eea;
            color: white;
        }

        main {
            padding: 40px;
        }

        section {
            display: none;
            animation: fadeIn 0.5s;
        }

        section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }

        h3 {
            color: #764ba2;
            font-size: 1.5em;
            margin: 30px 0 15px;
        }

        .highlight-box {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-left: 5px solid #667eea;
            padding: 25px;
            margin: 25px 0;
            border-radius: 10px;
        }

        .cost-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .cost-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 24px rgba(102,126,234,0.2);
        }

        .cost-amount {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }

        .cost-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin: 25px 0;
        }

        .comparison-table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .comparison-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px;
            text-align: left;
            font-weight: 600;
        }

        .comparison-table td {
            padding: 15px 18px;
            border-bottom: 1px solid #e0e0e0;
        }

        .comparison-table tr:hover {
            background: #f8f9fa;
        }

        .star-rating {
            color: #ffc107;
            font-size: 1.3em;
        }

        .recommendation {
            background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin: 25px 0;
            box-shadow: 0 6px 18px rgba(76,175,80,0.3);
        }

        .recommendation h3 {
            color: white;
            margin-top: 0;
        }

        .warning {
            background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin: 25px 0;
            box-shadow: 0 6px 18px rgba(255,152,0,0.3);
        }

        .warning h3 {
            color: white;
            margin-top: 0;
        }

        .service-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .service-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #667eea;
            transition: all 0.3s;
        }

        .service-item:hover {
            background: #667eea15;
            transform: translateX(5px);
        }

        .chart-container {
            margin: 30px 0;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 15px;
        }

        .bar-chart {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .bar-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .bar-label {
            min-width: 150px;
            font-weight: 600;
        }

        .bar-visual {
            flex: 1;
            height: 35px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            padding: 0 15px;
            color: white;
            font-weight: 600;
            transition: all 0.3s;
        }

        .bar-visual:hover {
            transform: scaleX(1.02);
            box-shadow: 0 4px 12px rgba(102,126,234,0.4);
        }

        .roadmap {
            display: flex;
            flex-direction: column;
            gap: 25px;
            margin: 30px 0;
        }

        .phase {
            background: white;
            border: 2px solid #667eea;
            border-radius: 15px;
            padding: 25px;
            position: relative;
            transition: all 0.3s;
        }

        .phase:hover {
            box-shadow: 0 8px 24px rgba(102,126,234,0.2);
            transform: translateY(-3px);
        }

        .phase-number {
            position: absolute;
            top: -15px;
            left: 25px;
            background: #667eea;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2em;
        }

        .phase h4 {
            color: #667eea;
            margin-bottom: 15px;
            padding-top: 10px;
        }

        ul {
            margin: 15px 0;
            padding-left: 25px;
        }

        li {
            margin: 10px 0;
        }

        footer {
            background: #2c3e50;
            color: white;
            padding: 30px 40px;
            text-align: center;
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 1.8em;
            }

            main {
                padding: 20px;
            }

            nav button {
                width: 100%;
                margin: 5px 0;
            }

            .cost-grid {
                grid-template-columns: 1fr;
            }

            .comparison-table {
                font-size: 0.9em;
            }
        }
    </style>
        <nav>
            <button onclick="showSection('summary')" class="active">📊 エグゼクティブサマリー</button>
            <button onclick="showSection('current')">🔍 現状分析</button>
            <button onclick="showSection('aws-optimize')">💡 AWS最適化</button>
            <button onclick="showSection('cloud-migration')">☁️ 他クラウド移行</button>
            <button onclick="showSection('domestic')">🏠 国内サーバー</button>
            <button onclick="showSection('recommendation')">⭐ 推奨事項</button>
        </nav>
</head>
<body>
    <div class="container">
        <header>
            <h1>🚀 AWSインフラコスト最適化レポート</h1>
        </header>

        <main>
            <!-- エグゼクティブサマリー -->
            <section id="summary" class="active">
                <h2>📊 エグゼクティブサマリー</h2>
                
                <div class="highlight-box">
                    <h3>🎯 レポートの目的</h3>
                    <p>AWSインフラにおける高額な運用コストの根本原因を分析し、具体的なコスト削減戦略を提示します。</p>
                </div>

                <h3>🔥 最重要発見</h3>
                <div class="cost-card">
                    <strong>最大のコスト要因</strong>
                    <div class="cost-amount">RDS Aurora Serverless v2</div>
                    <p>現在の稼働状況に対してオーバースペックで、コスト効率が著しく低い状態です。</p>
                </div>

                <h3>💰 コスト削減における3つの戦略</h3>
                
                <div class="cost-grid">
                    <div class="cost-card">
                        <h4>1️⃣ AWS内最適化 ⭐推奨</h4>
                        <p><strong>コスト削減:</strong> 40%～60%</p>
                        <p><strong>実装リスク:</strong> 低</p>
                        <p><strong>期間:</strong> 短期</p>
                        <p>データベースをプロビジョニング済みインスタンスへ移行し、RDS費用を50%以上削減</p>
                        <p>プロビジョニング済みとはCPUとメモリを固定で契約すること</p>

                    </div>

                    <div class="cost-card">
                        <h4>2️⃣ GCP・Azure移行</h4>
                        <p><strong>コスト削減:</strong> 中～高</p>
                        <p><strong>移行リスク:</strong> 高</p>
                        <p><strong>期間:</strong> 長期（12-18ヶ月）</p>
                        <p>技術的に実現可能だが、大規模な移行プロジェクトが必要</p>
                    </div>

                    <div class="cost-card">
                        <h4>3️⃣ 国内サーバー移行</h4>
                        <p><strong>コスト:</strong> 表面上は最安</p>
                        <p><strong>移行リスク:</strong> 極めて高</p>
                        <p><strong>運用負荷:</strong> 極大</p>
                        <p>隠れた運用コストが月額料金の安さを上回る可能性大</p>
                    </div>
                </div>

                <div class="recommendation">
                    <h3>✅ 最優先推奨事項</h3>
                    <p><strong>現行AWSインフラストラクチャのコスト最適化を直ちに実行</strong></p>
                    <p>最小限のリスクと労力で最大の経済的利益を迅速に享受できます。コスト削減を実現した上で、長期的な事業戦略に基づきGCPへの移行を次なる選択肢として検討することを推奨します。</p>
                </div>
            </section>

            <!-- 現状分析 -->
            <section id="current">
                <h2>🔍 現行インフラストラクチャとコスト分析</h2>

                <h3>📐 アーキテクチャの構成</h3>
                <p>現システムは35以上のAWSサービスを利用した、成熟したクラウドネイティブアーキテクチャを採用しています。</p>

                <div class="service-list">
                    <div class="service-item"><strong>コンピュート層</strong><br>EC2, Lambda, ECS</div>
                    <div class="service-item"><strong>データベース層</strong><br>RDS, DynamoDB</div>
                    <div class="service-item"><strong>ネットワーク層</strong><br>CloudFront, VPC, Route 53</div>
                    <div class="service-item"><strong>ストレージ層</strong><br>S3, EFS, Backup</div>
                    <div class="service-item"><strong>セキュリティ層</strong><br>WAF, GuardDuty, KMS</div>
                    <div class="service-item"><strong>メッセージング層</strong><br>SQS, SNS, SES</div>
                    <div class="service-item"><strong>監視層</strong><br>CloudWatch, X-Ray</div>
                    <div class="service-item"><strong>データ処理層</strong><br>Glue, Athena</div>
                </div>

                <div class="highlight-box">
                    <strong>💡 重要な洞察</strong>
                    <p>この複雑な構成は、単純な「サーバー移管」が非現実的であることを示しています。各サービスの機能を代替または再構築する必要があり、単一のVPSでは実現不可能です。</p>
                </div>

                <h3>💸 主要コスト要因（6ヶ月間）</h3>

                <div class="chart-container">
                    <div class="bar-chart">
                        <div class="bar-item">
                            <div class="bar-label">RDS</div>
                            <div class="bar-visual" style="width: 100%;">¥786,339</div>
                        </div>
                        <div class="bar-item">
                            <div class="bar-label">CloudFront</div>
                            <div class="bar-visual" style="width: 53%;">¥416,883</div>
                        </div>
                        <div class="bar-item">
                            <div class="bar-label">Lambda</div>
                            <div class="bar-visual" style="width: 17.5%;">¥137,649</div>
                        </div>
                    </div>
                </div>

                <h3>🔴 RDS Aurora Serverless v2の問題点</h3>
                <div class="warning">
                    <h3>警告：コスト効率の低下</h3>
                    <p><strong>利用状況:</strong></p>
                    <ul>
                        <li>gai-production: 平均2.84 ACU / 最大3.28 ACU</li>
                        <li>qsh-production: 平均0.57 ACU / 最大0.63 ACU</li>
                        <li>marketprice-production: 平均0.54 ACU / 最大0.58 ACU</li>
                    </ul>
                    <p><strong>問題:</strong> 平均と最大ACUの差が非常に小さく、自動でサーバーがスケールする「可能性」に対して高額な料金を支払っている状態です。予測可能で安定したワークロードには、プロビジョニング済みインスタンスの方がコスト効率が高くなります。</p>
                    <p>※プロビジョニング済み とは サーバースペックを指定すること</p>
                </div>

                <h3>📈 Lambda の利用状況</h3>
                <div class="cost-card">
                    <p><strong>1日の平均実行回数:</strong> 162,445回（月間約490万回）</p>
                    <p><strong>平均実行時間:</strong> 742ミリ秒</p>
                    <p>AWS Lambdaの無料利用枠（月間100万リクエスト）を大幅に超えており、主に大量のリクエスト数によってコストが発生しています。</p>
                </div>
            </section>

            <!-- AWS最適化 -->
            <section id="aws-optimize">
                <h2>💡 AWS最適化戦略</h2>

                <div class="highlight-box">
                    <h3>🎯 最適化の核心</h3>
                    <p>全面的なプラットフォーム移行は多大な労力とリスクを伴います。最大のコスト削減は、既存環境内の非効率な部分を特定し修正することで達成されます。</p>
                </div>

                <h3>🔄 データベースの再プラットフォーム化</h3>
                
                <div class="cost-card">
                    <h4>推奨インスタンスタイプ</h4>
                        <ul>
                            <li>
                            月額合計約 - ¥52,800
                            </li>
                                <ul>
                                    <li><strong>gai-production-mysql8:</strong> db.r6g.large (16 GB RAM) - 月額約¥30,000</li>
                                    <li><strong>qsh-production:</strong> db.t3.medium (4 GB RAM) - 月額約¥11,400</li>
                                    <li><strong>marketprice-production:</strong> db.t3.medium (4 GB RAM) - 月額約¥11,400</li>
                                </ul>
                        </ul>

                        <h3>💰 コスト比較（東京リージョン）</h3>
                        <table class="comparison-table">
                            <tr>
                                <th>項目</th>
                                <th>現状（Aurora Serverless v2）</th>
                                <th>移行後（プロビジョニング済み）</th>
                                <th>削減率</th>
                            </tr>
                            <tr>
                                <td>月額料金</td>
                                <td>約¥131,057</td>
                                <td>約¥52,800～</td>
                                <td><strong style="color: #4caf50;">50%以上削減</strong></td>
                            </tr>
                        </table>
                    </div>

                <div class="recommendation">
                    <h3>✨ Gravitonプロセッサの活用</h3>
                    <p>r6gやt4gといったARMベースのGravitonプロセッサ搭載インスタンスは、従来のx86ベースと比較して優れた価格性能比を提供します。</p>
                </div>

                <h3>⚡ Lambda最適化施策</h3>
                <div class="cost-grid">
                    <div class="cost-card">
                        <h4>メモリの適正化</h4>
                        <p>AWS Lambda Power Tuningで最適なメモリサイズを発見し、実行時間を短縮してGB秒単位の課金を削減</p>
                    </div>
                    <div class="cost-card">
                        <h4>ARM/Graviton2移行</h4>
                        <p>ARMアーキテクチャで実行することで最大20%のコストパフォーマンス向上</p>
                    </div>
                    <div class="cost-card">
                        <h4>バッチ処理の実装</h4>
                        <p>一度の呼び出しで複数メッセージを処理し、課金対象の呼び出し回数を劇的に削減</p>
                    </div>
                </div>

                <h3>🌐 CloudFront最適化または移管</h3>
                <div class="cost-card">
                    <h4>Cloudflareへの移管</h4>
                    <p>CloudfrontをCloudflareに置き換えた場合、Cloudflareの 3万円/月 で済むため約50%のコストカット</p>                

                    <h4>CloudFront Price Classの見直し</h4>
                    <p>ユーザーの地理的分布を分析し、配信地域を限定する「Price Class 200」や「Price Class 100」に変更することで、高価なエッジロケーションの利用を避けてコスト削減</p>
                    
                    <h4>CloudFront キャッシュ戦略の強化</h4>
                    <p>Cache-Controlヘッダーを最適化し、静的アセットのキャッシュヒット率を向上させてオリジンへのリクエストを削減</p>

                <h3>💰 コスト比較</h3>                
                <table class="comparison-table">
                    <tr>
                        <th>項目</th>
                        <th>現状（Cloudfront）</th>
                        <th>移行後（Cloudflare）</th>
                        <th>削減率</th>
                    </tr>
                    <tr>
                        <td>月額料金</td>
                        <td>約¥69,481</td>
                        <td>約¥30,000～</td>
                        <td><strong style="color: #4caf50;">50%以上削減</strong></td>
                    </tr>
                </table>

                </div>

                <h3>🗓️ 実施ロードマップ</h3>
                <div class="roadmap">
                    <div class="phase">
                        <div class="phase-number">1</div>
                        <h4>フェーズ1: 低労力・高インパクト</h4>
                        <ul>
                            <li>RDSをプロビジョニング済みインスタンスへ移行</li>
                            <li>EC2/ECSのベースライン使用量にSavings Plansを適用</li>
                        </ul>
                    </div>

                    <div class="phase">
                        <div class="phase-number">2</div>
                        <h4>フェーズ2: 中労力</h4>
                        <ul>
                            <li>CloudFrontのPrice Classを最適化またはCloudflareへの置き換え</li>
                            <li>Lambda関数のメモリ使用量を分析し適正化</li>
                        </ul>
                    </div>

                    <div class="phase">
                        <div class="phase-number">3</div>
                        <h4>フェーズ3: 継続的取り組み</h4>
                        <ul>
                            <li>Lambda関数をARM/Graviton2アーキテクチャへ移行</li>
                            <li>Lambdaのバッチ処理を実装</li>
                            <li>キャッシュ戦略の継続的改善</li>
                        </ul>
                    </div>
                </div>

                <div class="recommendation">
                    <h3>📊 予測される財務的影響</h3>
                    <p><strong>AWS全体の請求額を40%～60%削減可能</strong></p>
                    <p>その大部分はRDSの移行によるものです。このアプローチは、大規模な移行プロジェクトに伴うリスクや混乱を避けつつ、迅速かつ確実にコスト削減を達成します。</p>
                </div>
            </section>

            <!-- 他クラウド移行 -->
            <section id="cloud-migration">
                <h2>☁️ 主要クラウド競合への移行分析</h2>

                <div class="highlight-box">
                    <strong>⚠️ 重要な前提</strong>
                    <p>これは単なる「サーバーの引っ越し」ではなく、大規模な再構築プロジェクトです。12～18ヶ月スパンの戦略的プロジェクトとして位置づける必要があります。</p>
                </div>

                <h3>🗺️ サービスマッピング例</h3>
                <table class="comparison-table">
                    <tr>
                        <th>AWSサービス</th>
                        <th>GCP同等サービス</th>
                        <th>Azure同等サービス</th>
                    </tr>
                    <tr>
                        <td>RDS (Aurora/MySQL)</td>
                        <td>Cloud SQL for MySQL</td>
                        <td>Azure Database for MySQL</td>
                    </tr>
                    <tr>
                        <td>Lambda</td>
                        <td>Cloud Functions</td>
                        <td>Azure Functions</td>
                    </tr>
                    <tr>
                        <td>ECS / ECR</td>
                        <td>Cloud Run / Artifact Registry</td>
                        <td>Container Apps / ACR</td>
                    </tr>
                    <tr>
                        <td>SQS</td>
                        <td>Pub/Sub</td>
                        <td>Queue Storage</td>
                    </tr>
                    <tr>
                        <td>CloudFront</td>
                        <td>Cloud CDN</td>
                        <td>Azure CDN</td>
                    </tr>
                    <tr>
                        <td>WAF</td>
                        <td>Cloud Armor</td>
                        <td>Azure WAF</td>
                    </tr>
                </table>

                <h3>🔵 Google Cloud Platform (GCP)</h3>
                <div class="cost-card">
                    <h4>推奨アーキテクチャ</h4>
                    <ul>
                        <li><strong>アプリケーション:</strong> Cloud Run（フルマネージド・サーバーレス）</li>
                        <li><strong>データベース:</strong> Cloud SQL for MySQL</li>
                        <li><strong>セキュリティ:</strong> Cloud Armor（WAF + DDoS防御）</li>
                        <li><strong>ストレージ:</strong> Cloud Storage</li>
                        <li><strong>メッセージング:</strong> Pub/Sub</li>
                    </ul>
                    
                    <h4>✅ 技術的実現可能性</h4>
                    <p>PHP/LaravelおよびNode.js/Nuxtを強力にサポート。Cloud Runはトラフィックがない場合ゼロにスケールするためコスト効率が高い。</p>
                    
                    <h4>💰 予測コスト</h4>
                    <p>中～低（詳細試算にはGCP料金計算ツールを使用）</p>
                </div>

                <h3>🔷 Microsoft Azure</h3>
                <div class="cost-card">
                    <h4>推奨アーキテクチャ</h4>
                    <ul>
                        <li><strong>アプリケーション:</strong> App Service / Container Apps</li>
                        <li><strong>データベース:</strong> Azure Database for MySQL - Flexible Server</li>
                        <li><strong>セキュリティ:</strong> Azure WAF + Application Gateway</li>
                        <li><strong>ストレージ:</strong> Blob Storage</li>
                        <li><strong>メッセージング:</strong> Queue Storage</li>
                    </ul>
                    
                    <h4>✅ 技術的実現可能性</h4>
                    <p>エンタープライズグレードのセキュリティと豊富なドキュメント。LaravelとNuxtアプリケーションのデプロイをサポート。</p>
                    
                    <h4>💰 予測コスト</h4>
                    <p>中（Azure料金計算ツールで詳細試算可能）</p>
                </div>

                <h3>⚠️ 移行に関する考察</h3>
                <div class="warning">
                    <h3>移行の複雑性とリスク</h3>
                    <ul>
                        <li><strong>35以上のサービス</strong>すべてを再設計・再実装する必要</li>
                        <li>Step Functions、Glue、IAMなどプラットフォーム固有サービスの完全な作り直し</li>
                        <li>数ヶ月にわたる計画、テスト、実行が必要</li>
                        <li>専門の移行プロジェクトチームの組成が必須</li>
                        <li>チーム全体の再教育コストが発生</li>
                    </ul>
                    <p><strong>結論:</strong> コスト削減が唯一の動機であり、AWS内で解決可能であるならば、全面的な移行は過大なリスクとコストを伴う可能性があります。</p>
                </div>
            </section>

            <!-- 国内サーバー -->
            <section id="domestic">
                <h2>🏠 国内ホスティング事業者への移行分析</h2>

                <div class="highlight-box">
                    <strong>🔍 評価の視点</strong>
                    <p>月額料金だけでなく、高度なアプリケーションを運用するために必要な<strong>総所有コスト（TCO）</strong>の観点から分析することが極めて重要です。</p>
                </div>

                <h3>🖥️ Xサーバー（VPS）</h3>
                <div class="warning">
                    <h3>結論：Xサーバー移行はNG❌ </h3>
                    <p>シンプルなウェブサイトには最適ですが、現状の分散型でセキュアな高機能アプリケーションには不適切です。</p>
                    <p><strong>サーバー費用の削減分を、運用負荷の増大と専門人材確保の人件費が相殺、あるいは上回る可能性が極めて高い</strong></p>
                </div>

                <div class="cost-card">
                    <h4>提供サービス</h4>
                    <p>共有ホスティング、VPS（仮想専用サーバー）、専用サーバー</p>
                    
                    <h4>💰 表面的なコスト</h4>
                    <p>高スペックVPS（8コア、32GB RAM）: 月額約¥20,000</p>
                    <p style="color: #4caf50; font-weight: bold;">→ 現在のAWS請求額より大幅に安価に見える</p>
                    
                    <h4>⚠️ 隠れたコストと問題点</h4>
                    <ul>
                        <li><strong>マネージドデータベースの不在:</strong> MySQL の設定、バックアップ、高可用性構成を全て自社管理</li>
                        <li><strong>マネージドサービスの欠如:</strong> SQS、ECS、GuardDutyなどを自前で構築・運用</li>
                        <li><strong>アプリケーションセキュリティ:</strong> WAFなどを自らModSecurityで設定・運用</li>
                        <li><strong>スケーラビリティの限界:</strong> 手動のプラン変更でダウンタイムが発生</li>
                        <li><strong>専門人材の確保:</strong> フルタイムの運用エンジニアが必要</li>
                    </ul>
                </div>

                <h3>🌸 さくらのクラウド</h3>
                <div class="warning">
                    <h3>結論：さくらのクラウド移行はOK</h3>
                    <p>データ転送コストが課題のワークロードには検討価値がありますが、現システムの複雑性を考慮すると移行のハードルは依然として高い状態です。</p>
                    <p><strong>ハイパースケーラーと従来VPSの中間に位置し、移行労力は大きいままで、得られるマネージドサービスの恩恵は限定的</strong></p>
                </div>

                <div class="cost-card">
                    <h4>特徴</h4>
                    <ul>
                        <li><strong>データ転送量が課金対象外</strong> - 現状はCloudFrontコストが高いため有利</li>
                        <li>ロードバランサ、マネージドデータベース（Multi-AZ対応）を提供</li>
                        <li>WAFアプライアンス（SiteGuard、AIWAF-VE）を提供</li>
                    </ul>
                    
                    <h4>⚠️ 機能のギャップ</h4>
                    <p>VPSより高機能だが、35以上のAWSサービス群と比較するとエコシステムの広さと深さが不足</p>
                    <ul>
                        <li>SQS、Step Functions、Glue、高度なセキュリティ監視ツールなどが不足</li>
                        <li>WAFアプライアンスが高額（月額¥77,000から）</li>
                        <li>大幅なアーキテクチャ変更が必要</li>
                    </ul>
                </div>

                <h3>📊 総所有コスト（TCO）の考え方</h3>
                <div class="chart-container">
                    <h4>コスト構造の比較</h4>
                    <table class="comparison-table">
                        <tr>
                            <th>項目</th>
                            <th>AWS（最適化後）</th>
                            <th>国内VPS</th>
                        </tr>
                        <tr>
                            <td>月額インフラ料金</td>
                            <td>中</td>
                            <td style="color: #4caf50; font-weight: bold;">低</td>
                        </tr>
                        <tr>
                            <td>運用工数</td>
                            <td style="color: #4caf50; font-weight: bold;">低（自動化）</td>
                            <td style="color: #f44336; font-weight: bold;">極高（手動）</td>
                        </tr>
                        <tr>
                            <td>人件費</td>
                            <td style="color: #4caf50; font-weight: bold;">低</td>
                            <td style="color: #f44336; font-weight: bold;">高</td>
                        </tr>
                        <tr>
                            <td>スケーラビリティ</td>
                            <td style="color: #4caf50; font-weight: bold;">高（自動）</td>
                            <td style="color: #f44336; font-weight: bold;">低（手動）</td>
                        </tr>
                        <tr>
                            <td>セキュリティリスク</td>
                            <td style="color: #4caf50; font-weight: bold;">低</td>
                            <td style="color: #f44336; font-weight: bold;">高（自己責任）</td>
                        </tr>
                        <tr>
                            <td><strong>総コスト（TCO）</strong></td>
                            <td style="color: #4caf50; font-weight: bold; font-size: 1.2em;">低～中</td>
                            <td style="color: #f44336; font-weight: bold; font-size: 1.2em;">中～高</td>
                        </tr>
                    </table>
                </div>

                <div class="highlight-box">
                    <h3>💡 重要な洞察</h3>
                    <p>現状のアプリケーションは、もはや単なる「サーバー」の上で動いているのではなく、多数の「マネージドサービス」の組み合わせによって成り立っています。</p>
                    <p><strong>国内事業者への移行 = このエコシステムを自力で再構築すること</strong></p>
                    <p>インフラの月額料金を削減する代わりに、高度なスキルを持つエンジニアの運用時間を大幅に増加させるトレードオフです。</p>
                </div>
            </section>

            <!-- 推奨事項 -->
            <section id="recommendation">
                <h2>⭐ 総合評価と戦略的推奨事項</h2>

                <h3>📋 意思決定マトリクス</h3>
                <table class="comparison-table">
                    <tr>
                        <th>評価項目</th>
                        <th>最適化されたAWS</th>
                        <th>GCP</th>
                        <th>Azure</th>
                        <th>Xサーバー</th>
                        <th>さくらのクラウド</th>
                    </tr>
                    <tr>
                        <td>予測月額コスト</td>
                        <td>中（大幅削減後）</td>
                        <td>中～低</td>
                        <td>中</td>
                        <td>低</td>
                        <td>低～中</td>
                    </tr>
                    <tr>
                        <td>移行コスト/労力</td>
                        <td style="color: #4caf50; font-weight: bold;">低</td>
                        <td style="color: #ff9800;">高</td>
                        <td style="color: #ff9800;">高</td>
                        <td style="color: #f44336;">極高</td>
                        <td style="color: #ff9800;">高</td>
                    </tr>
                    <tr>
                        <td>スケーラビリティ</td>
                        <td style="color: #4caf50; font-weight: bold;">高</td>
                        <td style="color: #4caf50;">高</td>
                        <td style="color: #4caf50;">高</td>
                        <td style="color: #f44336;">低</td>
                        <td style="color: #ff9800;">中</td>
                    </tr>
                    <tr>
                        <td>セキュリティ</td>
                        <td style="color: #4caf50; font-weight: bold;">高</td>
                        <td style="color: #4caf50;">高</td>
                        <td style="color: #4caf50;">高</td>
                        <td style="color: #f44336;">低</td>
                        <td style="color: #ff9800;">中</td>
                    </tr>
                    <tr>
                        <td>マネージドサービス</td>
                        <td style="color: #4caf50; font-weight: bold;">高（既存）</td>
                        <td style="color: #4caf50;">高</td>
                        <td style="color: #4caf50;">高</td>
                        <td style="color: #f44336;">極低</td>
                        <td style="color: #ff9800;">中</td>
                    </tr>
                    <tr>
                        <td>運用負荷</td>
                        <td style="color: #4caf50; font-weight: bold;">低（現状維持）</td>
                        <td style="color: #ff9800;">中（要再学習）</td>
                        <td style="color: #ff9800;">中（要再学習）</td>
                        <td style="color: #f44336;">極高</td>
                        <td style="color: #ff9800;">高</td>
                    </tr>
                    <tr>
                        <td><strong>総合評価</strong></td>
                        <td><span class="star-rating">★★★★★</span></td>
                        <td><span class="star-rating">★★★★☆</span></td>
                        <td><span class="star-rating">★★★☆☆</span></td>
                        <td><span class="star-rating">★☆☆☆☆</span></td>
                        <td><span class="star-rating">★★☆☆☆</span></td>
                    </tr>
                </table>

                <h3>🎯 最終推奨事項</h3>

                <div class="recommendation" style="margin-top: 30px;">
                    <h3>🥇 最優先推奨：現行AWS構成の最適化</h3>
                    <h4>推奨理由</h4>
                    <ul>
                        <li><strong>最大のコスト削減効果:</strong> 予測40%～60%削減</li>
                        <li><strong>最も低いリスク:</strong> チーム再教育不要、既存知識を活用</li>
                        <li><strong>最小の労力:</strong> アプリケーション書き換え不要</li>
                        <li><strong>迅速な成果:</strong> 短期間で確実な結果を実現</li>
                        <li><strong>豊富なエコシステム:</strong> 35以上のサービスを引き続き活用</li>
                    </ul>
                    
                    <h4>具体的なアクション</h4>
                    <ol>
                        <li><strong>即実施:</strong> RDSをAurora Serverless v2からプロビジョニング済みインスタンス（db.r6g.large、db.t3.medium）へ移行</li>
                        <li><strong>第1週:</strong> Savings Plansの契約検討</li>
                        <li><strong>第2-4週:</strong> CloudFront Price Class最適化とLambdaメモリ調整</li>
                        <li><strong>継続的:</strong> Lambda ARM移行とバッチ処理実装</li>
                    </ol>
                </div>

                <div class="cost-card" style="margin-top: 30px; border: 3px solid #4caf50;">
                    <h3>🥈 二次推奨：GCPへの段階的移行計画</h3>
                    <h4>検討すべき条件</h4>
                    <ul>
                        <li>コスト以外の戦略的理由が存在する場合</li>
                        <li>特定のGCPサービス（Cloud Runなど）が必須の場合</li>
                        <li>Googleとの事業提携がある場合</li>
                    </ul>
                    
                    <h4>推奨アプローチ</h4>
                    <p><strong>まずAWS内のコスト最適化を完了し、予算の余裕があった場合に、12～18ヶ月スパンの長期プロジェクトとして開始</strong></p>
                    
                    <h4>移行ステップ</h4>
                    <ol>
                        <li>AWS最適化完了（3-6ヶ月）</li>
                        <li>GCP移行計画策定（2-3ヶ月）</li>
                        <li>PoCで検証（3-4ヶ月）</li>
                        <li>段階的な本番移行（6-8ヶ月）</li>
                    </ol>
                </div>

                <div class="warning" style="margin-top: 30px;">
                    <h3>❌ 非推奨：国内IaaS/VPS事業者への移行</h3>
                    <h4>非推奨の理由</h4>
                    <ul>
                        <li><strong>技術的後退:</strong> マネージドサービスエコシステムの劣化</li>
                        <li><strong>隠れたコスト:</strong> 運用工数とエンジニアリングコストの増大</li>
                        <li><strong>スケーラビリティの喪失:</strong> ビジネス成長の妨げ</li>
                        <li><strong>セキュリティリスク:</strong> 自社責任の増大</li>
                        <li><strong>総所有コスト:</strong> 表面的な安さを運用コストが上回る</li>
                    </ul>
                    
                    <p><strong>結論:</strong> 現状の複雑なアプリケーションと将来の成長目標には合致しません</p>
                </div>

                <h3>📈 期待される成果</h3>
                <div class="cost-grid">
                    <div class="cost-card">
                        <h4>短期的成果（3-6ヶ月）</h4>
                        <ul>
                            <li>月額コスト40-60%削減</li>
                            <li>RDS費用50%以上削減</li>
                            <li>年間数百万円のコスト削減</li>
                        </ul>
                    </div>
                    
                    <div class="cost-card">
                        <h4>中期的成果（6-12ヶ月）</h4>
                        <ul>
                            <li>Lambda実行コスト20%削減</li>
                            <li>CloudFront配信コスト最適化</li>
                            <li>継続的な最適化文化の確立</li>
                        </ul>
                    </div>
                    
                    <div class="cost-card">
                        <h4>長期的価値</h4>
                        <ul>
                            <li>FinOps実践による持続的最適化</li>
                            <li>チームのクラウド運用スキル向上</li>
                            <li>将来の技術選択肢の柔軟性維持</li>
                        </ul>
                    </div>
                </div>

                <div class="highlight-box" style="margin-top: 40px; background: linear-gradient(135deg, #4caf5015 0%, #2e7d3215 100%); border-left-color: #4caf50;">
                    <h3>✨ 最後に</h3>
                    <p>本レポートの分析により、<strong>「プラットフォームを変える前に、まず現在の環境を健全化する」</strong>ことが最も合理的なアプローチであることが明確になりました。</p>
                    <p>これは単なるコスト削減策ではなく、クラウド資源を効率的に管理するための基本的なFinOps（Cloud Financial Management）の実践です。</p>
                    <p><strong>今すぐAWS最適化を開始し、確実な成果を手に入れましょう。</strong></p>
                </div>
            </section>
        </main>

        <footer>
            <p>© 2025 AWS Infrastructure Cost Optimization Report</p>
            <p>本レポートは現システムの戦略的意思決定をサポートするための包括的分析です</p>
        </footer>
    </div>

    <script>
        function showSection(sectionId) {
            // すべてのセクションを非表示
            const sections = document.querySelectorAll('section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // すべてのボタンの active クラスを削除
            const buttons = document.querySelectorAll('nav button');
            buttons.forEach(button => {
                button.classList.remove('active');
            });

            // 指定されたセクションを表示
            document.getElementById(sectionId).classList.add('active');

            // クリックされたボタンに active クラスを追加
            event.target.classList.add('active');

            // ページトップにスムーズスクロール
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // ページ読み込み時のアニメーション
        window.addEventListener('load', function() {
            document.querySelector('.container').style.opacity = '0';
            document.querySelector('.container').style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                document.querySelector('.container').style.transition = 'all 0.6s ease';
                document.querySelector('.container').style.opacity = '1';
                document.querySelector('.container').style.transform = 'translateY(0)';
            }, 100);
        });

        // コストカードのホバーエフェクト強化
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.cost-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s ease';
                });
            });
        });
    </script>
</body>
</html>