import sys
import os
sys.path.append(os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))
from setting_file.header import *
from google.oauth2 import service_account
from googleapiclient.discovery import build
from datetime import datetime, timedelta
from setting_file.Search_Console_set.qshaoh_noindex_url import URLS as Individual_urls

# ================ 設定 ================
SERVICE_ACCOUNT_FILE = api_json.qsha_oh
site_url = 'https://www.qsha-oh.com/'
URLS = Individual_urls  # URLリスト
file_directory = file_path.file_directory
file_name = "Index_Status_Report_JP.csv"
output_file = os.path.join(file_directory, file_name)
# =====================================

# Search Console API（URL Inspection API）
credentials = service_account.Credentials.from_service_account_file(
    SERVICE_ACCOUNT_FILE,
    scopes=['https://www.googleapis.com/auth/webmasters.readonly']
)
inspection_service = build('searchconsole', 'v1', credentials=credentials)

# CSV ヘッダー
header_row = [
    'URL',
    'インデックス状態',
    '未登録の理由',
    'canonical URL',
    'robots.txt 状態',
    'Fetch 状態',
    'Serving 状態'
]


# ================================
# 🔥 Search Console URL Inspection API
#  canonical / robots / fetch / serving を CSV 出力
# ================================

def translate_index_status(result):
    """
    Search Console UI と完全一致させた日本語理由判定
    """
    status = result.get("coverageState", "")
    robots_state = result.get("robotsTxtState", "")
    fetch_state = result.get("pageFetchState", "")
    indexing_state = result.get("indexingState", "")
    verdict = result.get("verdict", "")
    canonical = result.get("canonicalUrl", "")
    ref_canonical = result.get("refCanonical", "")
    serving = result.get("servingStatus", "")

    # ✅ インデックス登録済み
    if serving == "SERVING":
        return "✅ 登録済み", "-"

    # ❌ 未登録理由マッピング（Search Console UI と対応）

    if status == "Excluded by ‘noindex’ tag" or "noindex" in status.lower():
        return "❌ 未登録", "noindex タグによって除外されました"

    if robots_state == "BLOCKED_BY_ROBOTS_TXT":
        return "❌ 未登録", "robots.txt によりブロックされました"

    if verdict == "REDIRECTED":
        return "❌ 未登録", "ページにリダイレクトがあります"

    if fetch_state == "NOT_FOUND":
        return "❌ 未登録", "見つかりませんでした（404）"

    if indexing_state == "PAGE_INDEXING_ISSUE":
        return "❌ 未登録", "クロール済み - インデックス未登録"

    if canonical and canonical != ref_canonical:
        return "❌ 未登録", "代替ページ（適切な canonical タグあり）"

    if verdict == "DUPLICATE" or (ref_canonical and canonical != ref_canonical):
        return "❌ 未登録", "重複しています（Google により別ページが正規ページとして選択されました）"

    return "❌ 未登録", status


def inspect_url(url):
    """URL Inspection API を実行し CSV に必要な情報を返す"""
    request = {
        "inspectionUrl": url,
        "siteUrl": site_url,
    }

    try:
        response = inspection_service.urlInspection().index().inspect(body=request).execute()
        result = response.get("inspectionResult", {})

        index_data = result.get("indexStatusResult", {})

        index_status, reason = translate_index_status(index_data)

        canonical_url = index_data.get("canonicalUrl", "")
        robots_state = index_data.get("robotsTxtState", "")
        fetch_state = index_data.get("pageFetchState", "")
        serving = index_data.get("servingStatus", "")

        return [url, index_status, reason, canonical_url, robots_state, fetch_state, serving]

    except Exception as e:
        return [url, "エラー", str(e), "", "", "", ""]

def main():
    indexed_count = 0
    not_indexed_count = 0
    reason_count = {}

    with open(output_file, 'w', newline='', encoding='utf-8') as csvfile:
        csv_writer = csv.writer(csvfile)
        csv_writer.writerow(header_row)

        for url in URLS:
            delay = random.uniform(1.0, 2.5)
            time.sleep(delay)

            row = inspect_url(url)
            csv_writer.writerow(row)

            # ログ（日本語）
            print(f"URL: {row[0]}")
            print(f" ▶ インデックス状態: {row[1]}")
            print(f" ▶ 理由: {row[2]}")
            print("-------------------------------------------")

            # 集計処理
            if row[1] == "✅ 登録済み":
                indexed_count += 1
            else:
                not_indexed_count += 1
                reason_count[row[2]] = reason_count.get(row[2], 0) + 1

    print("\n============================")
    print("📊 インデックス結果まとめ")
    print("============================")
    print(f"✅ 登録済みページ数: {indexed_count}")
    print(f"❌ 未登録ページ数: {not_indexed_count}")
    print("\n📌 未登録理由内訳:")

    for reason, count in reason_count.items():
        print(f"・{reason}: {count} 件")

    print(f"\n📁 CSV出力しました → {output_file}")


if __name__ == "__main__":
    main()
