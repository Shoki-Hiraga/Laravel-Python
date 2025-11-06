import sys
import os
from google.oauth2 import service_account
from google.analytics.data_v1beta import BetaAnalyticsDataClient
from google.analytics.data_v1beta.types import DateRange, Metric, Dimension, RunReportRequest

# 上位ディレクトリから設定読み込み
sys.path.append(os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))
from setting_file.header import *
from setting_file.GA4_Set.QshURL_MK_RS_UV import URLS

# JSONファイルのパスとプロパティID
SERVICE_ACCOUNT_FILE = api_json.qsha_oh_ga4
PROPERTY_ID = '307515371'

# 認証とクライアント初期化
credentials = service_account.Credentials.from_service_account_file(
    SERVICE_ACCOUNT_FILE
)
client = BetaAnalyticsDataClient(credentials=credentials)

# イベント一覧をURLごとに取得する関数
def debug_event_names(url_path):
    request = RunReportRequest(
        property=f"properties/{PROPERTY_ID}",
        dimensions=[
            Dimension(name="eventName"),
            Dimension(name="pagePath")
        ],
        metrics=[
            Metric(name="eventCount")
        ],
        date_ranges=[
            DateRange(start_date="2024-10-01", end_date="2025-06-01")
        ],
        dimension_filter={
            "filter": {
                "field_name": "pagePath",
                "string_filter": {
                    "match_type": "CONTAINS",
                    "value": url_path
                }
            }
        }
    )

    try:
        response = client.run_report(request)
        print(f"\n--- イベント一覧 for URL: {url_path} ---")
        if not response.rows:
            print("（イベントなし）")
        for row in response.rows:
            event_name = row.dimension_values[0].value
            count = row.metric_values[0].value
            print(f"Event: {event_name}, Count: {count}")
    except Exception as e:
        print(f"Error retrieving event names for {url_path}: {e}")

# メイン実行
if __name__ == "__main__":
    for url in URLS:
        debug_event_names(url)
