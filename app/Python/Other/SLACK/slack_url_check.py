import time
from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager

# ====== 設定 ======
USER_DATA_DIR = r"C:\Users\hiraga\AppData\Local\Google\Chrome\User Data Selenium"
PROFILE_NAME = "Profile 1"

# SlackスレッドURLリスト
post_data = [
    "https://app.slack.com/client/TP23BV3JN/G01JYK55H5W/thread/G01JYK55H5W-1757899617.155009",
    "https://app.slack.com/client/TP23BV3JN/G01JYK55H5W/thread/G01JYK55H5W-1757749431.512759",
    "https://app.slack.com/client/TP23BV3JN/G01JYK55H5W/thread/G01JYK55H5W-1758439911.726769",
]
# 1件あたりの閲覧待機時間（秒）
VIEW_DELAY = 8
# ==================

# Chrome 起動（ログイン済みのユーザープロファイルを利用）
options = webdriver.ChromeOptions()
options.add_argument(f"user-data-dir={USER_DATA_DIR}")
options.add_argument(f"--profile-directory={PROFILE_NAME}")

driver = webdriver.Chrome(
    service=Service(ChromeDriverManager().install()),
    options=options
)

for idx, post_url in enumerate(post_data, start=1):
    print(f"\n🔎 スレッドを開きます ({idx}/{len(post_data)}): {post_url}")
    driver.get(post_url)
    time.sleep(VIEW_DELAY)

print("\n✅ 全てのスレッド閲覧が完了しました")
driver.quit()
