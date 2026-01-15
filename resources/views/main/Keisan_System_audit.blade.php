<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>システム監査基準（令和5年4月26日）- 経済産業省</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Hiragino Sans", "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
            line-height: 1.8;
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
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
            text-align: center;
        }

        h1 {
            color: #667eea;
            font-size: 2em;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            font-size: 1.1em;
        }

        .search-box {
            margin: 20px 0;
            position: relative;
        }

        .search-box input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #ddd;
            border-radius: 50px;
            font-size: 16px;
            transition: all 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 10px rgba(102, 126, 234, 0.2);
        }

        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .main-content {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 30px;
        }

        .sidebar {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .sidebar h2 {
            color: #667eea;
            font-size: 1.3em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }

        .toc-item {
            padding: 10px 15px;
            margin: 5px 0;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s;
            font-size: 0.95em;
        }

        .toc-item:hover {
            background: #f0f0ff;
            transform: translateX(5px);
        }

        .toc-item.active {
            background: #667eea;
            color: white;
        }

        .content {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .section {
            margin-bottom: 50px;
        }

        .section h2 {
            color: #667eea;
            font-size: 1.8em;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }

        .section h3 {
            color: #764ba2;
            font-size: 1.4em;
            margin: 30px 0 15px 0;
        }

        .section h4 {
            color: #555;
            font-size: 1.2em;
            margin: 20px 0 10px 0;
        }

        .highlight {
            background: #fff3cd;
            padding: 2px 5px;
            border-radius: 3px;
        }

        .standard-box {
            background: #f8f9ff;
            border-left: 5px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .interpretation {
            background: #f0fff4;
            border-left: 5px solid #48bb78;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .term {
            color: #667eea;
            cursor: pointer;
            border-bottom: 1px dotted #667eea;
            font-weight: 500;
        }

        .term:hover {
            background: #f0f0ff;
        }

        .tooltip {
            position: fixed;
            background: #2d3748;
            color: white;
            padding: 15px;
            border-radius: 8px;
            max-width: 400px;
            font-size: 0.9em;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 1000;
            display: none;
        }

        ul, ol {
            margin-left: 30px;
            margin-top: 10px;
        }

        li {
            margin: 8px 0;
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #667eea;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s;
            opacity: 0;
            pointer-events: none;
        }

        .back-to-top.visible {
            opacity: 1;
            pointer-events: all;
        }

        .back-to-top:hover {
            background: #764ba2;
            transform: translateY(-5px);
        }

        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }

            .content {
                padding: 20px;
            }
        }

        .tag {
            display: inline-block;
            background: #e0e7ff;
            color: #667eea;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            margin: 5px 5px 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📋 システム監査基準</h1>
            <div class="subtitle">経済産業省 | 令和5年4月26日</div>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="キーワードで検索...">
                <span class="search-icon">🔍</span>
            </div>
        </header>

        <div class="main-content">
            <aside class="sidebar">
                <h2>📑 目次</h2>
                <div id="tocContainer"></div>
            </aside>

            <main class="content" id="mainContent">
                <section class="section" id="section-0">
                    <h2>前文（システム監査基準の活用に当たって）</h2>
                    
                    <h3>システム監査基準の意義と適用上の留意事項</h3>
                    <p><span class="term" data-term="システム監査">システム監査</span>とは、監査人が、一定の基準に基づいて<span class="term" data-term="ITシステム">ITシステム</span>の利活用に係る検証・評価を行い、<span class="term" data-term="ガバナンス">ガバナンス</span>や<span class="term" data-term="マネジメント">マネジメント</span>等について、一定の保証や改善のための助言を行うものであり、システムの信頼性等を確保し、企業等に対する信用を高める重要な取組である。</p>

                    <p>今日社会でのITや情報システム、さらにはデータ・情報（本監査基準において、IT、情報システム、データ・情報をまとめた概念として「ITシステム」という。）の利活用は、会社やその他組織体の諸活動全般に及んでいる。ITシステムの戦略的利活用は、組織体の価値の向上や会社の競争力の維持、向上を図る上で不可欠である一方、それに伴いリスクも増大している。</p>

                    <p>組織体が適切に<span class="term" data-term="リスク・マネジメント">リスク・マネジメント</span>を行い、価値向上のためにITシステムの利活用を適切に行うことを確実にするために、システム監査が効果的・効率的に行われることが必要である。</p>

                    <h3>システム監査上の判断尺度</h3>
                    <p>本監査基準に基づくシステム監査においては、ITシステムのガバナンス、マネジメント、<span class="term" data-term="コントロール">コントロール</span>を検証・評価する際の判断の尺度として、「システム管理基準」又は当該基準を組織体の特性や状況等に応じて調整編集した基準・規程等を利用することが望ましい。</p>

                    <h3>本監査基準改訂の背景と主要な改訂内容</h3>
                    <p>本監査基準は、昭和60年（1985年）1月に策定され、その後、平成8年（1996年）1月、平成16年（2004年）10月、平成30年4月（2018年）に改訂がされてきたが、その後もシステム監査を巡るIT環境の継続的な変化や、システム監査に対するニーズの多様化がみられたことから、それらを踏まえて基準の構成や内容を見直しすることとした。</p>

                    <div class="standard-box">
                        <h4>具体的な環境変化やニーズの多様化</h4>
                        <ul>
                            <li>AIの発展とDXの普及</li>
                            <li>サイバー攻撃の高度化・複雑化等による新たなリスクの発生</li>
                            <li>システム・マネジメントの基となるガバナンスの重要性増加</li>
                            <li>スリー・ラインズ・モデル等でいわれる各種のモニタリング活動とシステム監査の連携の重要性増加</li>
                            <li>システム監査における品質管理等の有効性への期待の高まり</li>
                            <li>アジャイル型監査の普及等監査方法の多様化</li>
                        </ul>
                    </div>

                    <h3>監査人と取締役会等、経営者との関係</h3>
                    <p>本監査基準において、<span class="term" data-term="監査人">監査人</span>とは、独立にして客観的な立場から情報システムに係る保証や助言の活動を行う者を指し、ガバナンスの一翼を担う会社法上の監査役（会）等とその補助使用人、内部監査人、組織体からの依頼により監査を行う組織体の外部の第三者が含まれる。</p>

                    <div class="interpretation">
                        <h4>監査業務の種類</h4>
                        <p>監査業務は保証を目的としたシステム監査と助言を目的としたシステム監査から成り立っている。</p>
                        <ul>
                            <li><strong>保証を目的としたシステム監査：</strong>監査対象先について、監査の意見又は結論を得る基礎として、監査人が入手した証拠を客観的に評価することが含まれる</li>
                            <li><strong>助言を目的としたシステム監査：</strong>助言に加えて提案や相談の提供であり、一般に、依頼者からの具体的な要請に基づいて実施される</li>
                        </ul>
                    </div>
                </section>

                <section class="section" id="section-1">
                    <h2>システム監査の意義と目的</h2>
                    <div class="standard-box">
                        <p>システム監査とは、専門性と客観性を備えた監査人が、一定の基準に基づいてITシステムの利活用に係る検証・評価を行い、監査結果の利用者にこれらのガバナンス、マネジメント、コントロールの適切性等に対する保証を与える、又は改善のための助言を行う監査である。</p>
                        
                        <p style="margin-top: 15px;">また、システム監査の目的は、ITシステムに係るリスクに適切に対応しているかどうかについて、監査人が検証・評価し、もって保証や助言を行うことを通じて、組織体の経営活動と業務活動の効果的かつ効率的な遂行、さらにはそれらの変革を支援し、組織体の目標達成に寄与すること、及び利害関係者に対する説明責任を果たすことである。</p>
                    </div>
                </section>

                <section class="section" id="section-2">
                    <h2>監査人の倫理</h2>
                    <p>システム監査は、監査人の誠実性及び専門的な能力を信頼し依頼されるものであり、監査人はその期待に応え、責任を果たすことが求められ、業務に関する説明責任を果たすこととなる。</p>

                    <p>さらに、システム監査が結果として、広く社会的な信用につながるには、個々の利用者・依頼人の要請を満たすだけではなく、監査人が独立した立場において、社会的役割を自覚し、自らを律し、かつ社会の期待に応え、公共の利益に資することができなければならない。</p>

                    <div class="standard-box">
                        <h3>監査人が守るべき4つの原則</h3>
                        
                        <h4>○ 誠実性</h4>
                        <p>監査業務において、常に正直な態度を保持し、強い意志をもって適切に行動すること。監査人が誠実であることによって信頼が築かれることから、誠実性は、自らの判断が信用される基礎となる。</p>

                        <h4>○ 客観性</h4>
                        <p>監査業務において、バイアス（先入観等）、利益相反を排し、個人や組織等から不当な影響を受けることなく、監査人としての判断を行うこと。監査人としての判断が不当な影響を受ける場合、当該業務を引き受けてはならない。</p>

                        <h4>○ 監査人としての能力及び正当な注意</h4>
                        <p>監査業務において、必要な知識、技能を習得し、維持すること、及び誤った監査上の判断がないように、システム監査の基準に従って、監査人として当然払うべき注意を払うこと。</p>

                        <h4>○ 秘密の保持</h4>
                        <p>監査業務において、取得した情報の秘密性を尊重し、業務上知り得た秘密を守ること。法令等による守秘義務の解除を除き、依頼人又は所属する組織との関係が終了した後も、秘密の保持が求められる。</p>
                    </div>
                </section>

                <section class="section" id="section-3">
                    <h2>システム監査の基準</h2>
                    
                    <h3>[1] システム監査の属性に係る基準</h3>

                    <h4>【基準1】システム監査に係る権限と責任等の明確化</h4>
                    <div class="standard-box">
                        <p>システム監査を実施する意義、目的、対象範囲、並びに監査人及びシステム監査を行う組織の権限と責任は、文書化された規程等により定められていなければならない。</p>
                    </div>
                    <div class="interpretation">
                        <p><strong>主旨：</strong>効果的かつ効率的なシステム監査を実現するための体制整備として、監査人及びシステム監査を行う組織の権限と責任を組織体の内部監査規程等によって明確にし、組織体全体に周知しておく必要がある。</p>
                    </div>

                    <h4>【基準2】専門的能力の保持と向上</h4>
                    <div class="standard-box">
                        <p>適切な教育・研修と実務経験を通じて、システム監査に必要な知識、技能及びその他の能力を保持し、その向上に努めなければならない。</p>
                        <p style="margin-top: 10px;">また、組織体のシステム監査を行う組織の長は、効果的かつ効率的なシステム監査に必要な知識、技能及びその他の能力を、システム監査を行う組織が総体として備えているか、又は備えるようにしなければならない。</p>
                    </div>

                    <h4>【基準3】システム監査に対するニーズの把握と品質の確保</h4>
                    <div class="standard-box">
                        <p>システム監査の実施に際し、システム監査に対するニーズを十分に把握した上でシステム監査業務を行い、システム監査の品質が確保されるための体制を整備・運用しなければならない。</p>
                    </div>

                    <h4>【基準4】監査の独立性と客観性の保持</h4>
                    <div class="standard-box">
                        <p>システム監査は、監査人によって誠実かつ、客観的に行われなければならない。</p>
                        <p style="margin-top: 10px;">さらに、監査人が監査対象の領域又は活動から、独立かつ客観的な立場で監査が実施されているという外観にも十分に配慮されなければならない。</p>
                    </div>

                    <h4>【基準5】監査の能力及び正当な注意と秘密の保持</h4>
                    <div class="standard-box">
                        <p>システム監査は、専門的能力の維持・向上を図るとともに、監査業務において正当な注意を払って実施する監査人によって行わなければならない。また、監査人は秘密の保持をしなければならない。</p>
                    </div>
                </section>

                <section class="section" id="section-4">
                    <h3>[2] システム監査の実施に係る基準</h3>

                    <h4>【基準6】監査計画の策定</h4>
                    <div class="standard-box">
                        <p>システム監査を効果的かつ効率的に実施するために、適切な監査計画が策定されなければならない。</p>
                        <p style="margin-top: 10px;">監査計画は、主として<span class="term" data-term="リスク・アプローチ">リスク・アプローチ</span>に基づいて策定する。</p>
                        <p style="margin-top: 10px;">監査計画は、リスク等の状況の変化に応じて適時適切に見直し、変更されなければならない。</p>
                    </div>

                    <h4>【基準7】監査計画の種類</h4>
                    <div class="standard-box">
                        <p>監査計画は、原則として中長期計画、年度計画、及び個別監査計画に分けて策定されなければならない。</p>
                    </div>

                    <h4>【基準8】監査証拠の入手と評価</h4>
                    <div class="standard-box">
                        <p>適切かつ慎重に監査手続を実施し、監査の結論を裏付けるための監査証拠を入手しなければならない。</p>
                    </div>

                    <h4>【基準9】監査調書の作成と保管</h4>
                    <div class="standard-box">
                        <p>監査の結論に至った過程を明らかにし、監査の結論を支える合理的な根拠とするために、監査調書を作成し、適切に保管しなければならない。</p>
                    </div>

                    <h4>【基準10】監査の結論の形成</h4>
                    <div class="standard-box">
                        <p>監査報告に先立って、監査調書の内容を詳細に検討し、合理的な根拠に基づき、監査の結論を導かなければならない。</p>
                    </div>
                </section>

                <section class="section" id="section-5">
                    <h3>[3] システム監査の報告に係る基準</h3>

                    <h4>【基準11】監査報告書の作成と報告</h4>
                    <div class="standard-box">
                        <p>監査報告書は、監査の目的に応じた適切な形式で作成され、監査の依頼者や適切な関係者に報告されなければならない。</p>
                    </div>

                    <h4>【基準12】改善提案（及び改善計画）のフォローアップ</h4>
                    <div class="standard-box">
                        <p>監査報告書に改善提案が記載されている場合、適切な措置が、適時に講じられているかどうかを確認するために、改善計画及びその実施状況に関する情報を収集し、改善状況をモニタリングしなければならない。監査報告書に改善計画が記載されている場合も同様にその実施状況をモニタリングしなければならない。</p>
                    </div>
                </section>

                <section class="section" id="section-6">
                    <h2>用語集</h2>
                    <p>システム監査基準で使用される主要な用語とその定義を以下に示します。</p>

                    <div id="glossaryContent"></div>
                </section>
            </main>
        </div>

        <div class="back-to-top" id="backToTop">↑</div>
    </div>

    <div class="tooltip" id="tooltip"></div>

    <script>
        // 用語辞書
        const glossary = {
            "システム監査": "監査人が、一定の基準に基づいてITシステムの利活用に係る検証・評価を行い、ガバナンスやマネジメント等について、一定の保証や改善のための助言を行うもの",
            "ITシステム": "IT、情報システム、データ・情報をまとめた概念。組織体の目的・目標の達成のために用いられる",
            "ガバナンス": "組織体のステークホルダーのニーズに基づいて、組織体の価値及び組織体への信頼を向上させるための仕組み。評価、指示、モニタリングを含む",
            "マネジメント": "ガバナンスによって設定された方向に、組織体の目標を達成させるために、戦略やリスク管理を計画し、体制等を構築し、業務を運営し、運営状況等をモニタリングする活動（PBRM）",
            "コントロール": "リスク・マネジメントのために取られる全ての管理手段。組織的、人的、技術的、物理的な手段がある。統制ともいわれる",
            "リスク・マネジメント": "組織体の目的・目標達成に関し、合理的な保証を提供するために、発生する可能性のある事象や状況を識別、評価し、コントロールするプロセス",
            "監査人": "システム監査を行う者。監査チームとしてシステム監査を行う場合に、当該集団を指すこともある",
            "リスク・アプローチ": "監査実施の優先度を監査対象先のリスクの大きさに基づいて決定する監査実施の方法。リスク・ベース監査ともいわれる"
        };

        // 目次生成
        const sections = [
            { id: 0, title: "前文（システム監査基準の活用に当たって）" },
            { id: 1, title: "システム監査の意義と目的" },
            { id: 2, title: "監査人の倫理" },
            { id: 3, title: "[1] システム監査の属性に係る基準" },
            { id: 4, title: "[2] システム監査の実施に係る基準" },
            { id: 5, title: "[3] システム監査の報告に係る基準" },
            { id: 6, title: "用語集" }
        ];

        const tocContainer = document.getElementById('tocContainer');
        sections.forEach(section => {
            const div = document.createElement('div');
            div.className = 'toc-item';
            div.textContent = section.title;
            div.onclick = () => scrollToSection(section.id);
            tocContainer.appendChild(div);
        });

        function scrollToSection(id) {
            document.getElementById(`section-${id}`).scrollIntoView({ behavior: 'smooth' });
            updateActiveToc(id);
        }

        function updateActiveToc(id) {
            document.querySelectorAll('.toc-item').forEach((item, index) => {
                item.classList.toggle('active', index === id);
            });
        }

        // 用語ツールチップ
        const tooltip = document.getElementById('tooltip');
        document.querySelectorAll('.term').forEach(term => {
            term.addEventListener('mouseenter', (e) => {
                const termText = e.target.getAttribute('data-term');
                const definition = glossary[termText];
                if (definition) {
                    tooltip.textContent = definition;
                    tooltip.style.display = 'block';
                    positionTooltip(e);
                }
            });

            term.addEventListener('mousemove', positionTooltip);

            term.addEventListener('mouseleave', () => {
                tooltip.style.display = 'none';
            });
        });

        function positionTooltip(e) {
            const x = e.clientX;
            const y = e.clientY;
            tooltip.style.left = (x + 15) + 'px';
            tooltip.style.top = (y + 15) + 'px';
        }

        // 検索機能
        const searchInput = document.getElementById('searchInput');
        let originalContent = '';
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const content = document.getElementById('mainContent');
            
            if (!originalContent) {
                originalContent = content.innerHTML;
            }

            if (searchTerm.length < 2) {
                content.innerHTML = originalContent;
                return;
            }

            // ハイライト表示
            let newContent = originalContent;
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            newContent = newContent.replace(/<span class="highlight">.*?<\/span>/g, (match) => {
                return match.replace(/<\/?span[^>]*>/g, '');
            });
            newContent = newContent.replace(regex, '<span class="highlight">$1</span>');
            content.innerHTML = newContent;
        });

        // トップへ戻るボタン
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // 用語集の生成
        const glossaryContent = document.getElementById('glossaryContent');
        Object.entries(glossary).forEach(([term, definition]) => {
            const termDiv = document.createElement('div');
            termDiv.className = 'interpretation';
            termDiv.innerHTML = `<h4>${term}</h4><p>${definition}</p>`;
            glossaryContent.appendChild(termDiv);
        });

        // スクロール時のアクティブセクション更新
        window.addEventListener('scroll', () => {
            const scrollPosition = window.scrollY + 100;
            
            sections.forEach((section, index) => {
                const element = document.getElementById(`section-${section.id}`);
                if (element) {
                    const top = element.offsetTop;
                    const bottom = top + element.offsetHeight;
                    
                    if (scrollPosition >= top && scrollPosition < bottom) {
                        updateActiveToc(index);
                    }
                }
            });
        });
    </script>
