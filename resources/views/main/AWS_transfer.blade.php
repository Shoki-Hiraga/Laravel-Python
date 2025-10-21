</div>

        <div class="footer">
            <p>© 2025 AWSコスト最適化レポート | 本レポートは包括的な分析に基づく戦略的提言です</p>
            <p style="margin-top: 10px; font-size: 0.9em;">最終更新: 2025年10月20日</p>
        </div>
    </div>

    <script>
        // セクション切り替え機能
        function showSection(sectionId) {
            // すべてのセクションを非表示
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // すべてのタブから active クラスを削除
            document.querySelectorAll('.nav-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // 選択されたセクションを表示
            document.getElementById(sectionId).classList.add('active');
            
            // クリックされたタブに active クラスを追加
            event.target.classList.add('active');
            
            // スムーズスクロール
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // コスト内訳のグラフを描画
        function drawCostBreakdown() {
            const canvas = document.createElement('canvas');
            canvas.id = 'costChart';
            canvas.width = 800;
            canvas.height = 400;
            document.getElementById('costBreakdown').appendChild(canvas);
            
            const ctx = canvas.getContext('2d');
            const data = [
                { label: 'RDS', value: 786339, color: '#667eea', percent: 46 },
                { label: 'CloudFront', value: 416883, color: '#764ba2', percent: 24 },
                { label: 'Lambda', value: 137649, color: '#f093fb', percent: 8 },
                { label: 'EC2', value: 118440, color: '#4facfe', percent: 7 },
                { label: 'その他', value: 254133, color: '#43e97b', percent: 15 }
            ];
            
            // 円グラフの描画
            let startAngle = -Math.PI / 2;
            const centerX = 250;
            const centerY = 200;
            const radius = 150;
            
            data.forEach((item, index) => {
                const sliceAngle = (item.percent / 100) * 2 * Math.PI;
                
                // スライスを描画
                ctx.beginPath();
                ctx.moveTo(centerX, centerY);
                ctx.arc(centerX, centerY, radius, startAngle, startAngle + sliceAngle);
                ctx.closePath();
                ctx.fillStyle = item.color;
                ctx.fill();
                ctx.strokeStyle = '#fff';
                ctx.lineWidth = 3;
                ctx.stroke();
                
                startAngle += sliceAngle;
            });
            
            // 凡例を描画
            let legendY = 50;
            data.forEach((item, index) => {
                const legendX = 550;
                
                // カラーボックス
                ctx.fillStyle = item.color;
                ctx.fillRect(legendX, legendY, 30, 30);
                ctx.strokeStyle = '#333';
                ctx.lineWidth = 1;
                ctx.strokeRect(legendX, legendY, 30, 30);
                
                // テキスト
                ctx.fillStyle = '#333';
                ctx.font = 'bold 16px sans-serif';
                ctx.fillText(item.label, legendX + 40, legendY + 20);
                
                ctx.font = '14px sans-serif';
                ctx.fillText(`¥${item.value.toLocaleString()}`, legendX + 40, legendY + 38);
                ctx.fillText(`(${item.percent}%)`, legendX + 40, legendY + 54);
                
                legendY += 70;
            });
            
            // タイトル
            ctx.fillStyle = '#333';
            ctx.font = 'bold 18px sans-serif';
            ctx.fillText('6ヶ月間のコスト内訳', 50, 30);
        }

        // 年間コスト比較グラフを描画
        function drawAnnualCostComparison() {
            const canvas = document.createElement('canvas');
            canvas.id = 'annualChart';
            canvas.width = 1000;
            canvas.height = 500;
            document.getElementById('annualCostComparison').appendChild(canvas);
            
            const ctx = canvas.getContext('2d');
            const data = [
                { label: '現状維持', cost: 3426888, color: '#f44336' },
                { label: 'AWS最適化', cost: 690000, color: '#4caf50' },
                { label: 'GCP移行', cost: 840000, color: '#2196f3' },
                { label: 'Azure移行', cost: 840000, color: '#00bcd4' },
                { label: 'さくらAppRun', cost: 600000, color: '#ff9800' }
            ];
            
            const maxCost = Math.max(...data.map(d => d.cost));
            const chartHeight = 350;
            const barWidth = 150;
            const spacing = 30;
            const startX = 50;
            const startY = 400;
            
            data.forEach((item, index) => {
                const barHeight = (item.cost / maxCost) * chartHeight;
                const x = startX + (barWidth + spacing) * index;
                const y = startY - barHeight;
                
                // バーを描画
                ctx.fillStyle = item.color;
                ctx.fillRect(x, y, barWidth, barHeight);
                ctx.strokeStyle = '#333';
                ctx.lineWidth = 2;
                ctx.strokeRect(x, y, barWidth, barHeight);
                
                // 金額を表示
                ctx.fillStyle = '#333';
                ctx.font = 'bold 14px sans-serif';
                ctx.textAlign = 'center';
                ctx.fillText(`¥${(item.cost / 10000).toFixed(0)}万`, x + barWidth / 2, y - 10);
                
                // ラベルを表示
                ctx.font = '12px sans-serif';
                ctx.save();
                ctx.translate(x + barWidth / 2, startY + 20);
                ctx.rotate(-Math.PI / 6);
                ctx.fillText(item.label, 0, 0);
                ctx.restore();
            });
            
            // Y軸ラベル
            ctx.textAlign = 'right';
            ctx.font = '12px sans-serif';
            for (let i = 0; i <= 5; i++) {
                const value = (maxCost / 5) * i;
                const y = startY - (chartHeight / 5) * i;
                ctx.fillText(`¥${(value / 10000).toFixed(0)}万`, startX - 10, y + 5);
                
                // グリッド線
                ctx.strokeStyle = '#e0e0e0';
                ctx.lineWidth = 1;
                ctx.beginPath();
                ctx.moveTo(startX, y);
                ctx.lineTo(startX + (barWidth + spacing) * data.length - spacing, y);
                ctx.stroke();
            }
            
            // タイトル
            ctx.fillStyle = '#333';
            ctx.font = 'bold 18px sans-serif';
            ctx.textAlign = 'center';
            ctx.fillText('年間運用コスト比較', 500, 30);
            
            // 削減額を表示
            const savings = data[0].cost - data[1].cost;
            ctx.fillStyle = '#4caf50';
            ctx.font = 'bold 16px sans-serif';
            ctx.fillText(`AWS最適化による年間削減額: ¥${(savings / 10000).toFixed(0)}万円`, 500, 470);
        }

        // ページ読み込み時にグラフを描画
        window.addEventListener('DOMContentLoaded', function() {
            drawCostBreakdown();
            
            // 比較分析タブがアクティブになったときにグラフを描画
            const comparisonTab = document.querySelector('[onclick*="comparison"]');
            if (comparisonTab) {
                comparisonTab.addEventListener('click', function() {
                    setTimeout(() => {
                        const chartContainer = document.getElementById('annualCostComparison');
                        if (chartContainer && !chartContainer.querySelector('canvas')) {
                            drawAnnualCostComparison();
                        }
                    }, 100);
                });
            }
        });

        // 印刷用のスタイル調整
        window.addEventListener('beforeprint', function() {
            document.querySelectorAll('.content-section').forEach(section => {
                section.style.display = 'block';
                section.style.pageBreakBefore = 'always';
            });
        });

        window.addEventListener('afterprint', function() {
            document.querySelectorAll('.content-section').forEach(section => {
                if (!section.classList.contains('active')) {
                    section.style.display = 'none';
                }
            });
        });

        // スムーズスクロール
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // データエクスポート機能
        function exportData() {
            const data = {
                currentCosts: {
                    total: 1713444,
                    monthly: 285574,
                    rds: 786339,
                    cloudfront: 416883,
                    lambda: 137649,
                    ec2: 118440,
                    others: 254133
                },
                optimizedCosts: {
                    pathA: {
                        monthly: 57500,
                        annual: 690000,
                        savings: 228074,
                        savingsPercent: 79.9
                    },
                    pathB_GCP: {
                        monthly: 70000,
                        annual: 840000,
                        migrationCost: 2000000
                    },
                    pathB_Azure: {
                        monthly: 70000,
                        annual: 840000,
                        migrationCost: 2000000
                    },
                    pathC_Sakura: {
                        monthly: 50000,
                        annual: 600000,
                        migrationCost: 1500000
                    }
                },
                recommendations: {
                    immediate: 'Path A - AWS Optimization',
                    poc: ['GCP Cloud Run', 'Sakura AppRun'],
                    timeline: '3-12 months'
                }
            };
            
            const jsonStr = JSON.stringify(data, null, 2);
            const blob = new Blob([jsonStr], { type: 'application/json' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'aws_cost_analysis_data.json';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        // キーボードショートカット
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 'p':
                        e.preventDefault();
                        window.print();
                        break;
                    case 's':
                        e.preventDefault();
                        exportData();
                        break;
                }
            }
            
            // 矢印キーでセクション移動
            if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
                const tabs = Array.from(document.querySelectorAll('.nav-tab'));
                const activeTab = document.querySelector('.nav-tab.active');
                const currentIndex = tabs.indexOf(activeTab);
                
                let newIndex;
                if (e.key === 'ArrowRight') {
                    newIndex = (currentIndex + 1) % tabs.length;
                } else {
                    newIndex = (currentIndex - 1 + tabs.length) % tabs.length;
                }
                
                tabs[newIndex].click();
            }
        });

        // ツールチップ機能
        document.querySelectorAll('.metric, .badge').forEach(element => {
            element.style.cursor = 'help';
            element.title = '詳細情報については該当セクションをご参照ください';
        });

        // プログレスインジケーター
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('.content-section.active');
            if (sections.length > 0) {
                const section = sections[0];
                const rect = section.getBoundingClientRect();
                const progress = Math.max(0, Math.min(100, ((window.innerHeight - rect.top) / rect.height) * 100));
                
                // プログレスバーがあれば更新（オプション）
                const progressBar = document.getElementById('readProgress');
                if (progressBar) {
                    progressBar.style.width = progress + '%';
                }
            }
        });

        // アニメーション効果
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // 要素の監視
        document.querySelectorAll('.cost-card, .comparison-item, table').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        console.log('AWSコスト最適化レポート - 読み込み完了');
        console.log('キーボードショートカット:');
        console.log('- Ctrl/Cmd + P: 印刷');
        console.log('- Ctrl/Cmd + S: データエクスポート');
        console.log('- 矢印キー左右: セクション移動');
    </script>
</body>
</html><!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWSインフラコスト最適化レポート</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', 'Hiragino Sans', 'Yu Gothic', sans-serif;
            line-height: 1.7;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        h1 {
            color: #667eea;
            font-size: 2.5em;
            margin-bottom: 15px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #666;
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .nav-tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            position: -webkit-sticky; /* Safari対応 */
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-tab {
            padding: 12px 24px;
            background: #f5f5f5;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }

        .nav-tab:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .nav-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .content-section {
            display: none;
            background: white;
            border-radius: 15px;
            padding: 40px;
            margin-bottom: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            animation: fadeIn 0.5s;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        h3 {
            color: #764ba2;
            font-size: 1.5em;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .highlight-box {
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 8px;
        }

        .cost-card {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
            transition: all 0.3s;
        }

        .cost-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
            transform: translateY(-3px);
        }

        .chart-container {
            margin: 30px 0;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
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
            border-bottom: 1px solid #e0e0e0;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .metric {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            margin: 5px;
            font-weight: 600;
        }

        .recommendation {
            background: #4caf50;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .warning {
            background: #ff9800;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .comparison-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .comparison-item {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s;
        }

        .comparison-item:hover {
            border-color: #667eea;
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
        }

        .comparison-item h4 {
            color: #667eea;
            margin-bottom: 10px;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
            margin: 3px;
        }

        .badge-high { background: #4caf50; color: white; }
        .badge-medium { background: #ff9800; color: white; }
        .badge-low { background: #f44336; color: white; }

        ul, ol {
            margin-left: 25px;
            margin-top: 10px;
        }

        li {
            margin: 8px 0;
        }

        .footer {
            text-align: center;
            color: white;
            padding: 20px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            h1 { font-size: 1.8em; }
            h2 { font-size: 1.5em; }
            .nav-tabs { flex-direction: column; }
            .nav-tab { width: 100%; }
            table { font-size: 0.9em; }
            th, td { padding: 10px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📊 AWSインフラコスト最適化と移行戦略</h1>
            <p class="subtitle">包括的分析レポート</p>
        </header>

        <nav class="nav-tabs">
            <button class="nav-tab active" onclick="showSection('summary')">サマリー</button>
            <button class="nav-tab" onclick="showSection('analysis')">現状分析</button>
            <button class="nav-tab" onclick="showSection('pathA')">経路A：AWS最適化</button>
            <button class="nav-tab" onclick="showSection('pathB')">経路B：ハイパースケーラー</button>
            <button class="nav-tab" onclick="showSection('pathC')">経路C：国内プロバイダー</button>
            <button class="nav-tab" onclick="showSection('comparison')">比較分析</button>
            <button class="nav-tab" onclick="showSection('recommendation')">最終提言</button>
        </nav>

        <!-- エグゼクティブサマリー -->
        <div id="summary" class="content-section active">
            <h2>🎯 エグゼクティブサマリー</h2>
            
            <div class="highlight-box">
                <h3>主要な発見事項</h3>
                <p><strong>現状のAWS利用料は実際のワークロードに対して不釣り合いに高額です。</strong></p>
                <p>6ヶ月間の総支出：<span class="metric">¥1,713,444</span></p>
                <p>月額平均：<span class="metric">¥285,574</span></p>
            </div>

            <h3>💰 コスト内訳（6ヶ月間）</h3>
            <div class="chart-container" id="costBreakdown"></div>

            <div class="comparison-grid">
                <div class="comparison-item">
                    <h4>経路A：AWS最適化</h4>
                    <p><span class="badge badge-high">推奨度：最高</span></p>
                    <p><span class="badge badge-high">削減率：50-70%</span></p>
                    <p><strong>推定月額コスト：¥57,500</strong></p>
                    <p>リスク：低 | 実装期間：3ヶ月</p>
                </div>

                <div class="comparison-item">
                    <h4>経路B：ハイパースケーラー</h4>
                    <p><span class="badge badge-medium">推奨度：中</span></p>
                    <p><span class="badge badge-high">削減率：40-60%</span></p>
                    <p><strong>GCP/Azure移行</strong></p>
                    <p>リスク：中 | 実装期間：6-12ヶ月</p>
                </div>

                <div class="comparison-item">
                    <h4>経路C：国内プロバイダー</h4>
                    <p><span class="badge badge-medium">推奨度：中</span></p>
                    <p><span class="badge badge-high">削減率：最大70%+</span></p>
                    <p><strong>さくらインターネットAppRun</strong></p>
                    <p>リスク：高 | 実装期間：6-12ヶ月</p>
                </div>
            </div>

            <div class="recommendation">
                <h3>🎯 推奨アクション</h3>
                <ol>
                    <li><strong>即座に実行：</strong>経路Aの最適化を3ヶ月以内に完了</li>
                    <li><strong>並行実施：</strong>GCPとさくらインターネットでPoCを開始</li>
                    <li><strong>長期判断：</strong>PoC結果に基づき6-12ヶ月後に最終決定</li>
                </ol>
            </div>
        </div>

        <!-- 現状分析 -->
        <div id="analysis" class="content-section">
            <h2>📈 現行AWSインフラとコスト構造の分析</h2>

            <h3>1. 支出内訳の詳細</h3>
            <table>
                <thead>
                    <tr>
                        <th>サービス</th>
                        <th>6ヶ月間の費用</th>
                        <th>全体比率</th>
                        <th>月額平均</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>RDS (Aurora Serverless v2)</strong></td>
                        <td>¥786,339</td>
                        <td>46%</td>
                        <td>¥131,057</td>
                    </tr>
                    <tr>
                        <td><strong>CloudFront</strong></td>
                        <td>¥416,883</td>
                        <td>24%</td>
                        <td>¥69,481</td>
                    </tr>
                    <tr>
                        <td><strong>Lambda</strong></td>
                        <td>¥137,649</td>
                        <td>8%</td>
                        <td>¥22,942</td>
                    </tr>
                    <tr>
                        <td><strong>EC2</strong></td>
                        <td>¥118,440</td>
                        <td>7%</td>
                        <td>¥19,740</td>
                    </tr>
                    <tr>
                        <td>その他（WAF, API Gateway, S3等）</td>
                        <td>¥254,133</td>
                        <td>15%</td>
                        <td>¥42,355</td>
                    </tr>
                </tbody>
            </table>

            <div class="warning">
                <h3>⚠️ 重要な発見：アーキテクチャのミスマッチ</h3>
                <p><strong>Aurora Serverless v2は貴社のワークロードに適していません</strong></p>
                <ul>
                    <li>平均ACU使用量が非常に低い（0.5-3 ACU）</li>
                    <li>負荷が安定しており、スケーリング機能が活用されていない</li>
                    <li>活用していない機能に対してプレミアム料金を支払っている状態</li>
                </ul>
            </div>

            <h3>2. データベース利用状況</h3>
            <div class="cost-card">
                <h4>gai-production-mysql8</h4>
                <p>平均ACU数：<span class="metric">2.84</span></p>
                <p>相当メモリ：約5.68 GB</p>
            </div>

            <div class="cost-card">
                <h4>qsh-production-mysql8</h4>
                <p>平均ACU数：<span class="metric">0.57</span></p>
                <p>相当メモリ：約1.14 GB</p>
            </div>

            <div class="cost-card">
                <h4>marketprice-production-mysql8</h4>
                <p>平均ACU数：<span class="metric">0.54</span></p>
                <p>相当メモリ：約1.08 GB</p>
            </div>

            <h3>3. Lambda利用プロファイル</h3>
            <div class="highlight-box">
                <p>1日平均実行回数：<span class="metric">162,445回</span></p>
                <p>平均実行時間：<span class="metric">742ms</span></p>
                <p>月間リクエスト数：<span class="metric">約487万回</span></p>
                <p>このパターンは、アーキテクチャ最適化により大きなコスト削減が期待できます。</p>
            </div>
        </div>

        <!-- 経路A -->
        <div id="pathA" class="content-section">
            <h2>🚀 経路A：AWS内での戦略的コスト最適化</h2>

            <div class="recommendation">
                <h3>✅ 最優先推奨アプローチ</h3>
                <p><strong>低リスク・高リターン・即効性あり</strong></p>
            </div>

            <h3>1. データベース最適化戦略</h3>
            <div class="highlight-box">
                <h4>Aurora Serverless v2 → プロビジョニング済みインスタンスへ移行</h4>
                <table>
                    <thead>
                        <tr>
                            <th>クラスタ</th>
                            <th>推奨インスタンス</th>
                            <th>スペック</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>gai-production</td>
                            <td>db.t4g.large</td>
                            <td>2 vCPU, 8 GiB</td>
                        </tr>
                        <tr>
                            <td>qsh-production</td>
                            <td>db.t4g.medium</td>
                            <td>2 vCPU, 4 GiB</td>
                        </tr>
                        <tr>
                            <td>marketprice-production</td>
                            <td>db.t4g.medium</td>
                            <td>2 vCPU, 4 GiB</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>2. RDSリザーブドインスタンス適用効果</h3>
            <table>
                <thead>
                    <tr>
                        <th>シナリオ</th>
                        <th>構成</th>
                        <th>オンデマンド月額</th>
                        <th>1年RI月額</th>
                        <th>3年RI月額</th>
                        <th>削減率</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>現状</td>
                        <td>Aurora Serverless v2</td>
                        <td>¥131,057</td>
                        <td>-</td>
                        <td>-</td>
                        <td>0%</td>
                    </tr>
                    <tr style="background: #e8f5e9;">
                        <td><strong>最適化案</strong></td>
                        <td>db.t4g (large×1, medium×2)</td>
                        <td>¥24,500</td>
                        <td>¥17,500</td>
                        <td><strong>¥12,000</strong></td>
                        <td><strong>約91%</strong></td>
                    </tr>
                </tbody>
            </table>

            <h3>3. Lambda最適化戦略</h3>
            <div class="comparison-grid">
                <div class="comparison-item">
                    <h4>Graviton2への移行</h4>
                    <p>x86からArm64アーキテクチャへ変更</p>
                    <ul>
                        <li>最大19%のパフォーマンス向上</li>
                        <li>20%のコスト削減</li>
                        <li>設定変更のみで実装可能</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>メモリ適正化</h4>
                    <p>AWS Lambda Power Tuning活用</p>
                    <ul>
                        <li>最適なメモリ量を自動提案</li>
                        <li>コストとパフォーマンスのバランス</li>
                        <li>追加の10-30%削減可能</li>
                    </ul>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>アーキテクチャ</th>
                        <th>月間リクエスト</th>
                        <th>コンピュート料金</th>
                        <th>合計月額</th>
                        <th>削減率</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>現状 (x86)</td>
                        <td>4,873,350</td>
                        <td>¥5,500</td>
                        <td>¥5,665</td>
                        <td>-</td>
                    </tr>
                    <tr style="background: #e8f5e9;">
                        <td><strong>Graviton2 (Arm)</strong></td>
                        <td>4,873,350</td>
                        <td>¥4,400</td>
                        <td><strong>¥4,565</strong></td>
                        <td><strong>約20%</strong></td>
                    </tr>
                </tbody>
            </table>

            <h3>4. 総合的なコスト削減効果</h3>
            <div class="highlight-box" style="background: linear-gradient(135deg, #4caf5015 0%, #8bc34a15 100%); border-left-color: #4caf50;">
                <h4>最適化後の予測月額コスト</h4>
                <p style="font-size: 1.5em; font-weight: bold; color: #4caf50;">¥57,500</p>
                <p>現状比較：<strong>¥137,434の削減（約70%減）</strong></p>
                <p>年間削減額：<strong>約¥1,649,208</strong></p>
            </div>

            <div class="recommendation">
                <h3>📋 実装タイムライン</h3>
                <ol>
                    <li><strong>Week 1-2:</strong> RDSインスタンス選定と3年RIの購入</li>
                    <li><strong>Week 3-4:</strong> データベース移行計画の策定</li>
                    <li><strong>Week 5-8:</strong> ステージング環境での検証とカットオーバー</li>
                    <li><strong>Week 9-10:</strong> Lambda Graviton2移行とメモリ最適化</li>
                    <li><strong>Week 11-12:</strong> モニタリングと最終調整</li>
                </ol>
            </div>
        </div>

        <!-- 経路B -->
        <div id="pathB" class="content-section">
            <h2>☁️ 経路B：ハイパースケーラー競合への移行</h2>

            <h3>1. サービスマッピング</h3>
            <table>
                <thead>
                    <tr>
                        <th>カテゴリ</th>
                        <th>AWS</th>
                        <th>GCP</th>
                        <th>Azure</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>コンテナ実行</td>
                        <td>ECS</td>
                        <td>Cloud Run / GKE</td>
                        <td>Container Apps / AKS</td>
                    </tr>
                    <tr>
                        <td>サーバレス関数</td>
                        <td>Lambda</td>
                        <td>Cloud Functions</td>
                        <td>Azure Functions</td>
                    </tr>
                    <tr>
                        <td>リレーショナルDB</td>
                        <td>RDS (MySQL)</td>
                        <td>Cloud SQL</td>
                        <td>Azure Database</td>
                    </tr>
                    <tr>
                        <td>CDN</td>
                        <td>CloudFront</td>
                        <td>Cloud CDN</td>
                        <td>Azure CDN</td>
                    </tr>
                    <tr>
                        <td>WAF</td>
                        <td>AWS WAF</td>
                        <td>Cloud Armor</td>
                        <td>Application Gateway WAF</td>
                    </tr>
                </tbody>
            </table>

            <h3>2. Google Cloud Platform (GCP)</h3>
            <div class="comparison-grid">
                <div class="comparison-item">
                    <h4>🎯 主要な強み</h4>
                    <ul>
                        <li>Cloud Runのシンプルさ</li>
                        <li>「ソースコードからURLへ」体験</li>
                        <li>継続利用割引（自動適用）</li>
                        <li>開発者体験の優れたUX</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>💰 コスト特性</h4>
                    <ul>
                        <li>Cloud Run: スケールトゥゼロ対応</li>
                        <li>実際の使用時間のみ課金</li>
                        <li>リザーブ不要の自動割引</li>
                        <li>透明性の高い料金体系</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>⚙️ 推奨構成</h4>
                    <ul>
                        <li>Cloud Run（コンテナ実行）</li>
                        <li>Cloud SQL for MySQL</li>
                        <li>Cloud CDN</li>
                        <li>Cloud Armor（WAF）</li>
                    </ul>
                </div>
            </div>

            <h3>3. Microsoft Azure</h3>
            <div class="comparison-grid">
                <div class="comparison-item">
                    <h4>🎯 主要な強み</h4>
                    <ul>
                        <li>Container Apps + KEDA統合</li>
                        <li>Daprによるマイクロサービス対応</li>
                        <li>エンタープライズ親和性</li>
                        <li>高度なイベント駆動対応</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>💰 コスト特性</h4>
                    <ul>
                        <li>Azure予約による割引</li>
                        <li>柔軟なプランオプション</li>
                        <li>包括的な価格計算ツール</li>
                        <li>長期契約での大幅割引</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>⚙️ 推奨構成</h4>
                    <ul>
                        <li>Azure Container Apps</li>
                        <li>Azure Database for MySQL</li>
                        <li>Azure CDN</li>
                        <li>Application Gateway WAF</li>
                    </ul>
                </div>
            </div>

            <div class="highlight-box">
                <h3>🤔 GCP vs Azure：選択の指針</h3>
                <p><strong>GCPを選ぶべき場合：</strong></p>
                <ul>
                    <li>開発の簡便性とスピードを最優先したい</li>
                    <li>シンプルなアーキテクチャで十分</li>
                    <li>Kubernetesの深い知識が不要</li>
                </ul>
                <p><strong>Azureを選ぶべき場合：</strong></p>
                <ul>
                    <li>将来的に複雑なマイクロサービスへ拡張予定</li>
                    <li>イベント駆動アーキテクチャが重要</li>
                    <li>Microsoft製品との統合が必要</li>
                </ul>
            </div>

            <div class="warning">
                <h3>⚠️ 移行時の考慮事項</h3>
                <ul>
                    <li>移行期間中の一時的なコスト増加</li>
                    <li>チームの学習コストと時間</li>
                    <li>データ移行とダウンタイム計画</li>
                    <li>新プラットフォームのツールチェーン整備</li>
                </ul>
            </div>
        </div>

        <!-- 比較分析 -->
        <div id="comparison" class="content-section">
            <h2>📊 比較分析と戦略的意思決定</h2>

            <h3>1. 戦略的意思決定マトリクス</h3>
            <table>
                <thead>
                    <tr>
                        <th>評価基準</th>
                        <th>経路A<br>AWS最適化</th>
                        <th>経路B<br>GCP</th>
                        <th>経路B<br>Azure</th>
                        <th>経路C<br>さくらAppRun</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>推定月額コスト</strong></td>
                        <td style="background: #c8e6c9;">¥57,500<br><span class="badge badge-high">低</span></td>
                        <td>¥60,000-80,000<br><span class="badge badge-medium">低〜中</span></td>
                        <td>¥60,000-80,000<br><span class="badge badge-medium">低〜中</span></td>
                        <td style="background: #c8e6c9;">¥40,000-60,000<br><span class="badge badge-high">最低</span></td>
                    </tr>
                    <tr>
                        <td><strong>推定削減率</strong></td>
                        <td style="background: #c8e6c9;"><strong>50-70%</strong></td>
                        <td>40-60%</td>
                        <td>40-60%</td>
                        <td style="background: #c8e6c9;"><strong>60-80%</strong></td>
                    </tr>
                    <tr>
                        <td><strong>移行リスク</strong></td>
                        <td style="background: #c8e6c9;"><span class="badge badge-high">低</span></td>
                        <td><span class="badge badge-medium">中</span></td>
                        <td><span class="badge badge-medium">中</span></td>
                        <td><span class="badge badge-low">高</span></td>
                    </tr>
                    <tr>
                        <td><strong>実装期間</strong></td>
                        <td style="background: #c8e6c9;"><strong>3ヶ月</strong></td>
                        <td>6-12ヶ月</td>
                        <td>6-12ヶ月</td>
                        <td>6-12ヶ月</td>
                    </tr>
                    <tr>
                        <td><strong>将来スケーラビリティ</strong></td>
                        <td><span class="badge badge-high">高</span></td>
                        <td><span class="badge badge-high">高</span></td>
                        <td style="background: #e8eaf6;"><span class="badge badge-high">非常に高</span></td>
                        <td><span class="badge badge-medium">中〜高</span></td>
                    </tr>
                    <tr>
                        <td><strong>セキュリティ</strong></td>
                        <td><span class="badge badge-high">高</span></td>
                        <td><span class="badge badge-high">高</span></td>
                        <td><span class="badge badge-high">高</span></td>
                        <td><span class="badge badge-medium">中</span></td>
                    </tr>
                    <tr>
                        <td><strong>国内サポート</strong></td>
                        <td><span class="badge badge-high">高</span></td>
                        <td><span class="badge badge-medium">中</span></td>
                        <td><span class="badge badge-medium">中</span></td>
                        <td style="background: #e8eaf6;"><span class="badge badge-high">非常に高</span></td>
                    </tr>
                    <tr>
                        <td><strong>総合推奨度</strong></td>
                        <td style="background: #4caf50; color: white;"><strong>★★★★★</strong><br>即時実行推奨</td>
                        <td><strong>★★★☆☆</strong><br>PoC推奨</td>
                        <td><strong>★★★☆☆</strong><br>長期的選択肢</td>
                        <td><strong>★★★★☆</strong><br>PoC推奨</td>
                    </tr>
                </tbody>
            </table>

            <h3>2. トレードオフ分析</h3>

            <div class="comparison-grid">
                <div class="comparison-item" style="border-color: #4caf50;">
                    <h4>経路A：AWS最適化</h4>
                    <p><strong>利点：</strong></p>
                    <ul>
                        <li>最短で価値実現</li>
                        <li>移行リスクゼロ</li>
                        <li>学習コスト最小</li>
                        <li>即座の大幅削減</li>
                    </ul>
                    <p><strong>トレードオフ：</strong></p>
                    <ul>
                        <li>他プラットフォームの利点を先送り</li>
                        <li>ベンダーロックイン継続</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>経路B：ハイパースケーラー</h4>
                    <p><strong>利点：</strong></p>
                    <ul>
                        <li>ベストオブブリード選択</li>
                        <li>価格交渉力の獲得</li>
                        <li>より優れたDX可能性</li>
                        <li>最新技術へのアクセス</li>
                    </ul>
                    <p><strong>トレードオフ：</strong></p>
                    <ul>
                        <li>移行コストと時間</li>
                        <li>チームの学習コスト</li>
                        <li>一時的な不安定性</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>経路C：国内プロバイダー</h4>
                    <p><strong>利点：</strong></p>
                    <ul>
                        <li>最低TCO可能性</li>
                        <li>完全日本語サポート</li>
                        <li>円建て安定価格</li>
                        <li>データ転送料無料</li>
                    </ul>
                    <p><strong>トレードオフ：</strong></p>
                    <ul>
                        <li>最高の技術リスク</li>
                        <li>機能制限の可能性</li>
                        <li>エコシステム限定</li>
                    </ul>
                </div>
            </div>

            <h3>3. 年間コスト予測比較</h3>
            <div class="chart-container" id="annualCostComparison"></div>

            <div class="highlight-box">
                <h3>💰 3年間の累積コスト予測</h3>
                <table>
                    <thead>
                        <tr>
                            <th>シナリオ</th>
                            <th>初期移行コスト</th>
                            <th>年間運用コスト</th>
                            <th>3年間総コスト</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>現状維持（最適化なし）</td>
                            <td>¥0</td>
                            <td>¥3,426,888</td>
                            <td>¥10,280,664</td>
                        </tr>
                        <tr style="background: #c8e6c9;">
                            <td><strong>経路A：AWS最適化</strong></td>
                            <td>¥500,000</td>
                            <td>¥690,000</td>
                            <td><strong>¥2,570,000</strong></td>
                        </tr>
                        <tr>
                            <td>経路B：GCP</td>
                            <td>¥2,000,000</td>
                            <td>¥840,000</td>
                            <td>¥4,520,000</td>
                        </tr>
                        <tr>
                            <td>経路B：Azure</td>
                            <td>¥2,000,000</td>
                            <td>¥840,000</td>
                            <td>¥4,520,000</td>
                        </tr>
                        <tr style="background: #fff9c4;">
                            <td>経路C：さくらAppRun</td>
                            <td>¥1,500,000</td>
                            <td>¥600,000</td>
                            <td>¥3,300,000</td>
                        </tr>
                    </tbody>
                </table>
                <p><small>※ 移行コストは人件費を含む概算値。さくらAppRunは正式版料金を保守的に見積もり。</small></p>
            </div>
        </div>

        <!-- 最終提言 -->
        <div id="recommendation" class="content-section">
            <h2>🎯 最終提言：最適な前進の道筋</h2>

            <div class="recommendation" style="background: linear-gradient(135deg, #4caf50 0%, #45a049 100%); padding: 30px;">
                <h3 style="color: white; border: none;">📌 段階的アプローチ戦略</h3>
                <p style="color: white; font-size: 1.1em;">リスクを最小化しながら、短期的・長期的利益を最大化するための実行計画</p>
            </div>

            <h3>フェーズ1：即時実行（今後3ヶ月以内）</h3>
            <div class="highlight-box" style="background: #fff3e0; border-left-color: #ff9800;">
                <h4>🚀 経路A：AWS最適化を実行</h4>
                <p><strong>実施内容：</strong></p>
                <ol>
                    <li><strong>Week 1-2:</strong> RDSプロビジョニング済みインスタンス選定
                        <ul>
                            <li>gai-production: db.t4g.large</li>
                            <li>qsh/marketprice: db.t4g.medium</li>
                            <li>3年間リザーブドインスタンス購入</li>
                        </ul>
                    </li>
                    <li><strong>Week 3-4:</strong> 移行計画策定とステージング準備</li>
                    <li><strong>Week 5-8:</strong> データベース移行実行
                        <ul>
                            <li>ステージング環境での検証</li>
                            <li>本番カットオーバー（低トラフィック時間帯）</li>
                            <li>パフォーマンス監視</li>
                        </ul>
                    </li>
                    <li><strong>Week 9-10:</strong> Lambda最適化
                        <ul>
                            <li>Graviton2 (arm64) への変更</li>
                            <li>Lambda Power Tuning実行</li>
                            <li>メモリ設定最適化</li>
                        </ul>
                    </li>
                    <li><strong>Week 11-12:</strong> 監視と微調整
                        <ul>
                            <li>コスト削減効果の確認</li>
                            <li>パフォーマンスメトリクス分析</li>
                            <li>ドキュメント整備</li>
                        </ul>
                    </li>
                </ol>
                <p><strong>期待される成果：</strong></p>
                <ul>
                    <li>月額コスト：¥285,574 → ¥57,500</li>
                    <li>削減額：約¥228,000/月（約80%削減）</li>
                    <li>年間削減額：約¥2,736,000</li>
                </ul>
            </div>

            <h3>フェーズ2：戦略的検証（3-12ヶ月）</h3>
            <div class="comparison-grid">
                <div class="comparison-item" style="border: 3px solid #667eea;">
                    <h4>PoC #1: GCP Cloud Run</h4>
                    <p><strong>目的：</strong>開発者体験とコスト効率の検証</p>
                    <p><strong>スコープ：</strong></p>
                    <ul>
                        <li>非クリティカルなマイクロサービス1つ</li>
                        <li>Cloud SQL for MySQLのパフォーマンス</li>
                        <li>Cloud Runの自動スケーリング</li>
                        <li>実際の運用コスト測定</li>
                    </ul>
                    <p><strong>期間：</strong>3-6ヶ月</p>
                    <p><strong>予算：</strong>¥500,000-800,000</p>
                </div>

                <div class="comparison-item" style="border: 3px solid #ff9800;">
                    <h4>PoC #2: さくらAppRun</h4>
                    <p><strong>目的：</strong>コスト優位性と安定性の検証</p>
                    <p><strong>スコープ：</strong></p>
                    <ul>
                        <li>開発/ステージング環境の全面移行</li>
                        <li>データ転送料無料の効果測定</li>
                        <li>日本語サポートの質評価</li>
                        <li>正式版料金発表待ち</li>
                    </ul>
                    <p><strong>期間：</strong>3-6ヶ月</p>
                    <p><strong>予算：</strong>¥300,000-500,000（現在ベータ版無料）</p>
                </div>
            </div>

            <div class="highlight-box">
                <h3>📊 PoC評価基準</h3>
                <table>
                    <thead>
                        <tr>
                            <th>評価項目</th>
                            <th>重要度</th>
                            <th>測定方法</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>実際の月額コスト</td>
                            <td><span class="badge badge-high">高</span></td>
                            <td>3ヶ月間の平均請求額</td>
                        </tr>
                        <tr>
                            <td>開発者生産性</td>
                            <td><span class="badge badge-high">高</span></td>
                            <td>デプロイ時間、開発者フィードバック</td>
                        </tr>
                        <tr>
                            <td>パフォーマンス</td>
                            <td><span class="badge badge-high">高</span></td>
                            <td>レスポンスタイム、スループット</td>
                        </tr>
                        <tr>
                            <td>安定性</td>
                            <td><span class="badge badge-high">高</span></td>
                            <td>稼働率、エラー率</td>
                        </tr>
                        <tr>
                            <td>サポート品質</td>
                            <td><span class="badge badge-medium">中</span></td>
                            <td>問い合わせ対応時間と質</td>
                        </tr>
                        <tr>
                            <td>移行の容易性</td>
                            <td><span class="badge badge-medium">中</span></td>
                            <td>必要工数、技術的課題</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h3>フェーズ3：最終意思決定（12ヶ月後）</h3>
            <div class="highlight-box" style="background: #e3f2fd; border-left-color: #2196f3;">
                <h4>📋 意思決定フレームワーク</h4>
                <p><strong>PoC完了後、以下のシナリオから選択：</strong></p>
                
                <p><strong>シナリオ1：AWS継続（推奨条件）</strong></p>
                <ul>
                    <li>最適化後のAWSで十分な満足度</li>
                    <li>PoCで決定的な優位性が見られない</li>
                    <li>移行のリスクが利益を上回る</li>
                </ul>

                <p><strong>シナリオ2：GCPへ全面移行（推奨条件）</strong></p>
                <ul>
                    <li>PoCで開発生産性の大幅向上を確認</li>
                    <li>コスト削減効果がAWS最適化と同等以上</li>
                    <li>チームがCloud Runに高い評価</li>
                </ul>

                <p><strong>シナリオ3：さくらAppRunへ全面移行（推奨条件）</strong></p>
                <ul>
                    <li>正式版の料金が魅力的</li>
                    <li>PoCで安定性を確認</li>
                    <li>TCOが他オプションより明確に低い</li>
                    <li>国内サポートが重要な価値</li>
                </ul>

                <p><strong>シナリオ4：ハイブリッド戦略</strong></p>
                <ul>
                    <li>AWSを主要環境として維持</li>
                    <li>特定ワークロードを他プラットフォームへ</li>
                    <li>ベンダーロックイン回避とコスト最適化の両立</li>
                </ul>
            </div>

            <div class="recommendation" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px; margin-top: 30px;">
                <h3 style="color: white; border: none;">🎯 最終推奨事項</h3>
                <ol style="color: white; font-size: 1.1em;">
                    <li><strong>今すぐ開始：</strong>経路Aの最適化を遅延なく実行してください。これだけで年間¥270万円以上の削減が実現します。</li>
                    <li><strong>リスクヘッジ：</strong>並行してGCPとさくらAppRunのPoCを開始し、データに基づく長期判断を準備してください。</li>
                    <li><strong>柔軟性維持：</strong>最適化されたAWS環境は優れた「フォールバックプラン」となります。移行を急ぐ必要はありません。</li>
                    <li><strong>継続的改善：</strong>四半期ごとにコストとパフォーマンスをレビューし、さらなる最適化機会を探してください。</li>
                </ol>
            </div>

            <div class="warning">
                <h3>⚠️ 避けるべき判断</h3>
                <ul>
                    <li><strong>現状維持：</strong>最適化せずに高コストを放置することは、資金の浪費です</li>
                    <li><strong>性急な全面移行：</strong>PoCなしでの大規模移行は高リスクです</li>
                    <li><strong>Xサーバー等への移行：</strong>VPSベースの環境は運用負荷を激増させます</li>
                    <li><strong>過度な複雑化：</strong>コスト削減のために運用複雑性を増すのは本末転倒です</li>
                </ul>
            </div>
        </div>

        <!-- 経路C -->
        <div id="pathC" class="content-section">
            <h2>🇯🇵 経路C：国内クラウドプロバイダーの評価</h2>

            <h3>1. さくらインターネット AppRun</h3>
            <div class="recommendation">
                <h4>🌟 最も注目すべき国内オプション</h4>
                <p>Knativeベースのモダンなサーバレスプラットフォーム</p>
            </div>

            <div class="comparison-grid">
                <div class="comparison-item">
                    <h4>✅ 主要な利点</h4>
                    <ul>
                        <li><strong>現在ベータ版で無料</strong></li>
                        <li>データ転送料が無料</li>
                        <li>完全な日本語サポート</li>
                        <li>円建て安定価格</li>
                        <li>Knative（Cloud Run互換）</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>⚙️ 提供サービス</h4>
                    <ul>
                        <li>AppRun（サーバレスコンテナ）</li>
                        <li>コンテナレジストリ</li>
                        <li>データベースアプライアンス</li>
                        <li>ウェブアクセラレータ（CDN）</li>
                        <li>WAF（複数製品対応）</li>
                    </ul>
                </div>

                <div class="comparison-item">
                    <h4>⚠️ リスクと課題</h4>
                    <ul>
                        <li>ベータ版（安定性未知）</li>
                        <li>正式版の料金未定</li>
                        <li>機能成熟度がハイパースケーラーに劣る</li>
                        <li>エコシステムが限定的</li>
                    </ul>
                </div>
            </div>

            <div class="highlight-box" style="background: linear-gradient(135deg, #ff980015 0%, #ff572215 100%); border-left-color: #ff9800;">
                <h3>💡 コスト優位性の分析</h3>
                <p><strong>データ転送料無料の影響：</strong></p>
                <p>AWSでは現在CloudFrontに月額約¥69,481を支払っています。さくらインターネットではこのコストが大幅に削減される可能性があります。</p>
                <p><strong>予想TCO：</strong>正式版リリース後も、ハイパースケーラーより30-50%低い可能性</p>
            </div>

            <h3>2. その他の国内プロバイダー</h3>
            
            <div class="cost-card">
                <h4>富士通 FJcloud-O</h4>
                <p><span class="badge badge-medium">適合度：中</span></p>
                <ul>
                    <li>Red Hat OpenShiftベース</li>
                    <li>エンタープライズ向け機能充実</li>
                    <li>コンプライアンス対応に強み</li>
                    <li><strong>課題：</strong>コストが高い、複雑性</li>
                </ul>
            </div>

            <div class="cost-card">
                <h4>NTTコミュニケーションズ</h4>
                <p><span class="badge badge-medium">適合度：中</span></p>
                <ul>
                    <li>Enterprise Cloudサービス群</li>
                    <li>大企業向けソリューション</li>
                    <li>手厚いサポート体制</li>
                    <li><strong>課題：</strong>コスト削減目的には不適</li>
                </ul>
            </div>

            <div class="cost-card" style="border-color: #f44336;">
                <h4>Xサーバー</h4>
                <p><span class="badge badge-low">適合度：低</span> <span class="badge" style="background: #f44336;">非推奨</span></p>
                <ul>
                    <li>共有ホスティング・VPSサービス</li>
                    <li><strong>重大な問題：</strong></li>
                    <li>マネージドサービスなし</li>
                    <li>すべてのインフラ管理が手動に</li>
                    <li>運用コストとリスクが激増</li>
                    <li>現代的アーキテクチャに不適合</li>
                </ul>
            </div>

            <div class="warning">
                <h3>⚠️ 国内プロバイダー選択の注意点</h3>
                <p>日本のクラウド市場は従来、エンタープライズ向けの重厚なソリューションか、基本的なVPSホスティングの二択でした。</p>
                <p><strong>AppRunの登場は「第三の道」を示唆：</strong>ハイパースケーラー流のモダンPaaSを国内で提供する新しい選択肢です。</p>
            </div>