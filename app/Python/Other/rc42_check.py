import sys
import os
sys.path.append(os.path.join(os.path.dirname(__file__), 'other_settingfile'))

import requests
from bs4 import BeautifulSoup
import time
from other_settingfile.rc42_mail import send_notification
from other_settingfile.rc42_mail import send_notification, send_no_match_notification

# === グローバル変数 ===
BASE_URL = "https://www.goobike.com/maker-honda/car-cb750/index{}.html"
HEADERS = {
    "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64)"
}
PAGINATION_MIN = 1
PAGINATION_MAX = 50

# CSSセレクタ
NO_RESULT_SELECTOR = "tr:nth-of-type(2) [align] span"
DETAIL_LINK_SELECTOR = "span a.detail_kakaku_link"
DETAIL_DATA_SELECTORS = [
    "dt + dd > span", 
    "td[width='15%']:nth-of-type(2)",
    "td[width='15%']:nth-of-type(4)",
]

# 判定用テキスト
NO_RESULT_TEXT = "ご希望の条件に該当するバイクは登録されていませんでした。"

TARGET_SERIAL = "166"

SLEEP_TIME = 2

# === 関数 ===
def get_page_content(url):
    response = requests.get(url, headers=HEADERS)
    response.encoding = "EUC-JP"
    if response.status_code == 200:
        return BeautifulSoup(response.text, "html.parser")
    return None

def is_no_result_page(soup):
    target = soup.select_one(NO_RESULT_SELECTOR)
    return target and NO_RESULT_TEXT in target.text

def scrape_detail_page(detail_url):
    soup = get_page_content(detail_url)
    if soup:
        print("📌 取得データ:")
        match_found = False  # ← 一致判定フラグ

        for selector in DETAIL_DATA_SELECTORS:
            elements = soup.select(selector)
            if elements:
                for el in elements:
                    text = el.text.strip()
                    print(f"・{text}")
                    if f"車台番号下3桁：{TARGET_SERIAL}" in text:
                        match_found = True
            else:
                print(f"・[未取得] セレクタ: {selector}")
        
        if match_found:
            send_notification(detail_url)

        print("-" * 40)


def main():
    match_found = False  # ← ここで全体の一致フラグを定義

    for page in range(PAGINATION_MIN, PAGINATION_MAX + 1):
        print(f"📄 ページ {page} を処理中...")
        url = BASE_URL.format(page)
        soup = get_page_content(url)
        if not soup:
            print("⚠️ ページの取得に失敗しました。")
            break

        if is_no_result_page(soup):
            print("✅ バイクが登録されていません。スクレイピングを終了します。")
            break

        detail_links = soup.select(DETAIL_LINK_SELECTOR)
        for link in detail_links:
            detail_url = link.get("href")
            if detail_url:
                full_url = "https://www.goobike.com" + detail_url
                print(f"🔍 詳細ページ: {full_url}")
                # scrape_detail_page から一致フラグを受け取るようにする
                if scrape_detail_page(full_url):
                    match_found = True
                time.sleep(SLEEP_TIME)

        time.sleep(SLEEP_TIME)

    # 一致しなかった場合に通知を送る
    if not match_found:
        send_no_match_notification()

if __name__ == "__main__":
    main()

