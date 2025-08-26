import sys
import cv2
import numpy as np
from rembg import remove
from PIL import Image

# 引数受け取り
input_path = sys.argv[1]
output_path = sys.argv[2]

# 1. 前景抽出
img_pil = Image.open(input_path)
fg_removed = remove(img_pil)
fg_cv = cv2.cvtColor(np.array(fg_removed), cv2.COLOR_RGBA2BGRA)

# 2. 背景ぼかし
orig = cv2.imread(input_path)
bg_blur = cv2.GaussianBlur(orig, (109, 109), 0)

# 3. 合成
alpha = fg_cv[:, :, 3] / 255.0
alpha = np.stack([alpha]*3, axis=-1)
result = (fg_cv[:, :, :3] * alpha + bg_blur * (1 - alpha)).astype(np.uint8)

# 4. 書き出し
cv2.imwrite(output_path, result)
