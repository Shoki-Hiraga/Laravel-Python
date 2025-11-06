import os
import re

# 元ファイルパス
input_path = r"C:\Users\hiraga\Downloads\spolab_wp_posts.sql"
# 出力ファイルパス
base_name = os.path.basename(input_path)
output_path = os.path.join(
    os.path.dirname(input_path),
    f"del_{base_name}"
)

# 抽出カラム
target_columns = ["ID", "post_title", "post_content", "post_name"]

# AUTO_INCREMENT 値を格納する変数
auto_increment_value = None

with open(input_path, "r", encoding="utf-8") as infile, \
     open(output_path, "w", encoding="utf-8") as outfile:

    # ヘッダー部分（phpMyAdmin系コメント）はそのままコピー
    for line in infile:
        outfile.write(line)
        # CREATE TABLE 部分に到達する直前で停止
        if line.strip().startswith("-- テーブルの構造"):
            break

    # CREATE TABLE 部分を置き換え
    outfile.write(f"""
CREATE TABLE `del_spolab_wp_posts` (
  `ID` bigint(20) UNSIGNED NOT NULL,
  `post_title` text NOT NULL,
  `post_content` longtext NOT NULL,
  `post_name` varchar(200) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- テーブルのデータのダンプ `del_spolab_wp_posts`
--
""")

    # データ部を探す
    col_index_map = {}
    for line in infile:
        # AUTO_INCREMENT の値を取得
        if "AUTO_INCREMENT=" in line:
            match_ai = re.search(r"AUTO_INCREMENT=(\d+)", line)
            if match_ai:
                auto_increment_value = match_ai.group(1)

        # INSERT 文のカラム定義を取得
        if "INSERT INTO" in line and "(" in line:
            match = re.search(r"\((.*?)\)", line)
            if match:
                columns = [c.strip(" `") for c in match.group(1).split(",")]
                col_index_map = {name: idx for idx, name in enumerate(columns) if name in target_columns}

                # 新しい INSERT 文のヘッダーを書き込み
                new_cols = ", ".join(target_columns)
                outfile.write(f"INSERT INTO `del_spolab_wp_posts` ({new_cols}) VALUES\n")
                continue

        # データ行を変換
        if col_index_map and line.strip().startswith("("):
            # 複数レコードを , 区切りで処理（クォート内カンマ回避）
            records = re.findall(r"\((.*?)\)", line)
            new_records = []
            for rec in records:
                values = [v.strip() for v in re.split(r",(?![^']*'\s*,\s*[^']*')", rec)]
                filtered_values = [values[col_index_map[col]] for col in target_columns]
                new_records.append(f"({', '.join(filtered_values)})")

            outfile.write(",\n".join(new_records))
            if line.strip().endswith(";"):
                outfile.write(";\n")
            else:
                outfile.write(",\n")

    # インデックスと AUTO_INCREMENT 設定を追加
    outfile.write(f"""
--
-- ダンプしたテーブルのインデックス
--
ALTER TABLE `del_spolab_wp_posts`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `post_name` (`post_name`(191));

--
-- ダンプしたテーブルの AUTO_INCREMENT
--
ALTER TABLE `del_spolab_wp_posts`
  MODIFY `ID` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT={auto_increment_value if auto_increment_value else 1};

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
""")

print(f"✅ 完了しました！ 出力ファイル: {output_path}")
