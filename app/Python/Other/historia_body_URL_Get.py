import csv
import re
import os

def extract_image_urls_from_csv(input_path):
    """
    CSVファイルの'body'列から指定されたドメインの画像URLを抽出し、
    新しいCSVファイルとして出力します。

    Args:
        input_path (str): 入力するCSVファイルのパス。
    """
    # --- 1. ファイルパスの設定 ---
    # 出力ファイル名を作成
    base_name = os.path.basename(input_path)  # 元のファイル名を取得 (e.g., "posts_body.csv")
    name_without_ext = os.path.splitext(base_name)[0] # 拡張子を除いた名前を取得 (e.g., "posts_body")
    output_name = f"{name_without_ext}_加工後データ.csv"
    
    # 元のファイルと同じディレクトリに出力パスを作成
    output_path = os.path.join(os.path.dirname(input_path), output_name)

    # --- 2. URL抽出のための正規表現パターン ---
    # 'https://assets.qsha-oh.com/' で始まり、src="..." の中にあるURLを抽出
    # re.compileでパターンを事前にコンパイルしておくと、繰り返し使う場合に効率的です
    url_pattern = re.compile(r'src="(https://assets\.qsha-oh\.com/[^"]+)"')

    try:
        # --- 3. データの読み込みと処理 ---
        processed_data = []
        
        # 'utf-8'でファイルを開きます。もし文字化けする場合は 'cp932' を試してください。
        with open(input_path, 'r', encoding='utf-8', newline='') as infile:
            reader = csv.reader(infile)
            
            # ヘッダー行を読み込んで、そのまま出力データに追加
            header = next(reader)
            processed_data.append(header)

            # 1行ずつデータを処理
            for row in reader:
                if len(row) < 2:  # body列がない行はスキップ
                    continue
                    
                post_id = row[0]
                body_html = row[1]
                
                # 正規表現に一致するすべてのURLをリストとして抽出
                image_urls = url_pattern.findall(body_html)
                
                # 抽出したURLリストを '*' で連結
                # 該当URLがない場合は空文字になります
                joined_urls = '*'.join(image_urls)
                
                # IDと加工後のURL文字列をリストに追加
                processed_data.append([post_id, joined_urls])

        # --- 4. 新しいCSVファイルへの書き込み ---
        with open(output_path, 'w', encoding='utf-8', newline='') as outfile:
            writer = csv.writer(outfile)
            writer.writerows(processed_data)
            
        print(f"✅ 処理が完了しました！")
        print(f"出力ファイル: {output_path}")

    except FileNotFoundError:
        print(f"❌ エラー: ファイルが見つかりませんでした。")
        print(f"パスを確認してください: {input_path}")
    except Exception as e:
        print(f"❌ エラーが発生しました: {e}")

# --- 実行 ---
if __name__ == '__main__':
    # ここに処理したいCSVファイルのフルパスを指定してください
    target_file_path = r"C:\Users\hiraga\Downloads\posts_body.csv"
    extract_image_urls_from_csv(target_file_path)