import sys
import os
sys.path.append(os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))
from setting_file.header import *

from google.oauth2 import service_account
from google.analytics.data_v1beta import BetaAnalyticsDataClient
from google.analytics.data_v1beta.types import (
    DateRange, Metric, Dimension, RunReportRequest,
    FilterExpression, FilterExpressionList, Filter
)

from setting_file.GA4_Set.QshURL_MK_RS_UV import URLS

file_directory = file_path.file_directory
file_name = "GA4_API_Landing_to_CV.csv"
output_file = os.path.join(file_directory, file_name)

# 出力CSVのヘッダー
header_row = ['ランディングページURL', 'セッションメディア', 'CV数（査定依頼完了）', 'セッション数', 'CVR（%）']

set_start_date = "2025-11-03"
set_end_date = "2025-11-09"

SESSION_MEDIUM_FILTER = "organic"

# 認証設定
SERVICE_ACCOUNT_FILE = api_json.qsha_oh_ga4
PROPERTY_ID = '307515371'

credentials = service_account.Credentials.from_service_account_file(SERVICE_ACCOUNT_FILE)
client = BetaAnalyticsDataClient(credentials=credentials)

# 全セッション数を取得
def get_total_sessions_from_landing(landing_url):
    dimension_filter = FilterExpression(
        and_group=FilterExpressionList(
            expressions=[
                FilterExpression(
                    filter=Filter(
                        field_name="landingPagePlusQueryString",
                        string_filter={"match_type": "CONTAINS", "value": landing_url}
                    )
                ),
                FilterExpression(
                    filter=Filter(
                        field_name="sessionMedium",
                        string_filter={"match_type": "EXACT", "value": SESSION_MEDIUM_FILTER}
                    )
                )
            ]
        )
    )

    request = RunReportRequest(
        property=f"properties/{PROPERTY_ID}",
        dimensions=[Dimension(name="landingPagePlusQueryString")],
        metrics=[Metric(name="sessions")],
        date_ranges=[DateRange(start_date=set_start_date, end_date=set_end_date)],
        dimension_filter=dimension_filter  # ← ここで定義済みのフィルターを使う
    )

    try:
        response = client.run_report(request)
        return sum(int(row.metric_values[0].value) for row in response.rows)
    except Exception as e:
        print(f"[ERROR] Total sessions error for {landing_url}: {e}")
        return 0

# CV数を取得（特定イベント名・キーイベント・thanksページ）
def get_cv_sessions_from_landing(landing_url):
    dimension_filter = FilterExpression(
        and_group=FilterExpressionList(
            expressions=[
                FilterExpression(
                    filter=Filter(
                        field_name="landingPagePlusQueryString",
                        string_filter={"match_type": "CONTAINS", "value": landing_url}
                    )
                ),
                FilterExpression(
                    filter=Filter(
                        field_name="pagePath",
                        string_filter={"match_type": "EXACT", "value": "/thanks/"}
                    )
                ),
                FilterExpression(
                    filter=Filter(
                        field_name="isKeyEvent",
                        string_filter={"match_type": "EXACT", "value": "true"}
                    )
                ),
                FilterExpression(
                    filter=Filter(
                        field_name="eventName",
                        string_filter={"match_type": "EXACT", "value": "査定依頼完了"}
                    )
                ),
                FilterExpression(
                    filter=Filter(
                        field_name="sessionMedium",
                        string_filter={"match_type": "EXACT", "value": SESSION_MEDIUM_FILTER}
                    )
                )
            ]
        )
    )

    request = RunReportRequest(
        property=f"properties/{PROPERTY_ID}",
        dimensions=[Dimension(name="landingPagePlusQueryString")],
        metrics=[Metric(name="keyEvents")],
        date_ranges=[DateRange(start_date=set_start_date, end_date=set_end_date)],
        dimension_filter=dimension_filter
    )

    try:
        response = client.run_report(request)
        return sum(int(row.metric_values[0].value) for row in response.rows)
    except Exception as e:
        print(f"[ERROR] CV count error for {landing_url}: {e}")
        return 0


# メイン処理
try:
    with open(output_file, 'w', newline='', encoding='utf-8') as csvfile:
        csv_writer = csv.writer(csvfile)
        csv_writer.writerow(header_row)

        for landing_url in URLS:
            total_sessions = get_total_sessions_from_landing(landing_url)
            cv_count = get_cv_sessions_from_landing(landing_url)
            cvr = (cv_count / total_sessions) * 100 if total_sessions > 0 else 0.0

            csv_writer.writerow([
                landing_url,
                SESSION_MEDIUM_FILTER,
                cv_count,
                total_sessions,
                round(cvr, 2)
            ])

            print(f'ランディングページ: {landing_url}, セッションメディア: {SESSION_MEDIUM_FILTER}, '
            f'セッション数: {total_sessions}, CV数: {cv_count}, CVR: {cvr:.2f}%')


            delay = random.uniform(1.0, 2.5)
            print(f'遅延処理 {delay:.2f} 秒\n')
            time.sleep(delay)

    print(f'\n✅ CSVファイルを以下にエクスポートしました:\n{output_file}')

except Exception as err:
    print(f'\n[CRITICAL ERROR] エラーが発生しました: {err}')
