from openai import OpenAI
from ai_setting.AI_apikey import GPT_api_key

# 任意の車名指定（DBなどから動的に）
maker_name = "トヨタ"
car_name = "チェイサー"

# GPT-4 に渡すシンプルな日本語プロンプト（テンプレ）
base_prompt = f"""{maker_name} {car_name} の画像を生成したいです。
以下の要件に従って画像を生成してください。

アングル指定：「前から左斜めの角度」
背景/ライティング：「スタジオ撮影風、透明背景」
スタイル：「写実的なスタイル」
"""

# OpenAI APIクライアント初期化
client = OpenAI(api_key=GPT_api_key)

# ✅ GPT-4 にプロンプト最適化を依頼
chat_response = client.chat.completions.create(
    model="gpt-4",
    messages=[
        {
            "role": "system",
            "content": (
                "You are an expert in both cars and DALL·E 3 image prompt design. "
                "When given a simple prompt in Japanese, your job is to convert it "
                "into a highly detailed, realistic English prompt optimized for DALL·E 3."
            )
        },
        {
            "role": "user",
            "content": f"次のプロンプトを、DALL·E 3 向けの詳細な英語プロンプトに書き換えてください:\n\n{base_prompt}"
        }
    ],
    temperature=0.7
)

# 最適化された画像プロンプトを取得
image_prompt = chat_response.choices[0].message.content.strip()
print("📝 Optimized Prompt:\n", image_prompt)

# ✅ DALL·E 3 に画像生成を依頼
image_response = client.images.generate(
    model="dall-e-3",
    prompt=image_prompt,
    size="1024x1024",
    quality="standard",
    n=1
)

# ✅ 生成された画像URLを出力
image_url = image_response.data[0].url
print("\n✅ Image generated! URL:")
print(image_url)
