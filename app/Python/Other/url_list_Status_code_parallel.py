import requests
import csv
from concurrent.futures import ThreadPoolExecutor, as_completed
from typing import List, Dict, Optional
from url_list_Status_code_URL import target_urls
import time

# =====================================
# 設定エリア
# =====================================

# 同時アクセス数（増やすと速い。10〜30がバランス良い）
MAX_WORKERS = 30

# タイムアウト（秒）
TIMEOUT = 8

# CSV出力パス
CSV_OUTPUT_PATH = r"C:\Users\hiraga\Downloads\status_code_check.csv"

# =====================================
# URL 1件のステータスコード取得処理
# =====================================
def fetch_status(url: str) -> Dict[str, Optional[int]]:
    """
    指定されたURLにHEADリクエストを送り、ステータスコードを返す。
    エラー時はNoneとエラー内容を返す。
    """
    result = {"URL": url, "ステータスコード": None, "エラー内容": ""}

    try:
        response = requests.head(url, timeout=TIMEOUT, allow_redirects=True)
        result["ステータスコード"] = response.status_code
    except requests.exceptions.RequestException as e:
        result["エラー内容"] = str(e)
    except Exception as e:
        result["エラー内容"] = f"予期せぬエラー: {e}"

    return result


# =====================================
# 並列で全URLを処理
# =====================================
def get_status_codes_parallel(urls: List[str], max_workers: int = 10) -> List[Dict[str, Optional[int]]]:
    """
    URLリストを並列でHEADリクエストし、結果リストを返す。
    """
    results = []
    total = len(urls)
    start_time = time.time()
    print(f"--- 並列アクセス開始 ({total} 件, 同時 {max_workers} 並列) ---")

    with ThreadPoolExecutor(max_workers=max_workers) as executor:
        future_to_url = {executor.submit(fetch_status, url): url for url in urls}
        for count, future in enumerate(as_completed(future_to_url), start=1):
            result = future.result()
            results.append(result)
            url = result["URL"]
            code = result.get("ステータスコード")
            error = result.get("エラー内容")

            if error:
                print(f"[{count}/{total}] ❌ {url} -> {error}")
            else:
                print(f"[{count}/{total}] ✅ {url} -> {code}")

    elapsed = round(time.time() - start_time, 2)
    print(f"--- 並列アクセス完了: {total} 件 ({elapsed} 秒) ---")

    return results


# =====================================
# CSV出力処理（全キー対応）
# =====================================
def write_to_csv(data: List[Dict], file_path: str):
    """
    結果をCSVとして出力。
    データ中のすべてのキーを自動的に列として認識。
    """
    if not data:
        print("出力するデータがありません。")
        return

    # ✅ データ中のすべてのキーを集約（列構造が不統一でもOK）
    fieldnames = sorted({key for row in data for key in row.keys()})

    try:
        with open(file_path, 'w', newline='', encoding='utf-8-sig') as csvfile:
            writer = csv.DictWriter(csvfile, fieldnames=fieldnames, extrasaction='ignore')
            writer.writeheader()
            writer.writerows(data)

        print(f"\n✅ CSVファイル出力完了: {file_path}")
    except IOError as e:
        print(f"\n❌ ファイル出力エラー: {file_path}")
        print(f"エラー詳細: {e}")


# =====================================
# メイン処理
# =====================================
if __name__ == "__main__":
    # URLリスト確認
    total_urls = len(target_urls)
    print(f"対象URL数: {total_urls} 件")

    if total_urls == 0:
        print("URLリストが空です。'url_list_Status_code_URL.py'を確認してください。")
    else:
        # 1. 並列アクセスでステータスコード取得
        status_data = get_status_codes_parallel(target_urls, max_workers=MAX_WORKERS)

        # 2. CSV出力
        write_to_csv(status_data, CSV_OUTPUT_PATH)
