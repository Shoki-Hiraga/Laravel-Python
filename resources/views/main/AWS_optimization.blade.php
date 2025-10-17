<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>戦略的AWSインフラストラクチャのコスト最適化とスケーラビリティ分析</title>
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

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .subtitle {
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

        nav ul {
            list-style: none;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
        }

        nav a {
            text-decoration: none;
            color: #667eea;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s;
            font-weight: 600;
            background: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        nav a:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(102,126,234,0.3);
        }

        main {
            padding: 40px;
        }

        section {
            margin-bottom: 60px;
            scroll-margin-top: 80px;
        }

        h2 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }

        h3 {
            color: #764ba2;
            font-size: 1.5em;
            margin: 30px 0 20px;
        }

        .highlight-box {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-left: 5px solid #667eea;
            padding: 25px;
            margin: 25px 0;
            border-radius: 10px;
        }

        .cost-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .cost-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .cost-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .cost-card h4 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.2em;
        }

        .cost-value {
            font-size: 2em;
            font-weight: bold;
            color: #764ba2;
            margin: 10px 0;
        }

        .now {
            color: #00ff3c;
            font-weight: bold;
        }

        .savings {
            color: #28a745;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .recommendation {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
        }

        .recommendation h4 {
            color: #856404;
            margin-bottom: 10px;
        }

        ul {
            margin-left: 20px;
            margin-top: 15px;
        }

        li {
            margin: 10px 0;
        }

        .phase {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .phase h4 {
            color: #667eea;
            font-size: 1.3em;
            margin-bottom: 15px;
        }

        .chart-container {
            margin: 30px 0;
            padding: 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        canvas {
            max-height: 400px;
        }

        footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            margin: 5px;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #333;
        }

        .badge-info {
            background: #17a2b8;
            color: white;
        }

        @media (max-width: 768px) {
            header {
                padding: 40px 20px;
            }

            h1 {
                font-size: 1.8em;
            }

            main {
                padding: 20px;
            }

            nav ul {
                flex-direction: column;
            }

            .cost-summary {
                grid-template-columns: 1fr;
            }
        }

        .comparison-table {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 30px 0;
        }

        .comparison-card {
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .current {
            background: #fff5f5;
            border: 2px solid #e53e3e;
        }

        .proposed {
            background: #f0fff4;
            border: 2px solid #38a169;
        }
    </style>
        <nav>
            <ul>
                <li><a href="#summary">📊 サマリー</a></li>
                <li><a href="#rds">💾 RDS最適化</a></li>
                <li><a href="#cdn">🌐 CDN/WAF</a></li>
                <li><a href="#lambda">⚡ Lambda</a></li>
                <li><a href="#ec2">🖥️ EC2</a></li>
                <li><a href="#roadmap">🗺️ 実施計画</a></li>
            </ul>
        </nav>
</head>
<body>
    <div class="container">
        <header>
            <h1>🚀 戦略的AWSインフラストラクチャ</h1>
            <div class="subtitle">コスト最適化とスケーラビリティ分析レポート</div>
        </header>

        <main>
            <section id="summary">
                <h2>📊 エグゼクティブサマリー</h2>
                
                <div class="highlight-box">
                    <h3>🎯 主要な成果</h3>
                    <p><strong>年間現状見込額：<span class="cost-value now">¥3,526,887</span></strong></p>
                    <p><strong>年間削減見込額：<span class="cost-value savings">¥1,771,350</span></strong></p>
                    <p><strong>削減率：約58%</strong></p>
                </div>

                <div class="cost-summary">
                    <div class="cost-card">
                        <h4>💾 RDS</h4>
                        <div class="cost-value">65-75%</div>
                        <p>削減見込み</p>
                        <span class="badge badge-success">年間 ¥1,022,240</span>
                    </div>
                    <div class="cost-card">
                        <h4>🌐 CDN/WAF</h4>
                        <div class="cost-value">50-60%</div>
                        <p>削減見込み</p>
                        <span class="badge badge-success">年間 ¥510,628</span>
                    </div>
                    <div class="cost-card">
                        <h4>⚡ Lambda</h4>
                        <div class="cost-value">30-40%</div>
                        <p>削減見込み</p>
                        <span class="badge badge-success">年間 ¥96,354</span>
                    </div>
                    <div class="cost-card">
                        <h4>🖥️ EC2</h4>
                        <div class="cost-value">40-60%</div>
                        <p>削減見込み</p>
                        <span class="badge badge-success">年間 ¥142,128</span>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="savingsChart"></canvas>
                </div>

                <div class="recommendation">
                    <h4>💡 主要な提言</h4>
                    <ul>
                        <li><strong>RDSアーキテクチャ転換:</strong> Aurora Serverless v2からプロビジョニング済みGravitonベースAuroraへ移行</li>
                        <li><strong>CDN/WAF統合:</strong> CloudFrontとAWS WAFをCloudflareの統合プランに移行</li>
                        <li><strong>コンピューティング近代化:</strong> EC2とLambdaをGraviton (ARM)アーキテクチャへ移行</li>
                        <li><strong>割引モデル適用:</strong> RIとCompute Savings Plansの戦略的購入</li>
                    </ul>
                </div>
            </section>

            <section id="rds">
                <h2>💾 RDS（データベース）の最適化</h2>
                
                <div class="highlight-box">
                    <h3>🔍 現状の課題</h3>
                    <p>6か月間のコスト: <strong>¥786,339</strong>（最大の支出項目）</p>
                    <p>現在の構成: <strong>Aurora Serverless v2</strong></p>
                    <p><span class="badge badge-warning">⚠️ ワークロードとサービスモデルのミスマッチ</span></p>
                </div>

                <h3>📈 ワークロード分析</h3>
                <table>
                    <thead>
                        <tr>
                            <th>クラスタ名</th>
                            <th>平均ACU</th>
                            <th>最大ACU</th>
                            <th>特徴</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>gai-production-mysql8</td>
                            <td>5.11 ACU</td>
                            <td>5.96 ACU</td>
                            <td>最も負荷が高いが安定</td>
                        </tr>
                        <tr>
                            <td>qsh-production-mysql8</td>
                            <td>0.63 AUC</td>
                            <td>0.56 AUC</td>
                            <td>非常に低負荷で安定</td>
                        </tr>
                        <tr>
                            <td>marketprice-production-mysql8</td>
                            <td>0.51 AUC</td>
                            <td>0.51 AUC</td>
                            <td>非常に低負荷で安定</td>
                        </tr>
                    </tbody>
                </table>

                <div class="recommendation">
                    <h4>✅ 推奨される対策</h4>
                    <ol>
                        <li><strong>プロビジョニング済みAuroraへ移行</strong>
                            <ul>
                                <li>安定したワークロードに最適</li>
                                <li>固定料金で予測可能なコスト</li>
                                <li>同一クラスタ内で変更可能（低リスク）</li>
                            </ul>
                        </li>
                        <li><strong>Gravitonインスタンスを選択</strong>
                            <ul>
                                <li>最大30%の性能向上</li>
                                <li>最大20%の価格性能比改善</li>
                                <li>推奨: db.r7g.large または db.r7g.xlarge</li>
                            </ul>
                        </li>
                        <li><strong>リザーブドインスタンス(RI)購入</strong>
                            <ul>
                                <li>3年契約で最大72%割引</li>
                                <li>スタンダードRIを推奨</li>
                            </ul>
                        </li>
                    </ol>
                </div>

                <h3>💰 コスト比較</h3>
                <div class="comparison-table">
                    <div class="comparison-card current">
                        <h4>❌ 現状: Aurora Serverless v2</h4>
                        <p><strong>月額コスト:</strong> 約¥64,440</p>
                        <p><strong>年間コスト:</strong> 約¥773,280</p>
                        <p>平均5.68 ACU で稼働</p>
                    </div>
                    <div class="comparison-card proposed">
                        <h4>✅ 提案: Provisioned db.r7g.large (1年RI)</h4>
                        <p><strong>月額コスト:</strong> 約¥37,200</p>
                        <p><strong>年間コスト:</strong> 約¥446,400</p>
                        <p class="savings">年間削減額: ¥326,880 (42%削減)</p>
                    </div>
                </div>

                <div class="highlight-box">
                    <h4>🚀 スケーラビリティ</h4>
                    <ul>
                        <li><strong>垂直スケーリング:</strong> インスタンスサイズを数分で変更可能</li>
                        <li><strong>水平スケーリング:</strong> 最大15台のリードレプリカを追加可能</li>
                        <li>将来のユーザー増加に柔軟に対応できる構造</li>
                    </ul>
                </div>
            </section>

            <section id="cdn">
                <h2>🌐 CDN/WAFの戦略的見直し</h2>
                
                <div class="highlight-box">
                    <h3>🔍 現状の課題</h3>
                    <p>CloudFront: <strong>¥416,883</strong> (6か月)</p>
                    <p>AWS WAF: <strong>¥63,431</strong> (6か月)</p>
                    <p>合計月額: <strong>約¥80,053</strong></p>
                    <p><span class="badge badge-warning">⚠️ データ転送料金が主要コスト</span></p>
                </div>

                <h3>⚖️ サービス比較</h3>
                <table>
                    <thead>
                        <tr>
                            <th>項目</th>
                            <th>AWS CloudFront + WAF</th>
                            <th>Cloudflare Business</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>データ転送料金</td>
                            <td>従量課金 (~$0.114/GB)</td>
                            <td><strong>プラン込み（実質無料）</strong></td>
                        </tr>
                        <tr>
                            <td>WAF料金</td>
                            <td>別サービス、従量課金</td>
                            <td><strong>プラン込み</strong></td>
                        </tr>
                        <tr>
                            <td>DDoS防御</td>
                            <td>標準提供</td>
                            <td><strong>高度な機能込み</strong></td>
                        </tr>
                        <tr>
                            <td>Bot対策</td>
                            <td>限定的</td>
                            <td><strong>高度な管理機能込み</strong></td>
                        </tr>
                        <tr>
                            <td>エッジロケーション</td>
                            <td>400以上</td>
                            <td><strong>335都市以上</strong></td>
                        </tr>
                        <tr>
                            <td>管理の容易さ</td>
                            <td>複数サービス管理</td>
                            <td><strong>単一ダッシュボード</strong></td>
                        </tr>
                        <tr>
                            <td><strong>月額コスト</strong></td>
                            <td><strong>約¥80,053</strong></td>
                            <td><strong>約¥37,500</strong></td>
                        </tr>
                    </tbody>
                </table>

                <div class="recommendation">
                    <h4>✅ 推奨される対策</h4>
                    <p><strong>Cloudflare Business プランへの移行</strong></p>
                    <ul>
                        <li><strong>月額削減額:</strong> 約¥42,553</li>
                        <li><strong>年間削減額:</strong> 約¥510,636 (53%削減)</li>
                        <li>データ転送量に関係なく固定料金</li>
                        <li>トラフィック増加時もコスト増加なし</li>
                        <li>WAF、DDoS防御、Bot対策が統合</li>
                    </ul>
                </div>

                <div class="chart-container">
                    <canvas id="cdnComparisonChart"></canvas>
                </div>

                <div class="highlight-box">
                    <h4>📈 実績事例</h4>
                    <p>ある企業では、Cloudflareへの移行により:</p>
                    <ul>
                        <li>オリジンからの転送量: <strong>131.3TB → 8.6TB</strong></li>
                        <li>月額コスト削減: <strong>100〜200万円</strong></li>
                    </ul>
                </div>
            </section>

            <section id="lambda">
                <h2>⚡ Lambda（サーバーレス）の最適化</h2>
                
                <div class="highlight-box">
                    <h3>🔍 現状</h3>
                    <p>6か月間のコスト: <strong>¥137,649</strong></p>
                    <p>削減目標: <strong>30-40%</strong></p>
                </div>

                <div class="recommendation">
                    <h4>✅ 推奨される対策</h4>
                    
                    <h4>1️⃣ リソースのライトサイジング</h4>
                    <ul>
                        <li><strong>AWS Lambda Power Tuning:</strong> 最適なメモリ設定を自動検出</li>
                        <li>性能とコストのトレードオフを可視化</li>
                        <li>CI/CDパイプラインに組み込み継続的最適化</li>
                    </ul>

                    <h4>2️⃣ Graviton2 (ARM) アーキテクチャへ移行</h4>
                    <ul>
                        <li><span class="badge badge-success">最大19%高いパフォーマンス</span></li>
                        <li><span class="badge badge-success">20%低いコスト</span></li>
                        <li>コンソールで設定変更のみ（簡単実装）</li>
                        <li>PHPランタイムは互換性問題なし</li>
                    </ul>

                    <h4>3️⃣ 呼び出し効率の向上</h4>
                    <ul>
                        <li><strong>バッチ処理:</strong> SQSから複数メッセージを1回で処理</li>
                        <li><strong>イベントフィルタリング:</strong> 必要なイベントのみで起動</li>
                        <li>不要な呼び出しを削減しリクエスト料金を削減</li>
                    </ul>

                    <h4>4️⃣ Compute Savings Plans適用</h4>
                    <ul>
                        <li>1年または3年契約で最大17%割引</li>
                        <li>EC2、Fargate、Lambdaに自動適用</li>
                        <li>柔軟性を維持しながらコスト削減</li>
                    </ul>
                </div>

                <div class="chart-container">
                    <canvas id="lambdaOptimizationChart"></canvas>
                </div>
            </section>

            <section id="ec2">
                <h2>🖥️ EC2（コアコンピューティング）の最適化</h2>
                
                <div class="highlight-box">
                    <h3>🔍 現状</h3>
                    <p>6か月間のコスト: <strong>¥118,440</strong></p>
                    <p>削減目標: <strong>40-60%</strong></p>
                </div>

                <div class="recommendation">
                    <h4>✅ 推奨される対策</h4>
                    
                    <h4>1️⃣ AWS Gravitonへの移行</h4>
                    <ul>
                        <li><strong>PHPでの性能向上:</strong> Intel M5比で最大37%高速</li>
                        <li><strong>価格性能比:</strong> 最大34%改善</li>
                        <li><strong>全体的な改善:</strong> 約40%のコスト削減</li>
                        <li><strong>Laravel対応:</strong> Laravel ForgeがT4g公式サポート</li>
                    </ul>

                    <h4>2️⃣ 継続的なライトサイジング</h4>
                    <ul>
                        <li><strong>CloudWatch:</strong> CPU、メモリ、ネットワーク使用率を監視</li>
                        <li><strong>分析期間:</strong> 14〜30日間のデータ収集</li>
                        <li><strong>判断基準:</strong> 95パーセンタイルが40%未満ならダウンサイズ検討</li>
                        <li><strong>AWS Compute Optimizer:</strong> 自動推奨の活用</li>
                    </ul>

                    <h4>3️⃣ Compute Savings Plans適用</h4>
                    <ul>
                        <li>最も柔軟な割引モデル</li>
                        <li>インスタンスファミリー、リージョン変更に対応</li>
                        <li>Graviton移行やライトサイジング後も割引継続</li>
                        <li>Lambda、Fargateにも自動適用</li>
                    </ul>
                </div>

                <div class="highlight-box">
                    <h4>🆚 購入モデル比較</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>モデル</th>
                                <th>割引率</th>
                                <th>柔軟性</th>
                                <th>推奨度</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>リザーブドインスタンス</td>
                                <td>最大72%</td>
                                <td>❌ 低い</td>
                                <td>⚠️ 注意</td>
                            </tr>
                            <tr>
                                <td>EC2 Instance SP</td>
                                <td>高い</td>
                                <td>△ 中程度</td>
                                <td>△ 条件付き</td>
                            </tr>
                            <tr>
                                <td><strong>Compute SP</strong></td>
                                <td>中〜高</td>
                                <td>✅ 最も高い</td>
                                <td>✅ <strong>推奨</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="chart-container">
                    <canvas id="ec2SavingsChart"></canvas>
                </div>
            </section>

            <section id="roadmap">
                <h2>🗺️ 実施ロードマップ</h2>

                <div class="phase">
                    <h4>📅 フェーズ1: 即時的な高インパクト施策（1〜2か月）</h4>
                    <ul>
                        <li><strong>1. CDN/WAFのCloudflare移行</strong>
                            <ul>
                                <li>DNS設定変更とトラフィック切替</li>
                                <li>WAFルール・キャッシュ設定の構成</li>
                                <li><span class="badge badge-success">最高ROI</span></li>
                            </ul>
                        </li>
                        <li><strong>2. RDSのProvisioned Gravitonへ移行</strong>
                            <ul>
                                <li>リードレプリカ作成とインスタンス変更</li>
                                <li>フェイルオーバーで本番移行</li>
                                <li><span class="badge badge-success">最大コスト削減</span></li>
                            </ul>
                        </li>
                        <li><strong>3. RDSリザーブドインスタンス購入</strong>
                            <ul>
                                <li>移行完了・安定稼働確認後に購入</li>
                                <li>1年または3年のスタンダードRI</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="phase">
                    <h4>📅 フェーズ2: コンピューティング基盤の近代化（2〜4か月）</h4>
                    <ul>
                        <li><strong>1. EC2インスタンスのGraviton移行</strong>
                            <ul>
                                <li>ARM64 AMI準備</li>
                                <li>ステージング環境で検証</li>
                                <li>本番環境を順次置換</li>
                            </ul>
                        </li>
                        <li><strong>2. Lambda関数のARM移行とチューニング</strong>
                            <ul>
                                <li>全関数をarm64に設定変更</li>
                                <li>Lambda Power Tuning実行</li>
                                <li>最適なメモリ設定を適用</li>
                            </ul>
                        </li>
                        <li><strong>3. Compute Savings Plans購入</strong>
                            <ul>
                                <li>Graviton化後のベースライン算出</li>
                                <li>1年または3年のCompute SP購入</li>
                                <li>EC2とLambda両方に適用</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="phase">
                    <h4>📅 フェーズ3: 継続的な最適化プロセス（定常運用）</h4>
                    <ul>
                        <li><strong>1. EC2継続的ライトサイジング</strong>
                            <ul>
                                <li>四半期ごとのレビュー実施</li>
                                <li>Compute Optimizerの推奨確認</li>
                                <li>CloudWatchメトリクス分析</li>
                            </ul>
                        </li>
                        <li><strong>2. Lambdaアーキテクチャ最適化</strong>
                            <ul>
                                <li>SQSバッチ処理の実装</li>
                                <li>イベントフィルタリング設定</li>
                                <li>呼び出し回数削減の継続</li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <h3>📊 総合コスト削減効果</h3>
                <table>
                    <thead>
                        <tr>
                            <th>サービス</th>
                            <th>現状（6か月）</th>
                            <th>提案後（6か月）</th>
                            <th>削減額（年間）</th>
                            <th>削減率</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>RDS</strong></td>
                            <td>¥786,339</td>
                            <td>¥275,219</td>
                            <td class="savings">¥1,022,240</td>
                            <td><span class="badge badge-success">~65%</span></td>
                        </tr>
                        <tr>
                            <td><strong>CloudFront + WAF</strong></td>
                            <td>¥480,314</td>
                            <td>¥225,000</td>
                            <td class="savings">¥510,628</td>
                            <td><span class="badge badge-success">~53%</span></td>
                        </tr>
                        <tr>
                            <td><strong>Lambda</strong></td>
                            <td>¥137,649</td>
                            <td>¥89,472</td>
                            <td class="savings">¥96,354</td>
                            <td><span class="badge badge-success">~35%</span></td>
                        </tr>
                        <tr>
                            <td><strong>EC2</strong></td>
                            <td>¥118,440</td>
                            <td>¥47,376</td>
                            <td class="savings">¥142,128</td>
                            <td><span class="badge badge-success">~60%</span></td>
                        </tr>
                        <tr style="background: #f0fff4; font-weight: bold;">
                            <td><strong>合計</strong></td>
                            <td><strong>¥1,522,742</strong></td>
                            <td><strong>¥637,067</strong></td>
                            <td class="savings" style="font-size: 1.3em;"><strong>¥1,771,350</strong></td>
                            <td><span class="badge badge-success" style="font-size: 1.1em;">~58%</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="chart-container">
                    <canvas id="totalSavingsChart"></canvas>
                </div>

                <div class="highlight-box">
                    <h4>🚀 将来のスケーラビリティ確保</h4>
                    <p>本提案は、コスト削減だけでなく、将来のユーザー増加に対応する堅牢な基盤を構築します：</p>
                    <ul>
                        <li><strong>データベース:</strong> リードレプリカ追加で読み取り負荷を水平分散</li>
                        <li><strong>CDN:</strong> Cloudflareのグローバルネットワークでトラフィック急増に対応</li>
                        <li><strong>コンピューティング:</strong> Auto Scaling Groupで負荷に応じた自動スケール</li>
                        <li><strong>サーバーレス:</strong> Lambda本来のスケーラビリティを低コストで活用</li>
                    </ul>
                </div>
            </section>

            <section id="benefits">
                <h2>✨ 導入効果まとめ</h2>
                
                <div class="cost-summary">
                    <div class="cost-card">
                        <h4>💰 コスト削減</h4>
                        <div class="cost-value savings">¥1,771,350</div>
                        <p>年間削減額</p>
                        <p>現状比 <strong>58%減</strong></p>
                    </div>
                    <div class="cost-card">
                        <h4>📈 予測可能性</h4>
                        <div class="cost-value">向上</div>
                        <p>従量課金から固定料金へ</p>
                        <p>予算管理が容易に</p>
                    </div>
                    <div class="cost-card">
                        <h4>🔒 セキュリティ</h4>
                        <div class="cost-value">強化</div>
                        <p>統合WAF・DDoS防御</p>
                        <p>追加コストなし</p>
                    </div>
                    <div class="cost-card">
                        <h4>⚡ パフォーマンス</h4>
                        <div class="cost-value">改善</div>
                        <p>Gravitonで高速化</p>
                        <p>ユーザー体験向上</p>
                    </div>
                </div>

                <div class="recommendation">
                    <h4>🎯 次のアクション</h4>
                    <ol>
                        <li>経営陣への提案承認取得</li>
                        <li>フェーズ1の施策から着手（Cloudflare移行・RDS移行）</li>
                        <li>各フェーズ完了後、効果測定と次フェーズへ移行</li>
                        <li>継続的な最適化プロセスを組織に定着</li>
                    </ol>
                </div>
            </section>
        </main>

        <footer>
            <p>📄 戦略的AWSインフラストラクチャのコスト最適化とスケーラビリティ分析レポート</p>
            <p>© 2025 - このレポートは機密情報を含みます</p>
        </footer>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // グラフの共通設定
        const chartColors = {
            primary: '#667eea',
            secondary: '#764ba2',
            success: '#28a745',
            danger: '#e53e3e',
            warning: '#ffc107',
            info: '#17a2b8'
        };

        // サービス別削減額グラフ
        const savingsCtx = document.getElementById('savingsChart');
        new Chart(savingsCtx, {
            type: 'bar',
            data: {
                labels: ['RDS', 'CloudFront + WAF', 'Lambda', 'EC2'],
                datasets: [{
                    label: '年間削減額（円）',
                    data: [1022240, 510628, 96354, 142128],
                    backgroundColor: [
                        chartColors.primary,
                        chartColors.secondary,
                        chartColors.success,
                        chartColors.info
                    ],
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'サービス別年間削減額',
                        font: { size: 18, weight: 'bold' }
                    },
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '削減額: ¥' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '¥' + (value / 1000).toFixed(0) + 'K';
                            }
                        }
                    }
                }
            }
        });

        // CDN比較グラフ
        const cdnCtx = document.getElementById('cdnComparisonChart');
        new Chart(cdnCtx, {
            type: 'doughnut',
            data: {
                labels: ['現状 (CloudFront + WAF)', '削減額', '提案後 (Cloudflare)'],
                datasets: [{
                    data: [480314, 255314, 225000],
                    backgroundColor: [
                        chartColors.danger,
                        chartColors.success,
                        chartColors.primary
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'CDN/WAF コスト比較（6か月）',
                        font: { size: 18, weight: 'bold' }
                    },
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ¥' + context.parsed.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Lambda最適化グラフ
        const lambdaCtx = document.getElementById('lambdaOptimizationChart');
        new Chart(lambdaCtx, {
            type: 'bar',
            data: {
                labels: ['ARM移行', 'メモリ最適化', 'バッチ処理', 'Savings Plans'],
                datasets: [{
                    label: '削減効果 (%)',
                    data: [20, 10, 15, 17],
                    backgroundColor: chartColors.success,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Lambda最適化施策別の削減効果',
                        font: { size: 18, weight: 'bold' }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 25,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // EC2削減グラフ
        const ec2Ctx = document.getElementById('ec2SavingsChart');
        new Chart(ec2Ctx, {
            type: 'line',
            data: {
                labels: ['現状', 'Graviton移行', 'ライトサイジング', 'Savings Plans適用'],
                datasets: [{
                    label: '月額コスト（円）',
                    data: [19740, 13818, 11032, 7896],
                    borderColor: chartColors.primary,
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointBackgroundColor: chartColors.primary
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'EC2コスト削減の段階的効果',
                        font: { size: 18, weight: 'bold' }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'コスト: ¥' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '¥' + (value / 1000).toFixed(0) + 'K';
                            }
                        }
                    }
                }
            }
        });

        // 総合削減効果グラフ
        const totalCtx = document.getElementById('totalSavingsChart');
        new Chart(totalCtx, {
            type: 'bar',
            data: {
                labels: ['RDS', 'CloudFront+WAF', 'Lambda', 'EC2'],
                datasets: [
                    {
                        label: '現状コスト（6か月）',
                        data: [786339, 480314, 137649, 118440],
                        backgroundColor: 'rgba(229, 62, 62, 0.7)',
                        borderRadius: 10
                    },
                    {
                        label: '提案後コスト（6か月）',
                        data: [275219, 225000, 89472, 47376],
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderRadius: 10
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    title: {
                        display: true,
                        text: '総合コスト比較（現状 vs 提案後）',
                        font: { size: 18, weight: 'bold' }
                    },
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ¥' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        stacked: false,
                        ticks: {
                            callback: function(value) {
                                return '¥' + (value / 1000).toFixed(0) + 'K';
                            }
                        }
                    },
                    x: {
                        stacked: false
                    }
                }
            }
        });

        // スムーズスクロール
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });

        // スクロール時のナビゲーションハイライト
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section');
            const navLinks = document.querySelectorAll('nav a');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (pageYOffset >= (sectionTop - 100)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.style.background = 'white';
                link.style.color = '#667eea';
                if (link.getAttribute('href') === '#' + current) {
                    link.style.background = '#667eea';
                    link.style.color = 'white';
                }
            });
        });

        // ページ読み込み時のアニメーション
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.cost-card, .phase, .recommendation');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>