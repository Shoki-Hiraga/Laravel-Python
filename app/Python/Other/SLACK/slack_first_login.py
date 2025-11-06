from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from webdriver_manager.chrome import ChromeDriverManager
import time

# Googleのプロファイルを別フォルダに作ってログインしたいプロファイルのフォルダ毎コピーする
# 例
    #元プロファイル "C:\Users\hiraga\AppData\Local\Google\Chrome\User Data\Profile 1"
    #起動先プロファイル "C:\Users\hiraga\AppData\Local\Google\Chrome\User Data Selenium\Profile 1"
USER_DATA_DIR = r"C:\Users\hiraga\AppData\Local\Google\Chrome\User Data Selenium"
PROFILE_NAME = "Profile 1"

options = webdriver.ChromeOptions()
options.add_argument(f"user-data-dir={USER_DATA_DIR}")
options.add_argument(f"--profile-directory={PROFILE_NAME}")

driver = webdriver.Chrome(service=Service(ChromeDriverManager().install()), options=options)

# まずは Slack のワークスペースURLを開くだけ
driver.get("https://current-motor.slack.com/")

print("👉 ここで手動でログインしてください（完了したらブラウザを閉じずにこのままにしてOK）")

# しばらく待機してユーザーが操作できるようにする
time.sleep(60)  # 必要に応じて長く設定
driver.quit()
