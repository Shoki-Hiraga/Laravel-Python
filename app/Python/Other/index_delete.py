from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import time

# あなたのChromeプロファイルパス
PROFILE_PATH = r"C:\Users\hiraga\AppData\Local\Google\Chrome\User Data Selenium"

def open_with_profile_1():
    chrome_options = Options()
    
    # User Data（プロファイルフォルダ）
    chrome_options.add_argument(f"--user-data-dir={PROFILE_PATH}")

    # ◀◀◀ ここが重要！
    chrome_options.add_argument("--profile-directory=Profile 1")

    # 自動化っぽい挙動の抑制（安定化）
    chrome_options.add_experimental_option("excludeSwitches", ["enable-automation"])
    chrome_options.add_experimental_option("useAutomationExtension", False)

    # ドライバ起動
    driver = webdriver.Chrome(options=chrome_options)

    # Search Console を開く
    driver.get("https://search.google.com/search-console")
    print("Search Console を開きました！")

    time.sleep(10)
    # driver.quit()

if __name__ == "__main__":
    open_with_profile_1()
