import os
import json
from collections import defaultdict
import matplotlib.pyplot as plt

# ==================
# Webアプリのルートディレクトリに配置
# ==================


# --- 言語拡張子マップ ---
EXT_LANG_MAP = {
    '.py': 'Python',
    '.js': 'JavaScript',
    '.ts': 'TypeScript',
    '.php': 'PHP',
    '.vue': 'Vue.js',
    '.html': 'HTML',
    '.css': 'CSS',
    '.java': 'Java',
    '.rb': 'Ruby',
}

# --- 主要フレームワーク検出関数 ---
def detect_frameworks(root):
    frameworks = set()

    for dirpath, _, filenames in os.walk(root):
        # --- package.json ---
        if 'package.json' in filenames:
            try:
                with open(os.path.join(dirpath, 'package.json'), encoding='utf-8') as f:
                    data = json.load(f)
                    deps = json.dumps(data).lower()
                    if "nuxt" in deps:
                        frameworks.add("Nuxt (Vue.js)")
                    if "vue" in deps:
                        frameworks.add("Vue.js")
                    if "@inertiajs" in deps:
                        frameworks.add("Inertia.js")
                    if "react" in deps:
                        frameworks.add("React")
                    if "express" in deps:
                        frameworks.add("Express.js")
                    if "next" in deps:
                        frameworks.add("Next.js")
            except Exception:
                pass

        # --- composer.json ---
        if 'composer.json' in filenames:
            try:
                with open(os.path.join(dirpath, 'composer.json'), encoding='utf-8') as f:
                    data = json.load(f)
                    deps = json.dumps(data).lower()
                    if "laravel/framework" in deps:
                        frameworks.add("Laravel")
                    if "symfony" in deps:
                        frameworks.add("Symfony")
            except Exception:
                pass

        # --- requirements.txt / pyproject.toml ---
        if 'requirements.txt' in filenames or 'pyproject.toml' in filenames:
            file_path = (
                os.path.join(dirpath, 'requirements.txt')
                if 'requirements.txt' in filenames
                else os.path.join(dirpath, 'pyproject.toml')
            )
            try:
                with open(file_path, encoding='utf-8') as f:
                    content = f.read().lower()
                    if "django" in content:
                        frameworks.add("Django")
                    if "flask" in content:
                        frameworks.add("Flask")
                    if "fastapi" in content:
                        frameworks.add("FastAPI")
            except Exception:
                pass

        # --- 特徴的ファイルによる検出 ---
        if 'manage.py' in filenames:
            frameworks.add("Django")
        if 'artisan' in filenames:
            frameworks.add("Laravel")
        if 'app.js' in filenames and 'views' in dirpath:
            frameworks.add("Express.js")

    return frameworks


# --- 言語別行数カウント ---
def analyze_languages(root):
    lang_stats = defaultdict(int)
    for dirpath, _, filenames in os.walk(root):
        for filename in filenames:
            _, ext = os.path.splitext(filename)
            lang = EXT_LANG_MAP.get(ext)
            if not lang:
                continue
            file_path = os.path.join(dirpath, filename)
            try:
                with open(file_path, encoding='utf-8', errors='ignore') as f:
                    lines = f.readlines()
                    lang_stats[lang] += len(lines)
            except:
                pass
    return lang_stats


# --- 結果を円グラフ表示 ---
def plot_langs(lang_stats):
    labels = list(lang_stats.keys())
    sizes = list(lang_stats.values())
    if not sizes:
        print("⚠️ 言語データが見つかりませんでした。")
        return
    plt.figure(figsize=(6,6))
    plt.pie(sizes, labels=labels, autopct='%1.1f%%', startangle=140)
    plt.title('Language Usage')
    plt.show()


# --- メイン処理 ---
if __name__ == '__main__':
    root_dir = os.getcwd()
    print("📁 解析対象ディレクトリ:", root_dir)

    # フレームワーク検出
    frameworks = detect_frameworks(root_dir)
    print("\n🧠 検出されたフレームワーク:")
    if frameworks:
        for fw in frameworks:
            print(f" - {fw}")
    else:
        print("（検出なし）")

    # 言語使用率
    lang_stats = analyze_languages(root_dir)
    print("\n📊 言語使用行数:")
    total = sum(lang_stats.values())
    for lang, lines in sorted(lang_stats.items(), key=lambda x: x[1], reverse=True):
        percent = (lines / total) * 100 if total else 0
        print(f"{lang:10s}: {lines:>6} 行 ({percent:.1f}%)")

    # グラフ描画
    plot_langs(lang_stats)
