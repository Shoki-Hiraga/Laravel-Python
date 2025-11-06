import os
import re
import shutil

sql_file = r"C:\Users\hiraga\Downloads\wp_posts_media_historia.sql"
images_dir = r"C:\Users\hiraga\Downloads\spor_images"
output_dir = r"C:\Users\hiraga\Downloads\spor_images_get"

os.makedirs(output_dir, exist_ok=True)

with open(sql_file, "r", encoding="utf-8", errors="ignore") as f:
    sql_content = f.read()

# URLそのものを抽出（拡張子ごと）
url_pattern = r"https://www\.sportscar-lab\.com/wp-content/uploads/[^\s\"']+\.(?:jpg|jpeg|png|gif)"
urls = re.findall(url_pattern, sql_content, flags=re.IGNORECASE)

# ファイル名に変換
filenames = set([os.path.basename(url) for url in urls])

print(f"SQL内で検出された画像ファイル数: {len(filenames)}")
print("抽出ファイル名一覧:", filenames)

# フォルダ内のファイルを小文字マップ化
all_images = {f.lower(): f for f in os.listdir(images_dir)}

copied = 0
for fname in filenames:
    fname_lower = fname.lower()
    if fname_lower in all_images:
        src_path = os.path.join(images_dir, all_images[fname_lower])
        dst_path = os.path.join(output_dir, all_images[fname_lower])
        shutil.copy2(src_path, dst_path)
        copied += 1
    else:
        print(f"見つからない: {fname}")

print(f"コピー完了: {copied} 件の画像を {output_dir} に保存しました。")
