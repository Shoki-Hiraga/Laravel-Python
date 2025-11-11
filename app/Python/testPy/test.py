# count_progress.py

total = 100_000
# 100_000
for i in range(1, total + 1):
    percent = (i / total) * 10
    print(f"\r{i}/{total} {percent:.2f}%", end="")

print("\n完了しました！")
