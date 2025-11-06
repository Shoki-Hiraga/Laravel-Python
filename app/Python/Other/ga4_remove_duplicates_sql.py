import os
import re
from collections import OrderedDict

# 元ファイルと出力ファイルのパス設定
input_path = r'C:\Users\hiraga\Downloads\del_ga4_qsha_oh_maker.sql'
base_name = os.path.splitext(os.path.basename(input_path))[0]
output_path = os.path.join(os.path.dirname(input_path), f'{base_name}_delete.sql')

# INSERT文の正規表現パターン（テーブル名に依存）
insert_pattern = re.compile(
    r"INSERT INTO `ga4_qsha_oh_maker`.*?VALUES\s*(.*);", re.DOTALL)

# 1行ずつのタプルに分割
tuple_pattern = re.compile(r"\((.*?)\)", re.DOTALL)

# データを一時的に格納するOrderedDict（重複排除）
unique_records = OrderedDict()

with open(input_path, 'r', encoding='utf-8') as f:
    content = f.read()

# INSERT文部分を抽出
match = insert_pattern.search(content)
if match:
    values_block = match.group(1)

    # 各レコードの抽出
    for record_str in tuple_pattern.findall(values_block):
        # カンマ区切りのパース（カンマ付き文字列への対処）
        record_parts = [x.strip() for x in re.split(r",(?=(?:[^']*'[^']*')*[^']*$)", record_str)]
        
        # 識別キーの作成：重複を判定する対象5カラム
        dedup_key = tuple(record_parts[1:6])  # landing_url〜cvr
        
        # 最初の1件だけ残す
        if dedup_key not in unique_records:
            unique_records[dedup_key] = record_str

    # 新しいINSERT文の作成
    insert_header = "INSERT INTO `ga4_qsha_oh_maker` (`id`, `landing_url`, `session_medium`, `total_sessions`, `cv_count`, `cvr`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES\n"
    insert_values = ",\n".join(f"({v})" for v in unique_records.values()) + ";"

    with open(output_path, 'w', encoding='utf-8') as out:
        out.write(insert_header + insert_values)

    print(f"✅ 重複を削除したファイルを保存しました: {output_path}")
else:
    print("❌ INSERT文が見つかりませんでした。ファイル内容をご確認ください。")
