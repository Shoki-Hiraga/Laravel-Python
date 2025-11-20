import os

# ▼ Laravelルートディレクトリに出力パスを作る
CURRENT_FILE = os.path.abspath(__file__)
PYTHON_ROOT = os.path.dirname(os.path.dirname(CURRENT_FILE))
LARAVEL_ROOT = os.path.dirname(PYTHON_ROOT)
laravel_out_root = os.path.join(LARAVEL_ROOT, "output")  # 例：ルート/output フォルダ

# ▼ Python-dev ルート直下に output フォルダを作る
CURRENT_FILE = os.path.abspath(__file__)
PROJECT_ROOT = os.path.dirname(os.path.dirname(CURRENT_FILE))
pydev_out_root = os.path.join(PROJECT_ROOT, "output")

# --- Windows設定 ---
in_office = 'C:/Users/hiraga/Downloads'
out_office = 'C:/Users/hiraga/Downloads'

in_a09 = 'C:/Users/main/Downloads'
out_main = 'C:/Users/main/Downloads'

in_raytrek = 'C:/Users/RAYTREK/Downloads'
out_raytrek = 'C:/Users/RAYTREK/Downloads'

in_K39_sho = 'C:/Users/K39_sho/Downloads'
out_K39_sho = 'C:/Users/K39_sho/Downloads'
