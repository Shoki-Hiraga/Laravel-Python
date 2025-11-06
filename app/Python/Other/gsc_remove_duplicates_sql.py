import os
import re
from collections import OrderedDict

# 対象ファイルパス（GSC用）
input_path = r'C:\Users\hiraga\Downloads\del_gsc_qsha_oh_maker.sql'
base_name = os.path.splitext(os.path.basename(input_path))[0]
output_path = os.path.join(os.path.dirname(input_path), f'{base_name}_delete.sql')

# INSERT文パターン（GSCテーブル用）
insert_pattern = re.compile(
    r"INSERT INTO `gsc_qsha_oh_maker`.*?VALUES\s*(.*);", re.DOTALL)

# レコード（タプル）パターン
tuple_pattern = re.compile(r"\((.*?)\)", re.DOTALL)

# 重複を排除するためのキーと行を保持
unique_records = OrderedDict()

with open(input_path, 'r', encoding='utf-8') as f:
    content = f.read()

# INSERT文を抽出
match = insert_pattern.search(content)
if match:
    values_block = match.group(1)

    for record_str in tuple_pattern.findall(values_block):
        # カンマで分割（カンマを含む文字列対応）
        parts = [x.strip() for x in re.split(r",(?=(?:[^']*'[^']*')*[^']*$)", record_str)]

        # 重複判定用キー（5項目）
        dedup_key = tuple(parts[1:6])  # page_url 〜 avg_position

        if dedup_key not in unique_records:
            unique_records[dedup_key] = record_str

    # SQLの再構築
    insert_header = "INSERT INTO `gsc_qsha_oh_maker` (`id`, `page_url`, `total_impressions`, `total_clicks`, `avg_ctr`, `avg_position`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES\n"
    insert_values = ",\n".join(f"({v})" for v in unique_records.values()) + ";"

    with open(output_path, 'w', encoding='utf-8') as out:
        out.write(insert_header + insert_values)

    print(f"✅ 重複を削除したファイルを保存しました: {output_path}")
else:
    print("❌ INSERT文が見つかりませんでした。ファイルの形式を確認してください。")
