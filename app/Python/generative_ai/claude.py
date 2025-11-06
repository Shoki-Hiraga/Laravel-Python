import sys
import os
sys.path.append(os.path.abspath(os.path.join(os.path.dirname(__file__), '..')))

import anthropic
from ai_setting.AI_apikey import claude_api_key_current
import time
from generative_ai.logs.logger import log_decorator, log_info, log_error 
from claude_prompt import model_prompt, model_system_prompt, satei_system_prompt, satei_prompt

system_prompt = model_system_prompt
user_prompt = model_prompt
# user_prompt = "テストです。5文字で応答してください"

# Claude API クライアントの作成
client = anthropic.Anthropic(api_key=claude_api_key_current)
@log_decorator
def get_claude_response(model_version="claude-3-7-sonnet-latest"):
    log_info(f"Request text: {user_prompt}")

    # 遅延処理を追加
    time.sleep(1)

    try:
        response_text = ""
        while True:
            message = client.messages.create(
                model=model_version,
                max_tokens=8192,
                temperature=0.5,
                system=system_prompt,
                messages=[
                    {
                        "role": "user",
                        "content": [
                            {
                                "type": "text",
                                "text": user_prompt
                            }
                        ]
                    }
                ]
            )
            
            response_text = message.content[0].text
            return response_text

    except Exception as e:
        log_info("Claude API エラー:", e)
        return None

if __name__ == "__main__":
    result = get_claude_response()
    log_info("Claude response:", result)
