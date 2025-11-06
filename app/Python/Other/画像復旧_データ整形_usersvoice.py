import pandas as pd
from datetime import datetime
from rapidfuzz import fuzz

# --- 設定 ---
SIMILARITY_THRESHOLD = 83       # 類似度スコアの閾値
MIN_COMMON_LENGTH = 4           # 共通文字数が少なすぎるものは除外
VOICE_CSV = r"C:\Users\hiraga\Downloads\画像チェック\Python調整用_旧車王_画像復旧 - usersvoices.csv"
SF_CSV = r"C:\Users\hiraga\Downloads\画像チェック\Python調整用_旧車王_画像復旧 - SFデータ.csv"
OUTPUT_CSV = r"C:\Users\hiraga\Downloads\画像チェック\マッチング結果_usersvoices.csv"

# --- CSV読み込み ---
voice_df = pd.read_csv(VOICE_CSV)
sf_df = pd.read_csv(SF_CSV)

# --- 日付を yyyy-mm-01 に整形（前回動いていた処理を維持） ---
voice_df['purchased_ymd'] = pd.to_datetime(voice_df['purchased_at'], errors='coerce').dt.to_period('M').dt.to_timestamp()
sf_df['査定日時_ymd'] = pd.to_datetime(sf_df['査定日時'], errors='coerce').dt.to_period('M').dt.to_timestamp()

# --- 出力リスト初期化 ---
matched_rows = []

# --- マッチング処理 ---
for idx_voice, voice_row in voice_df.iterrows():
    voice_model = str(voice_row['model_name'])
    voice_date = voice_row['purchased_ymd']
    
    for idx_sf, sf_row in sf_df.iterrows():
        sf_model = str(sf_row['商談: 車種名（グレード名）'])
        sf_date = sf_row['査定日時_ymd']

        # 類似度スコア計算
        similarity = fuzz.partial_ratio(voice_model, sf_model)

        # 共通文字数の確認
        common_chars = set(voice_model) & set(sf_model)
        common_length = len(common_chars)

        # 文字列長の比較
        len_voice = len(voice_model)
        len_sf = len(sf_model)

        # 🚫 詳細モデル名（長い）→ 汎用名（短い）のケースは除外
        if len_voice > len_sf and sf_model in voice_model:
            continue

        # ✅ 判定条件
        if (
            similarity >= SIMILARITY_THRESHOLD
            and pd.notnull(voice_date)
            and pd.notnull(sf_date)
            and voice_date == sf_date
            and common_length >= MIN_COMMON_LENGTH
        ):
            combined_row = voice_row.to_dict()
            # --- SFデータの追加カラム ---
            combined_row['SF_管理番号'] = sf_row.get('管理番号', '')
            combined_row['SF_商談車種名'] = sf_model
            combined_row['SF_メーカー名(通称)'] = sf_row.get('メーカー名(通称)', '')
            combined_row['SF_査定日時'] = sf_row.get('査定日時', '')
            combined_row['SF_SLACK_URL'] = sf_row.get('SLACK-URL', '')
            combined_row['SF_走行距離(km)'] = sf_row.get('【★】走行距離(km)', '')
            combined_row['SF_車輌本体買取価格（税込）'] = sf_row.get('車輌本体買取価格（税込）', '')
            combined_row['一致スコア'] = similarity
            matched_rows.append(combined_row)

# --- 出力処理 ---
if matched_rows:
    matched_df = pd.DataFrame(matched_rows)
    matched_df.to_csv(OUTPUT_CSV, index=False, encoding='utf-8-sig')
    print(f"✅ マッチング結果を出力しました: {OUTPUT_CSV}")
else:
    print("⚠ 一致するデータが見つかりませんでした。")
