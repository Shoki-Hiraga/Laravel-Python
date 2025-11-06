# トヨタ チェイサー の画像を生成したいです。
# 以下の要件に従って画像を生成してください。

# アングル指定：「前から左斜めの角度」
# 背景/ライティング：「スタジオ撮影風、透明背景」
# スタイル：「写実的なスタイル」
# GPTおすすめの画像生成 API
# https://www.krea.ai/
# https://civitai.com/models


from openai import OpenAI
from ai_setting.AI_apikey import GPT_api_key

# DBから取得されるパラメータ（※必須）
maker_name = "トヨタ"
car_name = "チェイサー"
year = "1998"

# 初期化
client = OpenAI(api_key=GPT_api_key)

# 改良済み GPT-4 systemプロンプト（妄想補正・チューン禁止版）
system_prompt = f"""
You are a professional prompt engineer and Japanese car enthusiast working with DALL·E 3.

You will receive a Japanese car description in this format: "{maker_name} {car_name} {year}".

Your goal is to generate a natural and highly detailed English prompt for DALL·E 3, so that it creates a realistic and photorealistic image of the car.

Strict constraints:
- Focus only on real, production models. No concept cars, no futuristic styles.
- Do not guess trim levels, chassis codes, or speculative variations.
- The car must be a factory-original stock version as sold to customers.
- No tuning, racing modifications, aftermarket wheels or parts.
- No exaggerations or stylized fantasy elements.
- Present the car exactly as it would appear in a 1998 Toyota showroom brochure.

Visual requirements:
- Angle: front-left (three-quarter front view)
- Background: white (plain, clean, with no visible shadows or environment)
- Lighting: soft, diffused, professional studio lighting
- Style: ultra-realistic, photorealistic
- No people, no surroundings, only the car in frame

You must output only the final English prompt text. Do not include explanations or comments.
If possible, describe key visual features of the car that help DALL·E reproduce it accurately — such as headlight shape, grille style, body silhouette, or number of doors — especially if the car is iconic or recognizable to enthusiasts.

"""

# ユーザーからの自然な日本語入力
base_prompt = f"""{maker_name} {car_name} {year}の画像を生成したいです。
以下の要件に従って画像を生成してください。

アングル指定：「前から左斜めの角度」
背景：「白背景」
スタイル：「実写と類似したイメージ」
車種：{maker_name} {car_name} {year} と表現した時、一般ユーザーが連想する代表的な車種
"""

# GPT-4でプロンプト変換
chat_response = client.chat.completions.create(
    model="gpt-4",
    messages=[
        {"role": "system", "content": system_prompt},
        {"role": "user", "content": base_prompt}
    ],
    temperature=0.3
)

# DALL·E向けの最終プロンプトを抽出
image_prompt = chat_response.choices[0].message.content.strip()
print("📝 Final Image Prompt:\n", image_prompt)

# DALL·E 3 APIに画像生成リクエスト（Proユーザーは quality="hd" も試せる）
image_response = client.images.generate(
    model="dall-e-3",
    prompt=image_prompt,
    size="1024x1024",         # または "1792x1024" なども可能
    quality="standard",       # または "hd"（※高精細）
    n=1
)

# 結果表示
image_url = image_response.data[0].url
print("\n✅ Image generated! URL:")
print(image_url)
