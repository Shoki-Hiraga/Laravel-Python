import cv2
import numpy as np
from rembg import remove
from PIL import Image
import os

# =============================
# 入力・出力フォルダ
# =============================
input_dir = r"C:\Users\hiraga\Documents\image_bokashi"
output_dir = r"C:\Users\hiraga\Documents\image_bokashi\processed"

# 出力フォルダがなければ作成
os.makedirs(output_dir, exist_ok=True)

# =============================
# フォルダ内のすべての画像を処理
# =============================
for file_name in os.listdir(input_dir):
    if file_name.lower().endswith(('.jpg', '.jpeg', '.png')):
        input_path = os.path.join(input_dir, file_name)
        output_path = os.path.join(output_dir, file_name)

        # 1. rembg で前景抽出
        img_pil = Image.open(input_path)
        fg_removed = remove(img_pil)  # 背景透過PNGを得る
        fg_cv = cv2.cvtColor(np.array(fg_removed), cv2.COLOR_RGBA2BGRA)

        # 2. 背景をぼかす
        orig = cv2.imread(input_path)
        bg_blur = cv2.GaussianBlur(orig, (301, 301), 0) # ぼかし具合は奇数文字で指定

        # 3. 前景と背景を合成
        alpha = fg_cv[:, :, 3] / 255.0
        alpha = np.stack([alpha]*3, axis=-1)
        result = (fg_cv[:, :, :3] * alpha + bg_blur * (1 - alpha)).astype(np.uint8)

        # 4. 保存
        cv2.imwrite(output_path, result)
        print(f"✅ 完了しました！ 出力ファイル: {output_path}")

print("🎉 全ての処理が完了しました！")
