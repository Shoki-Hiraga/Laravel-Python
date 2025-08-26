import sys
import cv2
import numpy as np
from rembg import remove
from PIL import Image

# 引数受け取り
input_path = sys.argv[1]
output_path = sys.argv[2]

# デフォルト値：ぼかし強度
blur_strength = 309
if len(sys.argv) > 3:
    try:
        blur_input = int(sys.argv[3])
        if blur_input % 2 == 0:
            blur_input += 1  # 奇数に補正（OpenCVの仕様）
        if 1 <= blur_input <= 999:
            blur_strength = blur_input
    except ValueError:
        pass  # 無効な値は無視してデフォルトにする

print(f"📥 入力画像: {input_path}")
print(f"📤 出力先: {output_path}")
print(f"💡 ぼかし強度: {blur_strength}")

# 1. 前景抽出
img_pil = Image.open(input_path)
fg_removed = remove(img_pil)
fg_cv = cv2.cvtColor(np.array(fg_removed), cv2.COLOR_RGBA2BGRA)

# 2. 背景ぼかし
orig = cv2.imread(input_path)
bg_blur = cv2.GaussianBlur(orig, (blur_strength, blur_strength), 0)

# 3. 合成
alpha = fg_cv[:, :, 3] / 255.0
alpha = np.stack([alpha]*3, axis=-1)
result = (fg_cv[:, :, :3] * alpha + bg_blur * (1 - alpha)).astype(np.uint8)

# 4. 書き出し
success = cv2.imwrite(output_path, result)
if success:
    print("✅ 書き出し成功")
else:
    print("❌ 書き出し失敗")
