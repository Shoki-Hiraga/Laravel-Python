import os

# ▼ 今のファイル(csv_output_path.py)の絶対パス
CURRENT_FILE = os.path.abspath(__file__)

# ▼ setting_file フォルダの親 → プロジェクトのルートと想定
PROJECT_ROOT = os.path.dirname(os.path.dirname(CURRENT_FILE))

# ▼ ルート直下に output フォルダを作る
out_root = os.path.join(PROJECT_ROOT, "output")


# ---- 以下はあなたの既存データ ----
in_office = 'C:/Users/hiraga/Downloads'
out_office = 'C:/Users/hiraga/Downloads'

in_a09 = 'C:/Users/main/Downloads'
out_main = 'C:/Users/main/Downloads'

in_raytrek = 'C:/Users/RAYTREK/Downloads'
out_raytrek = 'C:/Users/RAYTREK/Downloads'

in_K39_sho = 'C:/Users/K39_sho/Downloads'
out_K39_sho = 'C:/Users/K39_sho/Downloads'
