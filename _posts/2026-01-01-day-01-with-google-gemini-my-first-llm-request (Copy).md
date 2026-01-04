---
layout: post
title: "Day 01 with Google Gemini: My First LLM Request"
date: 2026-01-01
---
# Day 01 with Google Gemini: My First LLM Request

Today was all about diving into Large Language Models (LLMs) and getting hands-on with Google’s Gemini API. My goal was simple: write a Python script that securely loads my API key, sends a prompt to an LLM, and prints out the response. But as always with AI projects, the devil was in the details.  

---

## Setting Up My Environment

The first step was making sure my environment was clean and manageable. I created a virtual environment using Python’s `venv` and installed the dependencies I’d need:

```bash
pip install google-genai python-dotenv
```

Then I set up a `.env` file to store my Google API key securely. One key takeaway today is how important it is to never hardcode API keys** in your code—`.env` files, combined with `python-dotenv`, make it safe and easy to manage secrets.

```env
GOOGLE_API_KEY=your_api_key_here
```

I also made sure my `.env` was added to `.gitignore` so it wouldn’t accidentally get committed to GitHub.

---

## The First LLM Request

Next, I wrote a Python script located at `src/day_01/day_01_hello_world.py`. The script had to do the following:

- Load my API key from `.env`  
- Send a single LLM request  
- Use the exact prompt:  
  *“Explain the difference between an AI Engineer and a Software Engineer in one sentence.”*  
- Print only the model’s text response  
- Exit with status code `0` on success  

At first, I ran into a couple of issues. The old `google.generativeai` package I was trying to use was deprecated, and I got errors when I called `generate_text()`—it just didn’t exist anymore!  

---

## Switching to the New SDK

After some research, I switched to the new `google-genai` SDK. This is the officially supported package now and works perfectly with Google’s Gemini API. The biggest change was the method for generating content. Instead of `generate_text()`, I used:

```python
response = client.models.generate_content(
    model="gemini-2.5-flash",
    contents=prompt
)
```

With this change, everything worked flawlessly. I got a clean response from the LLM, printed exactly what I needed, and my script exited successfully.

---

## Key Learnings

Here’s what I learned from today’s session:

1. Environment variables are crucial — `.env` + `python-dotenv` makes API key management safe and easy.  
2. Always check for SDK updates — deprecated packages can silently break your code.  
3. Know your models — using a valid Gemini model like `gemini-2.5-flash` is essential; `gemini-pro` no longer works.  
4. LLM calls can be simple — even a single non-conversational request teaches a lot about API interaction.  
5. Error handling matters — always catch exceptions and exit gracefully.  

---


Today was a small but meaningful step in my journey as an AI engineer. I went from a blank script to a fully functional LLM call, learned about SDK changes, and reinforced best practices for managing secrets. 

---

## Code Snippet

Here’s the final working script:

```python
import os
import sys
from dotenv import load_dotenv
from google import genai

def main():
    load_dotenv()
    api_key = os.getenv("GOOGLE_API_KEY")
    if not api_key:
        print("GOOGLE_API_KEY not found in environment", file=sys.stderr)
        sys.exit(1)

    client = genai.Client(api_key=api_key)

    prompt = (
        "Explain the difference between an AI Engineer and a Software Engineer "
        "in one sentence."
    )

    try:
        response = client.models.generate_content(
            model="gemini-2.5-flash",
            contents=prompt
        )
        print(response.text.strip())
        sys.exit(0)
    except Exception as e:
        print(f"Error: {e}", file=sys.stderr)
        sys.exit(1)

if __name__ == "__main__":
    main()
```


