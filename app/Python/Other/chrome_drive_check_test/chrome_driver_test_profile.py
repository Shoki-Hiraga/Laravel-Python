from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time

# ==== 設定ここから ====
# ChromeのUser Dataディレクトリ
USER_DATA_DIR = r"C:\Users\hiraga\AppData\Local\Google\Chrome\User Data"

# テストしたいプロファイル名 (例: "Default", "Profile 1", "Profile 2", ...)
PROFILE_NAME = "Profile 1"
# ==== 設定ここまで ====

options = webdriver.ChromeOptions()

# プロファイル指定
options.add_argument(f"user-data-dir={USER_DATA_DIR}")
options.add_argument(f"--profile-directory={PROFILE_NAME}")

# 追加オプション（安定化用）
options.add_argument("--disable-gpu")
options.add_argument("--no-sandbox")

# Chrome起動
driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# Googleログインページを開いて確認
driver.get("https://www.google.com")
time.sleep(5)  # 表示確認用の待機

print(f"✅ 起動しました！ プロファイル: {PROFILE_NAME}")

# 必要に応じて自動終了
# driver.quit()
