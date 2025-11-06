from fuzzywuzzy import fuzz
import pandas as pd
from kw_similar_list import titles  # titlesは3カラム: [URL, スコア, タイトル]

threshold = 85  # 類似度しきい値

# kw_similar_list.py がフラットなCSVリストの場合、自動で3要素ごとにまとめる
if all(isinstance(x, str) for x in titles):
    titles = [titles[i:i+3] for i in range(0, len(titles), 3)]

def cluster_titles(titles, threshold=80):
    """
    タイトル群を類似スコアに基づいてクラスタリング
    titles: [[URL, score, title], ...]
    threshold : 類似度のしきい値 (0〜100)
    """
    clusters = []
    visited = set()

    for i, (url, score, title) in enumerate(titles):
        if i in visited:
            continue

        cluster = [(url, score, title)]
        visited.add(i)

        for j, (url2, score2, title2) in enumerate(titles):
            if j in visited:
                continue

            sim_score = fuzz.token_set_ratio(title, title2)
            if sim_score >= threshold:
                cluster.append((url2, score2, title2))
                visited.add(j)

        clusters.append(cluster)

    return clusters


if __name__ == "__main__":
    clusters = cluster_titles(titles, threshold)

    # --- CSV出力処理 ---
    csv_data = []
    for i, group in enumerate(clusters, start=1):
        group_name = f"グループ{i}"
        for url, score, title in group:
            csv_data.append([group_name, url, score, title])

    df = pd.DataFrame(csv_data, columns=['Group_ID', 'URL', 'Score', 'Title'])

    output_path = r"C:\Users\hiraga\Downloads\KW_similar.csv"

    try:
        df.to_csv(output_path, index=False, encoding='utf-8-sig')
        print(f"=== 名寄せ結果を {output_path} にエクスポートしました ===")
        print(f"合計 {len(titles)} 件のタイトルを {len(clusters)} グループに分類しました。")
    except Exception as e:
        print(f"CSVファイルのエクスポートに失敗しました: {e}")
        print("ファイルパスやフォルダの権限を確認してください。")

    # --- コンソール表示 ---
    print("\n=== コンソール確認用 ===")
    for i, group in enumerate(clusters, start=1):
        print(f"\nグループ{i}:")
        for _, _, t in group:
            print("  -", t)
