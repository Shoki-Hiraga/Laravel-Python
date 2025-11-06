import re
import csv
import os

# --- 入力ファイルパス ---
file_path = r"C:\Users\hiraga\Downloads\ima_path.sql"
# SQL側カラム INSERT INTO `posts` (`id`, `title`, `body`, `slug`) VALUES

# --- 出力ファイル名 ---
base_name = os.path.splitext(os.path.basename(file_path))[0]
output_path = os.path.join(os.path.dirname(file_path), f"{base_name}_getpath.csv")

# --- ファイル読み込み ---
try:
    with open(file_path, "r", encoding="utf-8") as f:
        sql_text = f.read()
except Exception as e:
    print(f"❌ ファイルを読み込めませんでした: {e}")
    exit(1)

# --- SQLレコード抽出 ---
# INSERT文内の (id, 'title', 'body', 'slug') をすべてキャプチャ
record_pattern = re.compile(
    r"\(\s*(\d+)\s*,\s*'((?:[^'\\]|\\.)*)'\s*,\s*'((?:[^'\\]|\\.)*)'\s*,\s*'((?:[^'\\]|\\.)*)'\s*\)",
    re.DOTALL
)

records = record_pattern.findall(sql_text)
if not records:
    print("⚠️ SQLファイルからレコードを検出できませんでした。フォーマットを確認してください。")
    exit(0)

print(f"✅ {len(records)} 件のレコードを検出しました。img src を抽出中...")

# --- img src 抽出パターン ---
img_pattern = re.compile(r'<img\s+[^>]*?src=[\'"]([^\'"]+)[\'"]', re.IGNORECASE)

# --- CSV準備 ---
output_rows = [["id", "title", "body", "slug"]]

for record in records:
    post_id, title_raw, body_raw, slug_raw = record

    # SQLエスケープ解除
    def unescape_sql(s: str) -> str:
        return s.replace(r"\'", "'").replace(r'\"', '"').replace(r"\\", "\\")

    title = unescape_sql(title_raw)
    body = unescape_sql(body_raw)
    slug = unescape_sql(slug_raw)

    # img src 抽出
    img_urls = img_pattern.findall(body)
    if not img_urls:
        continue

    for url in img_urls:
        output_rows.append([post_id, title, url, slug])

# --- CSV出力 ---
if len(output_rows) > 1:
    try:
        with open(output_path, "w", newline="", encoding="utf-8-sig") as csvfile:
            writer = csv.writer(csvfile)
            writer.writerows(output_rows)
        print(f"✅ CSV出力完了: {output_path}")
    except Exception as e:
        print(f"❌ CSV出力中にエラー: {e}")
else:
    print("⚠️ img src が見つかりませんでした。CSVは出力されません。")
