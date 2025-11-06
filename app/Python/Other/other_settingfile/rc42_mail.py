import smtplib
from email.mime.text import MIMEText

# メール設定
SMTP_SERVER = 'sv8035.xserver.jp'  # ← XサーバーのSMTPサーバー名に変更
SMTP_PORT = 465  # SSLポート
EMAIL_FROM = 'cb750-alert@332web.com'
EMAIL_TO = 'chaser.cb750@gmail.com'
EMAIL_USER = EMAIL_FROM
EMAIL_PASS = '78195090Cb'  # Xサーバーで設定したパスワード

def send_notification(url):
    subject = "車体番号が一致しました"
    body = f"車台番号下3桁が、166と一致しました。\n該当URL：{url}"

    msg = MIMEText(body)
    msg["Subject"] = subject
    msg["From"] = EMAIL_FROM
    msg["To"] = EMAIL_TO

    try:
        with smtplib.SMTP_SSL(SMTP_SERVER, SMTP_PORT) as server:
            server.login(EMAIL_USER, EMAIL_PASS)
            server.send_message(msg)
        print("📧 通知メールを送信しました（Xサーバー経由）")
    except Exception as e:
        print(f"⚠️ メール送信エラー: {e}")


def send_no_match_notification():
    subject = "【一致無し】CB750を探しましたが 166 には一致しませんでした"
    body = "rc42_check.py で グーバイクのデータを確認しましたが、車体番号下3桁で166に一致するCB750はありませんでした。"

    msg = MIMEText(body)
    msg["Subject"] = subject
    msg["From"] = EMAIL_FROM
    msg["To"] = EMAIL_TO

    try:
        with smtplib.SMTP_SSL(SMTP_SERVER, SMTP_PORT) as server:
            server.login(EMAIL_USER, EMAIL_PASS)
            server.send_message(msg)
        print("📧 一致なし通知メールを送信しました")
    except Exception as e:
        print(f"⚠️ 一致なし通知の送信エラー: {e}")

# メール送信テストコード
if __name__ == "__main__":
    send_notification("https://example.com/test-bike")
