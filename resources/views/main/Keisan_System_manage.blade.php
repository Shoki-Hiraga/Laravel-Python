<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>システム管理基準 - 経済産業省</title>
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
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 20px;
        }

        header {
            grid-column: 1 / -1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
        }

        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .sidebar {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            position: sticky;
            top: 20px;
            height: fit-content;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }

        .sidebar h2 {
            color: #667eea;
            font-size: 1.3em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            padding: 12px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            border-left: 4px solid transparent;
            font-size: 0.95em;
        }

        .nav-item:hover {
            background: #e9ecef;
            border-left-color: #667eea;
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-left-color: #764ba2;
            font-weight: bold;
        }

        .nav-group {
            margin-top: 15px;
        }

        .nav-group-title {
            font-weight: bold;
            color: #495057;
            margin-bottom: 8px;
            font-size: 0.9em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        main {
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            min-height: 600px;
        }

        .section {
            display: none;
            animation: fadeIn 0.5s;
        }

        .section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .section h2 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
        }

        .section h3 {
            color: #764ba2;
            font-size: 1.5em;
            margin-top: 30px;
            margin-bottom: 15px;
            padding-left: 15px;
            border-left: 5px solid #764ba2;
        }

        .section h4 {
            color: #495057;
            font-size: 1.2em;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .section p, .section li {
            color: #555;
            margin-bottom: 15px;
            text-align: justify;
        }

        .section ul, .section ol {
            margin-left: 30px;
            margin-bottom: 20px;
        }

        .section li {
            margin-bottom: 10px;
        }

        .goal-box, .activity-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            border-left: 5px solid #667eea;
        }

        .activity-box {
            border-left-color: #764ba2;
        }

        .goal-box h4, .activity-box h4 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.1em;
        }

        .activity-box h4 {
            color: #764ba2;
        }

        .info-badge {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85em;
            margin-bottom: 15px;
        }

        .search-box {
            margin-bottom: 20px;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 12px 40px 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 0.95em;
            transition: all 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #adb5bd;
        }

        .highlight {
            background: yellow;
            padding: 2px 4px;
            border-radius: 3px;
        }

        .glossary-term {
            background: #e7f3ff;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            border-left: 4px solid #0066cc;
        }

        .glossary-term strong {
            color: #0066cc;
            display: block;
            margin-bottom: 5px;
        }

        @media (max-width: 1024px) {
            .container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: relative;
                top: 0;
                max-height: none;
            }

            header h1 {
                font-size: 1.8em;
            }

            main {
                padding: 25px;
            }
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: all 0.3s;
            z-index: 1000;
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.4);
        }

        .back-to-top.show {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📘 システム管理基準</h1>
            <p>経済産業省 | 令和5年4月26日</p>
        </header>

        <aside class="sidebar">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="内容を検索...">
                <span class="search-icon">🔍</span>
            </div>
            <h2>目次</h2>
            <nav id="navigation">
                <div class="nav-item active" data-section="intro">前文</div>
                
                <div class="nav-group">
                    <div class="nav-group-title">Ⅰ. ITガバナンス編</div>
                    <div class="nav-item" data-section="governance-1">1. ITガバナンスの実践</div>
                    <div class="nav-item" data-section="governance-2">2. ITガバナンス実践に必要な要件</div>
                </div>

                <div class="nav-group">
                    <div class="nav-group-title">Ⅱ. ITマネジメント編</div>
                    <div class="nav-item" data-section="management-1">1. 推進・管理体制</div>
                    <div class="nav-item" data-section="management-2">2. プロジェクト管理</div>
                    <div class="nav-item" data-section="management-3">3. 企画プロセス</div>
                    <div class="nav-item" data-section="management-4">4. 開発プロセス</div>
                    <div class="nav-item" data-section="management-5">5. 運用プロセス</div>
                    <div class="nav-item" data-section="management-6">6. 保守プロセス</div>
                    <div class="nav-item" data-section="management-7">7. 廃棄プロセス</div>
                    <div class="nav-item" data-section="management-8">8. 外部サービス管理</div>
                    <div class="nav-item" data-section="management-9">9. 事業継続管理</div>
                    <div class="nav-item" data-section="management-10">10. 人的資源管理</div>
                </div>

                <div class="nav-group">
                    <div class="nav-item" data-section="glossary">用語集</div>
                </div>
            </nav>
        </aside>

        <main id="mainContent">
            <!-- 前文 -->
            <section class="section active" id="intro">
                <h2>前文(システム管理基準の活用にあたって)</h2>
                
                <p>システム管理基準(以下、「基準」という。)は、平成16年のシステム監査基準の改訂において、システム監査基準の「実施基準」の主要部分を抜き出し、当時の情報技術の進展を踏まえて修正･追加を行うことによって、システム監査基準の姉妹編として策定された。</p>

                <h3>改訂の趣旨</h3>
                <p>今回の改訂においては、以下の点を考慮して、今後の組織体におけるITシステムの利活用の進展状況に対応しやすい内容とすることを企図し、ITガバナンス編とITマネジメント編から構成した。</p>

                <ol>
                    <li>様々な組織において、データの利活用を含むITシステムの利活用によって、組織体の価値を向上させるサービス、製品及びプロセスを生み出し、改善する取組が加速している。</li>
                    <li>自社で保有する情報システムだけでなく、広く外部のサービスを利用して事業を推進する組織体が多くを占めるようになっている。</li>
                    <li>ボーダレスなIT環境を踏まえて、ITガバナンス及びITマネジメントに関わる国際規格の考え方や体系を取り入れる必要性が生じている。</li>
                </ol>

                <h3>「基準」の適用方法</h3>
                <p>「基準」は、大規模な企業のみでなく、中小規模の企業や、各府省庁、地方公共団体、病院、学校法人等、各種組織体がシステム監査を行う場合の判断尺度としても利用ないし参考にできるように、汎用性のある内容となっている。</p>

                <div class="goal-box">
                    <h4>重要なポイント</h4>
                    <p>組織体の事業目的、事業分野における特性、組織体の業種・業態特性、ITシステムの利活用の特性などを踏まえて、「基準」で示した項目・内容の取捨選択・修正、関連する他の基準やガイドライン等からの必要項目の追加、用語の修正等を行い、システム監査及びITガバナンスやITマネジメントの趣旨で示した内容が実現できるように組織体に適した形にして、適用することが望ましい。</p>
                </div>

                <h3>「基準」が想定する組織体の体制</h3>
                <p>「基準」が想定する組織体の体制において、「取締役会等」とは、取締役会、理事会等の組織体のガバナンスを担う機関を意味し、「経営者」とは、最高経営責任者(CEO)、最高情報責任者(CIO)などの組織の業務執行責任を担う執行役員等を意味する。</p>

                <ul>
                    <li><strong>取締役会等:</strong> 組織体のITシステムの利活用に関して責任を負う領域がITガバナンス</li>
                    <li><strong>経営者:</strong> ITシステムの利活用について責任を負う領域がITマネジメント</li>
                </ul>
            </section>

            <!-- ITガバナンス編 1 -->
            <section class="section" id="governance-1">
                <h2>Ⅰ.1 ITガバナンスの実践</h2>
                
                <p>ステークホルダーのニーズに基づき、組織体の価値及び組織体への信頼度を向上させるために、組織体におけるITシステムの利活用のあるべき姿を示すIT戦略を策定し、組織体のITに関するパフォーマンスを含めたITガバナンスの状況を確認して必要な是正措置を指示することによって、組織体の目標を達成する。</p>

                <h3>Ⅰ.1.1 経営戦略とビジネスモデルの確認</h3>
                
                <div class="goal-box">
                    <h4>達成目標</h4>
                    <ol>
                        <li>組織体を取り巻く自然環境、社会的・経済的な状況に応じて、組織体の目的を達成するための経営戦略とビジネスモデルと達成すべきビジネス成果が明確にされ、組織体全体に周知されている。</li>
                        <li>経営戦略とビジネスモデルを実現するためのITの役割と重要性が認識されている。</li>
                        <li>経営戦略とビジネスモデルを実現するためのIT戦略ビジョンが策定されている。</li>
                        <li>ITソリューションや新技術等が経営戦略とビジネスモデルに及ぼす影響が定期的に評価され、経営戦略とビジネスモデルについて、必要な見直しを行っている。</li>
                    </ol>
                </div>

                <div class="activity-box">
                    <h4>ガバナンス活動の例</h4>
                    <ol>
                        <li><strong>IT戦略ビジョンの策定:</strong> 経営戦略とビジネスモデルにおけるITの役割を明確にし、組織体のIT戦略ビジョンを策定する。</li>
                        <li><strong>ビジネス成果の設定:</strong> IT戦略ビジョンでは、経営戦略とビジネスモデルにより達成すべきビジネス成果を設定する。</li>
                        <li><strong>ステークホルダーのニーズの反映:</strong> IT戦略ビジョンには、ステークホルダーのニーズを反映する。</li>
                        <li><strong>新技術等の定期的評価:</strong> 新しいITソリューションや新技術がIT戦略ビジョンに及ぼす影響を定期的に評価する。</li>
                        <li><strong>市場変化の定期的評価:</strong> 市場の変化が経営戦略とビジネスモデルに及ぼす影響を定期的に評価する。</li>
                        <li><strong>IT戦略ビジョン等の見直し:</strong> 事業環境等の評価を実施し、その結果に基づいて、ビジネスモデルとIT戦略ビジョンの見直しを行う。</li>
                    </ol>
                </div>

                <h3>Ⅰ.1.2 IT戦略の策定</h3>
                
                <p>組織体におけるITシステムの利活用のあるべき姿を示すIT戦略を策定し、それに基づいてITマネジメントの責任者に指示する。</p>

                <div class="goal-box">
                    <h4>達成目標</h4>
                    <ol>
                        <li>取締役会等の意図と期待を明確にしたIT戦略(ITガバナンス方針とIT基本計画)が策定されている。</li>
                        <li>ITガバナンス方針には、ビジネス成果を実現するためのIT戦略の達成目標が設定されている。</li>
                        <li>IT戦略の実現に必要となる組織体のデジタル活用能力を確保するための戦略と計画が策定されている。</li>
                        <li>IT戦略において、ITソリューションの劣化や陳腐化に対処するための戦略と、将来に向けたITに関する適切な方向性が示されている。</li>
                    </ol>
                </div>

                <h3>Ⅰ.1.3 効果的なITパフォーマンスの確認と是正</h3>
                
                <p>組織体のITパフォーマンスが、取締役会等の意図や期待、倫理的行動、コンプライアンス上の義務を満足していることを確認するために、ITパフォーマンスの状況を適時確認して、必要な是正措置を指示する。</p>

                <h3>Ⅰ.1.4 実行責任及び説明責任の明確化</h3>
                
                <p>組織体全体及びステークホルダーに対する実行責任及び説明責任は取締役会等が有しており、これらの責任を果たすために、取締役会等は主体的に責任をもって行動する。</p>
            </section>

            <!-- ITガバナンス編 2 -->
            <section class="section" id="governance-2">
                <h2>Ⅰ.2 ITガバナンス実践に必要な要件</h2>
                
                <p>ITガバナンスの実践により、優れた成果を挙げるためには、ITガバナンス活動を支えるための、ステークホルダーへの対応、取締役会等のリーダーシップ、データ利活用と意思決定、リスクの評価と対応、社会的責任と持続性等の要件を整える必要がある。</p>

                <h3>Ⅰ.2.1 ステークホルダーへの対応</h3>
                
                <div class="goal-box">
                    <h4>達成目標</h4>
                    <ol>
                        <li>ステークホルダーに対して、計画的で適切な対応が実践されている。</li>
                        <li>組織体のビジネスモデル及びIT戦略は、ステークホルダー中心のアプローチによって、ステークホルダーのニーズと整合がとられている。</li>
                        <li>組織体のIT戦略に対するステークホルダーの満足度を高めている。</li>
                    </ol>
                </div>

                <h3>Ⅰ.2.2 取締役会等のリーダーシップ</h3>
                
                <p>組織体の変革や倫理規範の遵守のために、取締役会等が率先して倫理的な行動を実践するとともに、効果的な指導を通じてリーダーシップを発揮する。</p>

                <h3>Ⅰ.2.3 データ利活用と意思決定</h3>
                
                <p>データが、意思決定のための価値のある経営資源であることを組織体に認識させるために、データ利活用に関する方針等を策定し、周知する。</p>

                <h3>Ⅰ.2.4 リスクの評価と対応</h3>
                
                <div class="goal-box">
                    <h4>達成目標</h4>
                    <ol>
                        <li>ITシステムの利活用に関連する重要なリスクが認識され、速やかに対応されている。</li>
                        <li>ITシステムの利活用に関して、組織体が受容できるリスクのレベルが明確にされ、管理されている。</li>
                        <li>組織体内外の障害等に対応し、ITサービス等のレジリエンスが確保できるよう対策されている。</li>
                        <li>ITシステムの利活用に関する事業継続の方針が策定されている。</li>
                    </ol>
                </div>

                <h3>Ⅰ.2.5 社会的責任と持続性</h3>
                
                <p>組織体が存続し、長期に成果を挙げ続けるために、ITシステムの利活用に関する組織体の意思決定の透明性を確保し、より広範な社会的期待に応え、現在及び将来のステークホルダーのニーズを満足させるように組織体のデジタル活用能力を維持・向上させる。</p>
            </section>

            <!-- ITマネジメント編 1 -->
            <section class="section" id="management-1">
                <h2>Ⅱ.1 推進・管理体制</h2>
                
                <p>経営戦略及びIT戦略で定められた目標を達成するために、組織体全体を対象とした推進・管理体制を整備・運用する。</p>

                <h3>Ⅱ.1.1 体制と機能</h3>
                
                <div class="goal-box">
                    <h4>達成目標</h4>
                    <ol>
                        <li>経営者の承認を得て、組織体の規模及び特性に応じたIT部門の体制が構築されている。</li>
                        <li>IT戦略に関わる意思決定を支援するための情報が経営者に提供されている。</li>
                        <li>ITシステムの利活用に関する技術の動向に対応するための体制が整備・運用されている。</li>
                        <li>ITシステムの利活用に関するパフォーマンスとコストに関する実行状況をモニタリングし、必要な是正措置が講じられている。</li>
                        <li>データ利活用の推進と管理のための体制が整備・運用されている。</li>
                        <li>ITシステムの利活用に関するリスク管理(サイバーセキュリティリスク管理を含む)のための体制が整備・運用されている。</li>
                    </ol>
                </div>

                <h3>Ⅱ.1.2 システムライフサイクルモデル管理</h3>
                
                <p>IT戦略に従って、目標に適合した手順と方法で情報システムを構築、運用するためのシステムライフサイクルモデルを作成、適用するとともに、そのモデルを評価し改善する。</p>

                <h3>Ⅱ.1.3 ITアーキテクチャ管理</h3>
                
                <p>組織体の情報システム全体の整合性を保って、情報システムを構築・運用するために必要なITアーキテクチャを定め、IT基盤を利用可能にする。</p>

                <h3>Ⅱ.1.4 資源配分管理</h3>
                
                <p>経営資源を有効に活用するために、プロジェクトに優先順位を付けて資源配分を行う。</p>

                <h3>Ⅱ.1.5 品質管理体制</h3>
                
                <p>利用者が満足する製品やサービスを提供するために、最適な品質管理体制を整備・運用する。</p>

                <h3>Ⅱ.1.6 知識資産管理</h3>
                
                <p>個別に得た知識、技能を基に、組織体として知識資産を蓄積し有効利用するために、知識資産を再利用可能な状態で管理する。</p>
            </section>

            <!-- ITマネジメント編 2 -->
            <section class="section" id="management-2">
                <h2>Ⅱ.2 プロジェクト管理</h2>
                
                <p>経営戦略及びIT戦略で定められた目標を達成するために必要なプロジェクト管理の仕組みを整備し、個別プロジェクトに適用することによりプロジェクトを実行する。</p>

                <h3>Ⅱ.2.1 プロジェクト計画の策定と承認</h3>
                
                <div class="activity-box">
                    <h4>管理活動の例</h4>
                    <ol>
                        <li><strong>プロジェクトの目的、対象業務、効果:</strong> IT戦略に従ってプロジェクトの目的、対象業務、期待される効果を明確にする。</li>
                        <li><strong>プロジェクトの体制:</strong> プロジェクトマネージャ(PM)等、プロジェクトに必要な体制を整備する。</li>
                        <li><strong>プロジェクト計画:</strong> プロジェクトのスケジュール、リソース(要員スキル・作業工数、予算)等を定めたプロジェクト計画を整備する。</li>
                        <li><strong>プロジェクトの実行の準備:</strong> プロジェクト計画の承認後に、適時にプロジェクトを開始できるよう準備する。</li>
                    </ol>
                </div>

                <h3>Ⅱ.2.2 プロジェクトの実行と管理</h3>
                <h3>Ⅱ.2.3 プロジェクト意思決定管理</h3>
                <h3>Ⅱ.2.4 プロジェクトリスク管理</h3>
                <h3>Ⅱ.2.5 調達管理</h3>
                <h3>Ⅱ.2.6 外部委託管理</h3>
                <h3>Ⅱ.2.7 構成管理・変更管理</h3>
                <h3>Ⅱ.2.8 情報管理</h3>
                <h3>Ⅱ.2.9 ドキュメント管理</h3>
                <h3>Ⅱ.2.10 プロジェクトの生産性等の測定</h3>
                <h3>Ⅱ.2.11 情報システムの品質保証</h3>
            </section>

            <!-- ITマネジメント編 3 -->
            <section class="section" id="management-3">
                <h2>Ⅱ.3 企画プロセス</h2>
                
                <p>経営戦略及びIT戦略で定められた目標を達成するために必要な情報システムの開発体制を整備し、ビジネスモデル及び業務要件を明確にして、設計作業を行う。</p>

                <h3>Ⅱ.3.1 ビジネス分析</h3>
                <h3>Ⅱ.3.2 業務要件定義</h3>
                <h3>Ⅱ.3.3 システム要件定義</h3>
                <h3>Ⅱ.3.4 基本設計</h3>
                <h3>Ⅱ.3.5 詳細設計</h3>
                <h3>Ⅱ.3.6 実現可能性及び効果の分析</h3>
            </section>

            <!-- ITマネジメント編 4 -->
            <section class="section" id="management-4">
                <h2>Ⅱ.4 開発プロセス</h2>
                
                <p>利用者及び関係者の要望に沿った情報システムを実現するために、情報システムの構成要素の開発作業を行い、稼動後評価及び報告を行う。</p>

                <h3>Ⅱ.4.1 実装</h3>
                <h3>Ⅱ.4.2 統合</h3>
                <h3>Ⅱ.4.3 検証</h3>
                <h3>Ⅱ.4.4 ユーザ受入テスト</h3>
                <h3>Ⅱ.4.5 本番環境への移行</h3>
                <h3>Ⅱ.4.6 稼動後評価と報告</h3>
            </section>

            <!-- ITマネジメント編 5 -->
            <section class="section" id="management-5">
                <h2>Ⅱ.5 運用プロセス</h2>
                
                <p>組織体の方針及び要求事項に沿ったサービスを提供するために、情報システムの運用体制を整備して運用を実施し、その監視、検証及び報告を行う。</p>

                <h3>Ⅱ.5.1 運用体制の整備</h3>
                <h3>Ⅱ.5.2 運用計画</h3>
                <h3>Ⅱ.5.3 運用の実施</h3>
                <h3>Ⅱ.5.4 運用における構成管理・変更管理</h3>
                <h3>Ⅱ.5.5 インシデント管理・問題管理</h3>
                <h3>Ⅱ.5.6 サービスレベル管理</h3>
                <h3>Ⅱ.5.7 運用の監視と記録</h3>
                <h3>Ⅱ.5.8 運用の評価と報告</h3>
            </section>

            <!-- ITマネジメント編 6 -->
            <section class="section" id="management-6">
                <h2>Ⅱ.6 保守プロセス</h2>
                
                <p>利用者の業務活動を支援する情報システムの能力・機能を維持するために、保守体制を整備し、保守依頼に応じた保守計画を策定して、それに基づいて保守作業を実施し、その検証、本番環境への適用、記録及び報告を行う。</p>

                <h3>Ⅱ.6.1 保守体制の整備</h3>
                <h3>Ⅱ.6.2 保守計画</h3>
                <h3>Ⅱ.6.3 保守作業の実施</h3>
                <h3>Ⅱ.6.4 保守作業の検証</h3>
                <h3>Ⅱ.6.5 本番環境への適用</h3>
                <h3>Ⅱ.6.6 実施結果の記録と報告</h3>
            </section>

            <!-- ITマネジメント編 7 -->
            <section class="section" id="management-7">
                <h2>Ⅱ.7 廃棄プロセス</h2>
                
                <p>組織体の方針及び廃棄に関する要求事項に従って情報システムの利用を適切に終了するために、不要になった情報システムの構成要素を適切に廃棄する。</p>

                <h3>Ⅱ.7.1 廃棄計画</h3>
                <h3>Ⅱ.7.2 廃棄の実施</h3>
                <h3>Ⅱ.7.3 廃棄結果の検証</h3>
            </section>

            <!-- ITマネジメント編 8 -->
            <section class="section" id="management-8">
                <h2>Ⅱ.8 外部サービス管理</h2>
                
                <p>IT戦略に基づいて外部サービス(クラウドサービスを含む)を利用するために、外部サービスの利用計画を策定し、外部サービス提供者を選定、契約、管理及び評価する。</p>

                <h3>Ⅱ.8.1 外部サービス利用計画の策定</h3>
                <h3>Ⅱ.8.2 外部サービスの選定と契約</h3>
                <h3>Ⅱ.8.3 外部サービスの運用管理</h3>
                <h3>Ⅱ.8.4 外部サービスの評価</h3>
                <h3>Ⅱ.8.5 サービスレベル管理</h3>
            </section>

            <!-- ITマネジメント編 9 -->
            <section class="section" id="management-9">
                <h2>Ⅱ.9 事業継続管理</h2>
                
                <p>組織体のITシステムの利活用に関する事業継続の方針に基づいて、情報システムの業務継続を実現するために、情報システムの業務継続計画を策定し、訓練、検証、報告及び改善を行う。</p>

                <h3>Ⅱ.9.1 リスクアセスメント</h3>
                <h3>Ⅱ.9.2 業務継続計画の策定</h3>
                <h3>Ⅱ.9.3 業務継続計画の管理</h3>
                <h3>Ⅱ.9.4 訓練、演習及びテストの実施</h3>
                <h3>Ⅱ.9.5 業務継続計画の評価及び見直し</h3>
            </section>

            <!-- ITマネジメント編 10 -->
            <section class="section" id="management-10">
                <h2>Ⅱ.10 人的資源管理</h2>
                
                <p>組織体の人的資源に関する方針に基づいて、ITに関する人的資源を管理し、ITに関する組織の能力を維持向上させる。</p>

                <h3>Ⅱ.10.1 人的資源管理計画</h3>
                <h3>Ⅱ.10.2 責任と権限の管理</h3>
                <h3>Ⅱ.10.3 業務遂行の管理</h3>
                <h3>Ⅱ.10.4 教育・訓練の管理</h3>
                <h3>Ⅱ.10.5 健康管理</h3>
                <h3>Ⅱ.10.6 要員のワーク・エンゲージメント向上</h3>
            </section>

            <!-- 用語集 -->
            <section class="section" id="glossary">
                <h2>📖 システム管理基準の用語集</h2>
                
                <h3>Ⅰ. ITガバナンス</h3>
                
                <div class="glossary-term">
                    <strong>ITエコシステム</strong>
                    <p>他の組織と利用する共通のデジタル基盤やITサービス等であり、ITベンダ、外部サービス提供者、外部委託先、顧客、取引先、行政機関等のステークホルダーが関与する。</p>
                </div>

                <div class="glossary-term">
                    <strong>IT戦略ビジョン</strong>
                    <p>経営戦略とビジネスモデルを支えるITシステムの利活用のあるべき姿を示したものであり、組織体が目指すITシステムの利活用の形態とITシステムの利活用により達成するビジネス成果を含む。</p>
                </div>

                <div class="glossary-term">
                    <strong>ITソリューション</strong>
                    <p>組織体が利活用するITシステムを構成する個別の製品やサービスであり、外部から調達するものを含む。</p>
                </div>

                <div class="glossary-term">
                    <strong>ITパフォーマンス</strong>
                    <p>ITシステムの利活用により達成した測定可能な結果又は成果を指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>デジタル活用能力</strong>
                    <p>ITシステムの利活用により組織体の価値を向上させるサービスや製品、プロセスを生み出し、改善する能力を指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>ビジネスモデル</strong>
                    <p>組織体が事業を行うことで、ステークホルダーに価値を提供し、それを持続的な組織体の価値向上につなげていく仕組みを指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>レジリエンス(回復力)</strong>
                    <p>ITシステムやサービスがシステム障害や災害、サイバー攻撃等の問題に直面したとき、迅速に被害からの回復を図り正常な状態に復旧・復元する能力を指す。</p>
                </div>

                <h3>Ⅱ. ITマネジメント</h3>

                <div class="glossary-term">
                    <strong>ITアーキテクチャ</strong>
                    <p>組織体の情報システム全体の設計原則や構成要素の基本的構造を指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>インシデント</strong>
                    <p>情報システムが正常稼働しない状況となり、事業や業務活動の中断・阻害、損失、緊急事態又は危機が発生し得る状況を指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>SLA (Service Level Agreement)</strong>
                    <p>委託元(サービス利用者)と委託先(サービス提供者)の間で結ばれたサービスレベルに関する文書による合意を指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>概念実証(PoC)</strong>
                    <p>ビジネス上の問題を解決する新しいコンセプト、アイデアの有効性や実現可能性を示すための検証を指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>技術実証(PoT)</strong>
                    <p>システム要件を満たすために使用する製品や技術の有効性や実現可能性を検証することを指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>システムライフサイクルモデル</strong>
                    <p>情報システムの企画から廃棄に至るまでの一連の過程をいくつかの段階に分類し、それぞれの段階で発生する工程を一般化して整理したものを指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>最大許容停止時間(MTPD)</strong>
                    <p>事業活動を再開しないことによる影響が、組織にとって許容できなくなるまでの時間枠を指す。</p>
                </div>

                <div class="glossary-term">
                    <strong>目標復旧時間(RTO)</strong>
                    <p>最大許容停止時間の範囲内で、中断・阻害された事業活動を規定された最低限の許容できる規模で再開するまでの優先すべき時間枠を指す。</p>
                </div>
            </section>
        </main>
    </div>

    <div class="back-to-top" id="backToTop">↑</div>

    <script>
        // ナビゲーション機能
        const navItems = document.querySelectorAll('.nav-item');
        const sections = document.querySelectorAll('.section');
        
        navItems.forEach(item => {
            item.addEventListener('click', () => {
                const sectionId = item.getAttribute('data-section');
                
                // アクティブ状態の更新
                navItems.forEach(nav => nav.classList.remove('active'));
                item.classList.add('active');
                
                // セクションの表示切替
                sections.forEach(section => {
                    section.classList.remove('active');
                    if (section.id === sectionId) {
                        section.classList.add('active');
                    }
                });

                // スクロールを最上部へ
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // 検索機能
        const searchInput = document.getElementById('searchInput');
        let searchTimeout;

        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const searchTerm = e.target.value.toLowerCase();
                
                if (searchTerm.length < 2) {
                    // 検索語が短い場合はハイライトをクリア
                    removeHighlights();
                    return;
                }

                // 全セクションを検索
                sections.forEach(section => {
                    const content = section.textContent.toLowerCase();
                    if (content.includes(searchTerm)) {
                        highlightText(section, searchTerm);
                    }
                });
            }, 300);
        });

        function highlightText(element, term) {
            removeHighlights();
            
            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );

            const nodesToReplace = [];
            while (walker.nextNode()) {
                const node = walker.currentNode;
                if (node.textContent.toLowerCase().includes(term)) {
                    nodesToReplace.push(node);
                }
            }

            nodesToReplace.forEach(node => {
                const parent = node.parentNode;
                const text = node.textContent;
                const regex = new RegExp(`(${term})`, 'gi');
                const parts = text.split(regex);
                
                const fragment = document.createDocumentFragment();
                parts.forEach(part => {
                    if (part.toLowerCase() === term.toLowerCase()) {
                        const span = document.createElement('span');
                        span.className = 'highlight';
                        span.textContent = part;
                        fragment.appendChild(span);
                    } else {
                        fragment.appendChild(document.createTextNode(part));
                    }
                });
                
                parent.replaceChild(fragment, node);
            });
        }

        function removeHighlights() {
            const highlights = document.querySelectorAll('.highlight');
            highlights.forEach(highlight => {
                const parent = highlight.parentNode;
                parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
                parent.normalize();
            });
        }

        // トップへ戻るボタン
        const backToTop = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // サイドバーのスクロール同期
        const sidebar = document.querySelector('.sidebar');
        let lastScrollTop = 0;

        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            if (scrollTop > lastScrollTop) {
                // 下にスクロール
            } else {
                // 上にスクロール
            }
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        });
    </script>
</body>
</html>