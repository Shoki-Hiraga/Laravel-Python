import requests
import csv
from typing import List, Dict, Optional
from url_list_Status_code_URL import target_urls

# Other\historia_imagepath_get.py で加工されたCSVデータを id,title,body,slug で整形して画像パスを整形する。

# CSVの出力パス
CSV_OUTPUT_PATH = r"C:\Users\hiraga\Downloads\img_path_check.csv"

def get_status_codes(urls: List[str]) -> List[Dict[str, Optional[int]]]:
    """
    指定されたURLのリストにアクセスし、URLとHTTPステータスコードを含む
    辞書のリストを返します。
    """
    results = []
    
    print("--- アクセス開始 ---")
    
    for url in urls:
        status_code = None # 初期値をNoneに設定
        print(f"URL: {url} にアクセス中...", end=" ")
        try:
            # HEADリクエストを使用し、リダイレクトを許可
            response = requests.head(url, timeout=10, allow_redirects=True)
            status_code = response.status_code
            print(f"完了 (コード: {status_code})")
        except requests.exceptions.RequestException as e:
            # 接続エラーやタイムアウトなど
            print(f"エラー: {e}")
        except Exception as e:
            # その他の予期せぬエラー
            print(f"予期せぬエラー: {e}")

        # 結果をリストに追加 (コードがNoneの場合はNoneを記録)
        results.append({
            "URL": url,
            "ステータスコード": status_code
        })

    print("--- アクセス完了 ---")
    return results

def write_to_csv(data: List[Dict], file_path: str):
    """
    取得したデータを指定されたパスにCSVファイルとして出力します。
    """
    if not data:
        print("出力するデータがありません。")
        return

    # 辞書のキーをヘッダーとして使用
    fieldnames = ["URL", "ステータスコード"]
    
    try:
        with open(file_path, 'w', newline='', encoding='utf-8') as csvfile:
            writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
            
            # ヘッダー行を書き込み
            writer.writeheader()
            
            # データ行を書き込み
            writer.writerows(data)
        
        print(f"\n✅ CSVファイルに正常に出力されました: {file_path}")
    except IOError as e:
        print(f"\n❌ ファイル出力エラー: {file_path} に書き込めませんでした。パスを確認してください。")
        print(f"エラー詳細: {e}")


# 1. ステータスコードを取得
status_data = get_status_codes(target_urls)

# 2. 結果をCSVファイルに出力
write_to_csv(status_data, CSV_OUTPUT_PATH)