import os
import re

# 対象ファイルパス（重複削除後のファイル）
# input_path = r'C:\Users\hiraga\Downloads\del_ga4_qsha_oh_maker_delete.sql'
input_path = r'C:\Users\hiraga\Downloads\del_gsc_qsha_oh_maker_delete.sql'
output_path = input_path.replace(".sql", "_reindexed.sql")

# INSERT文の正規表現パターン
insert_pattern = re.compile(
    # r"(INSERT INTO `ga4_qsha_oh_maker`.*?VALUES\s*)(.*);", re.DOTALL)
    r"(INSERT INTO `gsc_qsha_oh_maker`.*?VALUES\s*)(.*);", re.DOTALL)

# タプルの抽出パターン
tuple_pattern = re.compile(r"\((.*?)\)", re.DOTALL)

with open(input_path, 'r', encoding='utf-8') as f:
    content = f.read()

match = insert_pattern.search(content)
if not match:
    print("❌ INSERT文が見つかりませんでした。")
else:
    insert_header = match.group(1)
    values_block = match.group(2)

    tuples = tuple_pattern.findall(values_block)
    new_rows = []

    for idx, row in enumerate(tuples, start=1):
        parts = [x.strip() for x in re.split(r",(?=(?:[^']*'[^']*')*[^']*$)", row)]
        parts[0] = str(idx)  # IDを振り直し
        new_rows.append(f"({', '.join(parts)})")

    new_insert_sql = insert_header + "\n" + ",\n".join(new_rows) + ";"

    with open(output_path, 'w', encoding='utf-8') as f_out:
        f_out.write(new_insert_sql)

    print(f"✅ IDを1から再割り当てしたファイルを保存しました: {output_path}")
