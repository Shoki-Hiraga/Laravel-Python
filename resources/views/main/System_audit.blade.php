<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>戦略的システム監査および事業継続性強化計画書</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Yu Gothic', 'Meiryo', sans-serif;
            line-height: 1.8;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
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

        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }

        .header h1 {
            font-size: 2em;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .nav-tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 3px solid #e9ecef;
            overflow-x: auto;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-tab {
            flex: 1;
            min-width: 150px;
            padding: 18px 20px;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.95em;
            font-weight: 600;
            color: #666;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }

        .nav-tab:hover {
            background: #e9ecef;
            color: #333;
        }

        .nav-tab.active {
            color: #2a5298;
            border-bottom-color: #2a5298;
            background: white;
        }

        .content {
            padding: 40px;
        }

        .section {
            display: none;
            animation: fadeIn 0.5s;
        }

        .section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #1e3c72;
            font-size: 1.8em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        h3 {
            color: #2a5298;
            font-size: 1.4em;
            margin: 30px 0 15px;
            padding-left: 15px;
            border-left: 4px solid #667eea;
        }

        h4 {
            color: #495057;
            font-size: 1.2em;
            margin: 20px 0 10px;
        }

        p {
            margin-bottom: 15px;
            text-align: justify;
        }

        .alert {
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 5px solid;
        }

        .alert-danger {
            background: #fff5f5;
            border-color: #e53e3e;
            color: #742a2a;
        }

        .alert-warning {
            background: #fffaf0;
            border-color: #dd6b20;
            color: #7c2d12;
        }

        .alert-info {
            background: #ebf8ff;
            border-color: #3182ce;
            color: #2c5282;
        }

        .alert-success {
            background: #f0fff4;
            border-color: #38a169;
            color: #22543d;
        }

        .card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #e9ecef;
        }

        .card-header {
            font-weight: 600;
            font-size: 1.1em;
            color: #2a5298;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dee2e6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .badge-high {
            background: #fee;
            color: #c53030;
        }

        .badge-medium {
            background: #fef5e7;
            color: #d97706;
        }

        .badge-low {
            background: #e6f7ff;
            color: #0369a1;
        }

        .timeline {
            position: relative;
            padding-left: 40px;
            margin: 30px 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -35px;
            top: 25px;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background: #667eea;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #667eea;
        }

        .timeline-title {
            font-weight: 600;
            color: #2a5298;
            font-size: 1.1em;
            margin-bottom: 10px;
        }

        ul, ol {
            margin: 15px 0 15px 30px;
        }

        li {
            margin-bottom: 10px;
        }

        .risk-matrix {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .risk-item {
            padding: 20px;
            border-radius: 10px;
            border-left: 5px solid;
        }

        .risk-critical {
            background: #fff5f5;
            border-color: #e53e3e;
        }

        .risk-high {
            background: #fffaf0;
            border-color: #dd6b20;
        }

        .risk-medium {
            background: #fffef0;
            border-color: #ecc94b;
        }

        .checklist {
            list-style: none;
            margin: 20px 0;
        }

        .checklist li {
            padding: 12px 15px 12px 45px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            position: relative;
            border-left: 3px solid #667eea;
        }

        .checklist li::before {
            content: '☐';
            position: absolute;
            left: 15px;
            font-size: 1.5em;
            color: #667eea;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .stat-number {
            font-size: 2.5em;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9em;
            opacity: 0.9;
        }

        .footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #666;
            border-top: 3px solid #e9ecef;
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }

            h2 {
                font-size: 1.5em;
            }

            .nav-tab {
                padding: 15px 10px;
                font-size: 0.85em;
            }

            table {
                font-size: 0.9em;
            }

            th, td {
                padding: 10px;
            }
        }

        .collapsible {
            cursor: pointer;
            user-select: none;
        }

        .collapsible::after {
            content: ' ▼';
            font-size: 0.8em;
            opacity: 0.6;
        }

        .collapsible.collapsed::after {
            content: ' ▶';
        }

        .collapsible-content {
            max-height: 2000px;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .collapsible-content.collapsed {
            max-height: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>戦略的システム監査および事業継続性強化計画書</h1>
            <p>外車王・旧車王 Webプラットフォーム</p>
        </div>

        <div class="nav-tabs">
            <button class="nav-tab active" onclick="showSection('summary')">概要</button>
            <button class="nav-tab" onclick="showSection('current')">現状分析</button>
            <button class="nav-tab" onclick="showSection('risks')">リスク評価</button>
            <button class="nav-tab" onclick="showSection('audit')">監査項目</button>
            <button class="nav-tab" onclick="showSection('bcp')">BCP対策</button>
            <button class="nav-tab" onclick="showSection('roadmap')">ロードマップ</button>
            <button class="nav-tab" onclick="showSection('vendor')">ベンダー管理</button>
        </div>

        <div class="content">
            <!-- 概要セクション -->
            <div id="summary" class="section active">
                <h2>📋 エグゼクティブサマリー</h2>
                
                <div class="alert alert-danger">
                    <strong>⚠️ 現状の危機的状況</strong><br>
                    エンジニア全員退職に伴い、システムがブラックボックス化。インシデント対応が後手に回り、ビジネスの継続性に重大なリスクが発生しています。
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">3</div>
                        <div class="stat-label">重大な構造的問題</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">12</div>
                        <div class="stat-label">ヶ月</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">3</div>
                        <div class="stat-label">フェーズ計画</div>
                    </div>
                </div>

                <h3>📌 本計画の3つの主要目的</h3>
                <div class="card">
                    <ol>
                        <li><strong>潜在的脆弱性とリスクの完全可視化</strong><br>
                        現在のシステムが抱えるリスクを定量的に把握</li>
                        <li><strong>ガバナンス体制の構築</strong><br>
                        外部ベンダー依存下でもコントロール可能な管理体制を確立</li>
                        <li><strong>事業継続計画（BCP）の策定</strong><br>
                        予期せぬ障害や災害からの迅速な復旧を実現</li>
                    </ol>
                </div>

                <h3>🎯 技術スタック</h3>
                <div class="card">
                    <div class="card-header">採用技術</div>
                    <ul>
                        <li><strong>Laravel Vapor</strong> - サーバーレスアーキテクチャ（AWS Lambda）</li>
                        <li><strong>Nuxt.js</strong> - SSR（サーバーサイドレンダリング）</li>
                        <li><strong>AWS</strong> - クラウドインフラ（RDS, S3, CloudWatch等）</li>
                    </ul>
                </div>

                <div class="alert alert-warning">
                    <strong>💡 重要な認識</strong><br>
                    過去に発生したDB不一致、画像消失、SEO事故は単発の不具合ではなく、システム構成と運用体制の構造的な欠陥に起因する警告信号です。
                </div>
            </div>

            <!-- 現状分析セクション -->
            <div id="current" class="section">
                <h2>🔍 現状分析と構造的リスク</h2>

                <h3>技術的リスク一覧</h3>
                <table>
                    <thead>
                        <tr>
                            <th>技術コンポーネント</th>
                            <th>特性</th>
                            <th>想定リスク</th>
                            <th>重要度</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>AWS Lambda (Vapor)</strong></td>
                            <td>ステートレス、実行時間制限</td>
                            <td><strong>DB不一致:</strong> 同時接続数急増時やトランザクション処理の不備により、データの整合性が崩れる。接続数枯渇とタイムアウトによる中途半端なデータ残存のリスク。</td>
                            <td><span class="badge badge-high">高</span></td>
                        </tr>
                        <tr>
                            <td><strong>AWS Lambda (Vapor)</strong></td>
                            <td>コールドスタート</td>
                            <td><strong>SEO事故/UX低下:</strong> コンテナ起動待ち（数秒の遅延）が発生し、5xxエラーやタイムアウトを返すことで検索順位低下の原因となる。</td>
                            <td><span class="badge badge-high">高</span></td>
                        </tr>
                        <tr>
                            <td><strong>Nuxt.js (SSR)</strong></td>
                            <td>サーバーサイドレンダリング</td>
                            <td><strong>Soft 404:</strong> APIエラーやデータ不在時に、エラーページではなく200 OKのまま空ページを返し、インデックス品質を著しく損なう。</td>
                            <td><span class="badge badge-high">高</span></td>
                        </tr>
                        <tr>
                            <td><strong>AWS S3</strong></td>
                            <td>オブジェクトストレージ</td>
                            <td><strong>画像消失:</strong> オペレーションミスやバッチ処理の不具合による誤削除。バージョニング・MFA Deleteが無効の場合、復旧不可能。</td>
                            <td><span class="badge badge-high">高</span></td>
                        </tr>
                    </tbody>
                </table>

                <h3>組織・ガバナンス上の課題</h3>
                <div class="risk-matrix">
                    <div class="risk-item risk-critical">
                        <h4>🔴 ブラックボックス化</h4>
                        <p>ソースコードの品質やセキュリティ対策の判断をベンダーに完全依存。技術的負債の蓄積が検知不能。</p>
                    </div>
                    <div class="risk-item risk-critical">
                        <h4>🔴 ベンダーロックイン</h4>
                        <p>仕様書・設計図不在により、ベンダー変更が極めて困難。コスト交渉力低下とベンダー倒産時の共倒れリスク。</p>
                    </div>
                    <div class="risk-item risk-critical">
                        <h4>🔴 インシデント対応遅延</h4>
                        <p>障害発生時の切り分けに時間を要し、ダウンタイムが直ちに機会損失とブランド毀損につながる。</p>
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>📊 重要な統計</strong><br>
                    過去のインシデントから学ぶべき教訓は、これらが単発の問題ではなく、組織的・構造的な欠陥の症状であるということです。
                </div>
            </div>

            <!-- リスク評価セクション -->
            <div id="risks" class="section">
                <h2>⚠️ リスクアセスメントと脆弱性診断</h2>

                <h3>3層構造の脆弱性診断体制</h3>

                <div class="card">
                    <div class="card-header">🔍 レイヤー1: 自動スキャン (SAST/SCA/DAST)</div>
                    <p><strong>推奨ツール: Aikido Security</strong></p>
                    <ul>
                        <li>静的解析（コードのバグ検出）</li>
                        <li>SCA（ライブラリの脆弱性スキャン）</li>
                        <li>CSPM（クラウド設定ミスの検出）</li>
                        <li>DAST（動的な攻撃シミュレーション）</li>
                    </ul>
                    <div class="alert alert-success">
                        <strong>✅ メリット:</strong> AI自動選別により非技術者でも直感的に理解可能。CI/CDに組み込むことで脆弱なコードの本番流出を防止。
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">🛡️ レイヤー2: AWS環境の継続的セキュリティ評価</div>
                    <ul>
                        <li><strong>AWS Security Hub:</strong> CIS AWS Foundations Benchmarkに対する準拠状況を自動チェック</li>
                        <li><strong>Amazon GuardDuty:</strong> AIによる脅威検知（不正アクセス、異常な通信パターン等）</li>
                    </ul>
                </div>

                <div class="card">
                    <div class="card-header">🎯 レイヤー3: ペネトレーションテスト</div>
                    <p><strong>実施頻度:</strong> 年1回、または大規模な機能追加時</p>
                    <p><strong>診断内容:</strong> ホワイトハッカーによるビジネスロジックの脆弱性診断</p>
                    <ul>
                        <li>IDOR（他人のデータへの不正アクセス）</li>
                        <li>権限昇格（権限のないユーザーが管理者機能を実行）</li>
                        <li>その他ツールでは検知できない論理的欠陥</li>
                    </ul>
                </div>

                <h3>セキュリティインシデント対応体制</h3>
                <table>
                    <thead>
                        <tr>
                            <th>レベル</th>
                            <th>影響範囲</th>
                            <th>対応時間</th>
                            <th>アクション</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="badge badge-low">レベル1</span></td>
                            <td>サービス影響なし<br>（UI崩れ等）</td>
                            <td>翌営業日対応</td>
                            <td>通常フローで対応</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-medium">レベル2</span></td>
                            <td>一部機能停止<br>SEO影響あり</td>
                            <td>当日中対応</td>
                            <td>ベンダー緊急対応</td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-high">レベル3</span></td>
                            <td>全停止、データ消失<br>情報漏洩</td>
                            <td>24時間以内復旧</td>
                            <td>緊急連絡網発動<br>経営層即時報告</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- 監査項目セクション -->
            <div id="audit" class="section">
                <h2>📝 包括的システム監査チェックリスト</h2>

                <h3 class="collapsible" onclick="toggleCollapse(this)">A. アプリケーション健全性・品質監査</h3>
                <div class="collapsible-content">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>監査対象</th>
                                <th>確認内容</th>
                                <th>ツール</th>
                                <th>重要度</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>APP-01</td>
                                <td>エラーハンドリング</td>
                                <td>CloudWatch Logsに未処理の例外（500エラー）が多発していないか。エラー通知は機能しているか。</td>
                                <td>Sentry, Flare</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>APP-02</td>
                                <td>トランザクション整合性</td>
                                <td>DB更新処理において、トランザクション処理（DB::transaction）が適切に実装されているか。</td>
                                <td>コードレビュー</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>APP-03</td>
                                <td>バリデーション</td>
                                <td>入力値チェックはフロントエンドだけでなく、バックエンドでも厳密に行われているか（API直接叩き対策）。</td>
                                <td>侵入テスト</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>APP-04</td>
                                <td>依存ライブラリ</td>
                                <td>composer.json/package.jsonに、サポート切れや既知の脆弱性を持つライブラリが含まれていないか。</td>
                                <td>Aikido, Dependabot</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>APP-05</td>
                                <td>Nuxt SEO設定</td>
                                <td>動的ルートに対し、sitemap.xmlが自動かつ正確に生成されているか。Soft 404対策は実装済みか。</td>
                                <td>Screaming Frog</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>APP-06</td>
                                <td>非同期処理</td>
                                <td>画像アップロードやメール送信等の重い処理は、キュー（SQS）を用いた非同期処理になっているか。</td>
                                <td>コードレビュー</td>
                                <td><span class="badge badge-medium">中</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="collapsible" onclick="toggleCollapse(this)">B. AWSインフラ・セキュリティ監査</h3>
                <div class="collapsible-content">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>監査対象</th>
                                <th>確認内容</th>
                                <th>ツール</th>
                                <th>重要度</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INF-01</td>
                                <td>IAM権限</td>
                                <td>AdministratorAccessなどの過剰な権限が付与されたIAMユーザー/ロールが存在しないか。</td>
                                <td>IAM Access Analyzer</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>INF-02</td>
                                <td>S3データ保護</td>
                                <td>画像保存用バケット等は、バージョニングとMFA Deleteが有効化されているか。</td>
                                <td>AWS Config</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>INF-03</td>
                                <td>WAF設定</td>
                                <td>AWS WAFが導入され、SQLインジェクションやXSS、既知の悪性IPをブロックしているか。</td>
                                <td>AWS WAF</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>INF-04</td>
                                <td>DBバックアップ</td>
                                <td>RDS/Auroraの自動バックアップ設定（保持期間）は適切か。ポイントインタイムリカバリが可能か。</td>
                                <td>AWS RDS Console</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>INF-05</td>
                                <td>ネットワーク分離</td>
                                <td>DBや内部APIはプライベートサブネットに配置され、インターネットから直接アクセスできないか。</td>
                                <td>AWS VPC Console</td>
                                <td><span class="badge badge-medium">中</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="collapsible" onclick="toggleCollapse(this)">C. 運用プロセス・ドキュメント監査</h3>
                <div class="collapsible-content">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>監査対象</th>
                                <th>確認内容</th>
                                <th>ツール</th>
                                <th>重要度</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>OPS-01</td>
                                <td>ソースコード管理</td>
                                <td>Gitリポジトリの管理権限は自社にあるか。退職者のアカウントが削除されているか。</td>
                                <td>GitHub Admin</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>OPS-02</td>
                                <td>デプロイフロー</td>
                                <td>CI/CDパイプラインによりテストとデプロイが自動化されているか。手動での本番変更が禁止されているか。</td>
                                <td>GitHub Actions</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>OPS-03</td>
                                <td>ドキュメント有無</td>
                                <td>システム構成図、ER図（DB設計図）、API仕様書が存在し、現状と一致しているか。</td>
                                <td>作成必須</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                            <tr>
                                <td>OPS-04</td>
                                <td>ベンダーSLA</td>
                                <td>ベンダーとの契約において、障害対応時間や稼働率の定義（SLA）が存在するか。</td>
                                <td>契約書確認</td>
                                <td><span class="badge badge-high">高</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="alert alert-info">
                    <strong>💡 監査の進め方</strong><br>
                    エンジニア不在の状況下では、「ブラックボックス監査」（外部から振る舞いを検証）と「ホワイトボックス監査」（内部設定やコードを確認）を組み合わせて実施します。ベンダーにレポート提出を依頼するか、第三者の技術顧問を一時的に雇用することを推奨します。
                </div>
            </div>

            <!-- BCP対策セクション -->
            <div id="bcp" class="section">
                <h2>🛡️ BCP（事業継続計画）とバックアップ・復旧体制</h2>

                <h3>RPO / RTO の定義</h3>
                <div class="card">
                    <div class="card-header">目標値設定</div>
                    <table>
                        <thead>
                            <tr>
                                <th>対象</th>
                                <th>RPO<br>(目標復旧時点)</th>
                                <th>RTO<br>(目標復旧時間)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>データベース</td>
                                <td>障害発生の5分前</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>画像データ</td>
                                <td>消失なし（完全保護）</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>Web表示復旧</td>
                                <td>-</td>
                                <td>1時間以内</td>
                            </tr>
                            <tr>
                                <td>完全機能復旧</td>
                                <td>-</td>
                                <td>4時間以内</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3>災害・障害シナリオと復旧戦略</h3>

                <div class="card">
                    <div class="card-header">🔴 シナリオA: データベースの論理破損・データ不整合</div>
                    <p><strong>リスク:</strong> アプリケーションのバグやオペレーションミスにより、顧客データが上書き・消失</p>
                    <p><strong>対策:</strong> Amazon RDS/Auroraの自動バックアップを有効化、保持期間を最大（35日）に設定</p>
                    <p><strong>復旧手順:</strong></p>
                    <ol>
                        <li>障害発生時刻を特定</li>
                        <li>直前の状態に新しいDBインスタンスを作成（Point-In-Time Recovery）</li>
                        <li>既存DBへの上書きではなく、新規作成してアプリの接続先を切り替え</li>
                    </ol>
                </div>

                <div class="card">
                    <div class="card-header">🟡 シナリオB: 画像データの誤削除・消失</div>
                    <p><strong>リスク:</strong> 運用ツールやバッチ処理のミスにより、S3上の車種画像が大量に削除</p>
                    <p><strong>対策:</strong> S3のバージョニング（Versioning）を必須化。MFA Delete（多要素認証削除）を有効化</p>
                    <p><strong>復旧手順:</strong></p>
                    <ol>
                        <li>削除マーカー（Delete Marker）が付与されたオブジェクトを特定</li>
                        <li>一括でマーカーを削除するスクリプトを実行</li>
                        <li>旧バージョンを正（Current）として復元</li>
                    </ol>
                </div>

                <div class="card">
                    <div class="card-header">🟠 シナリオC: AWSリージョン障害（大規模災害）</div>
                    <p><strong>リスク:</strong> 東京リージョン全体がダウンし、サービスが停止</p>
                    <p><strong>対策:</strong> クロスリージョンレプリケーションを検討。S3データやDBスナップショットを大阪リージョン等へ自動コピー</p>
                    <p><strong>復旧手順:</strong></p>
                    <ol>
                        <li>大阪リージョンでVapor環境をデプロイ</li>
                        <li>レプリケーションされたデータを用いてサービスを再開（Pilot Light方式）</li>
                    </ol>
                    <div class="alert alert-warning">
                        <strong>⚠️ コスト考慮:</strong> 最も堅牢だが、コストとの兼ね合いで導入判断が必要
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">🔵 シナリオD: ソースコード消失・ベンダーロックアウト</div>
                    <p><strong>リスク:</strong> GitHubアカウントの紛失、ベンダーによるアクセス拒否などでコード資産を喪失</p>
                    <p><strong>対策:</strong></p>
                    <ul>
                        <li>ソースコードの著作権帰属を契約で明確化</li>
                        <li>GitHubのOwner権限を自社で保持</li>
                        <li>定期的にリポジトリのバックアップを自社管理の別ストレージ（S3等）に保存</li>
                    </ul>
                </div>

                <h3>ドキュメント整備戦略</h3>
                <div class="card">
                    <div class="card-header">C4モデルによる階層的ドキュメント体系</div>
                    <ul>
                        <li><strong>Level 1: System Context Diagram（システムコンテキスト図）</strong><br>
                        対象: ビジネスサイド、経営層<br>
                        内容: 外車王・旧車王と外部システムの関係を1枚の図で表現</li>
                        
                        <li><strong>Level 2: Container Diagram（コンテナ図）</strong><br>
                        対象: ディレクター、開発リーダー<br>
                        内容: Laravel Vapor、Nuxt.js、RDS、S3等の技術選定と相互接続</li>
                        
                        <li><strong>Level 3: Component Diagram（コンポーネント図）</strong><br>
                        対象: 開発エンジニア<br>
                        内容: コントローラー、サービス、リポジトリ等の内部構造</li>
                        
                        <li><strong>Level 4: Code（コード）</strong><br>
                        対象: 開発エンジニア<br>
                        内容: クラス図やシーケンス図（自動生成推奨）</li>
                    </ul>
                </div>

                <div class="card">
                    <div class="card-header">Documentation as Code（自動化ツール）</div>
                    <ul>
                        <li><strong>API仕様書:</strong> Scribe / Scramble（Laravel）</li>
                        <li><strong>コンポーネントカタログ:</strong> Vue Styleguidist / Storybook（Nuxt/Vue）</li>
                        <li><strong>アーキテクチャ図:</strong> PlantUML / Mermaid.js</li>
                    </ul>
                    <div class="alert alert-success">
                        <strong>✅ メリット:</strong> コードから自動生成することで、ドキュメントの陳腐化を防止
                    </div>
                </div>
            </div>

            <!-- ロードマップセクション -->
            <div id="roadmap" class="section">
                <h2>🗺️ 課題解決ロードマップ（12ヶ月計画）</h2>

                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-title">Phase 1: 止血と可視化（1〜3ヶ月目）</div>
                        <p><strong>目標:</strong> 重大インシデントの撲滅と現状の完全把握</p>
                        <ul class="checklist">
                            <li>緊急システム監査の実施（Screaming Frog、Sentry/Flare導入）</li>
                            <li>Aikido Security導入による脆弱性スキャン</li>
                            <li>バックアップ設定の総点検（S3バージョニング、DB PITR確認）</li>
                            <li>ドキュメント作成開始（API仕様書自動生成、システム構成図Level 1-2）</li>
                        </ul>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-title">Phase 2: 安定化と体制構築（4〜6ヶ月目）</div>
                        <p><strong>目標:</strong> ベンダーコントロールの強化と運用フローの確立</p>
                        <ul class="checklist">
                            <li>ベンダーSLA（サービスレベル合意書）の締結</li>
                            <li>自動テストの拡充（PHPUnit、CI/CDへのセキュリティスキャン組み込み）</li>
                            <li>Quality Gateの設定（テストに通らないコードはデプロイ不可）</li>
                            <li>BCP訓練（実際のDBリストア演習）</li>
                        </ul>
                    </div>

                    <div class="timeline-item">
                        <div class="timeline-title">Phase 3: 恒久対策と最適化（7〜12ヶ月目）</div>
                        <p><strong>目標:</strong> 技術的負債の解消と攻めのITへの転換</p>
                        <ul class="checklist">
                            <li>レガシーコードのリファクタリング</li>
                            <li>Laravel/Nuxtのバージョンアップ対応</li>
                            <li>アーキテクチャの見直し（長時間バッチのECS移行等）</li>
                            <li>Nuxtレンダリング戦略の最適化（SSG検討）</li>
                            <li>内製化の検討（CTO候補/技術顧問の招聘）</li>
                        </ul>
                    </div>
                </div>

                <div class="alert alert-success">
                    <strong>🎯 成功のカギ</strong><br>
                    各フェーズで確実に成果を積み上げることで、システムの健全性を段階的に向上させます。焦らず、着実に進めることが重要です。
                </div>
            </div>

            <!-- ベンダー管理セクション -->
            <div id="vendor" class="section">
                <h2>🤝 ベンダーマネジメント戦略</h2>

                <div class="alert alert-warning">
                    <strong>💡 重要な認識</strong><br>
                    エンジニア不在の状況で最も重要なのは、「外部リソースをどう管理するか」です。技術的な詳細が分からなくても、管理の主導権を握ることは可能です。
                </div>

                <h3>4つの管理原則</h3>

                <div class="card">
                    <div class="card-header">1️⃣ 透明性の確保</div>
                    <p>「やったこと」の口頭報告だけでなく、改ざん不可能なシステムログを定例報告のエビデンスとして要求する。</p>
                    <ul>
                        <li>GitHubのコミットログ</li>
                        <li>CI/CDの実行結果</li>
                        <li>Sentryのエラーログ</li>
                        <li>Security Hubのスコア推移</li>
                    </ul>
                </div>

                <div class="card">
                    <div class="card-header">2️⃣ ソースコード所有権の明確化</div>
                    <p>契約書において、以下を明記する:</p>
                    <ul>
                        <li>成果物（ソースコード、ドキュメント）の著作権が自社に帰属すること</li>
                        <li>開発終了時・途中解約時の引き継ぎ義務</li>
                        <li>OSSライブラリ利用に関するコンプライアンス条項</li>
                    </ul>
                    <div class="alert alert-info">
                        <strong>📋 法的根拠:</strong> 日本の著作権法第15条第2項（職務著作）。委託契約の場合は特約が必要。
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">3️⃣ ロックイン回避</div>
                    <p>使用しているSaaSやクラウドのアカウントは、必ず自社が契約主体となる。</p>
                    <ul>
                        <li>AWS root account</li>
                        <li>GitHub Owner権限</li>
                        <li>SendGrid等の外部サービス</li>
                    </ul>
                    <p>ベンダーには「管理者権限を持ったユーザー」を払い出す形にすることで、トラブル時にアカウントを停止し、システム資産を保護できる。</p>
                </div>

                <div class="card">
                    <div class="card-header">4️⃣ 定例会の質の転換</div>
                    <p>単なる進捗報告の場ではなく、データドリブンな議論の場に変える。</p>
                    <p><strong>画面共有しながら確認すべき項目:</strong></p>
                    <ul>
                        <li>Sentryダッシュボード: 今週発生したエラーの件数と原因</li>
                        <li>Security Hub: 未解決の脆弱性と対応計画</li>
                        <li>GitHub Insights: コミット状況とレビュー品質</li>
                        <li>Performance Metrics: ページ速度とCore Web Vitals</li>
                    </ul>
                </div>

                <h3>SLA（サービスレベル合意）に含めるべきKPI</h3>
                <table>
                    <thead>
                        <tr>
                            <th>KPI項目</th>
                            <th>目標値</th>
                            <th>測定方法</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>稼働率</td>
                            <td>99.9%以上</td>
                            <td>AWS CloudWatch監視</td>
                        </tr>
                        <tr>
                            <td>レベル3障害対応時間</td>
                            <td>24時間以内</td>
                            <td>インシデント管理記録</td>
                        </tr>
                        <tr>
                            <td>バグ混入率</td>
                            <td>月5件以下</td>
                            <td>Sentryエラーログ</td>
                        </tr>
                        <tr>
                            <td>脆弱性対応</td>
                            <td>Critical: 3日以内<br>High: 7日以内</td>
                            <td>Aikido Securityレポート</td>
                        </tr>
                        <tr>
                            <td>コードカバレッジ</td>
                            <td>70%以上</td>
                            <td>PHPUnit/Jest</td>
                        </tr>
                    </tbody>
                </table>

                <div class="alert alert-success">
                    <strong>✅ ベンダー管理のゴール</strong><br>
                    感覚的な不満から数値に基づく改善要求へと会話を変え、ディレクターが主導権を取り戻すことが第一歩です。
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>戦略的システム監査および事業継続性強化計画書</strong></p>
            <p>外車王・旧車王 Webプラットフォーム</p>
            <p style="margin-top: 20px; font-size: 0.9em;">
                本レポートは、システムの健全化とビジネスの持続的成長を支援するための包括的な指針を提供します。<br>
                不明点がある場合は、技術顧問やセキュリティ専門家にご相談ください。
            </p>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // すべてのセクションを非表示
            const sections = document.querySelectorAll('.section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // すべてのタブの active クラスを削除
            const tabs = document.querySelectorAll('.nav-tab');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });

            // 選択されたセクションを表示
            document.getElementById(sectionId).classList.add('active');

            // 選択されたタブに active クラスを追加
            event.target.classList.add('active');

            // ページトップへスクロール
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function toggleCollapse(element) {
            element.classList.toggle('collapsed');
            const content = element.nextElementSibling;
            content.classList.toggle('collapsed');
        }

        // ページ読み込み時のアニメーション
        document.addEventListener('DOMContentLoaded', function() {
            // テーブル行のホバーエフェクト強化
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.01)';
                    this.style.transition = 'all 0.2s';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // スムーズスクロール
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>