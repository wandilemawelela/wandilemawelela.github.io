---
layout: post
title: "Day 03: Managing Context and Conversation History"
date: 2026-01-03
---

# Day 03: Managing Context and Conversation History

Today’s focus was on building a robust conversational AI loop with Google Gemini and learning how to handle context length and token limits effectively. After a couple of iterations, I now have a stable chat CLI that can manage conversation history without crashing or exceeding model constraints.

---

## Key Challenges

When working with LLMs, there are a few practical hurdles:

1. Context length exceeded errors - LLMs have a maximum number of tokens they can process at once. Sending too much conversation history causes errors.

2. Stateless API behavior - The model does not remember past messages. Every message must be sent in the conversation array for context.

---

## Trimming Old Messages

To prevent context overflow, I implemented history truncation:

```python
EXERCISE_MAX_CONTEXT_TOKENS = 4096
RESERVED_OUTPUT_TOKENS = 500
TRUNCATE_THRESHOLD_TOKENS = 3500
```

Before sending a request, I:

- Estimate input tokens with count_tokens(messages, model_name).

- If the estimate plus reserved output tokens exceeds the maximum, I remove the oldest user + assistant message pair until the conversation fits.

- Handle malformed histories (e.g., starting with an assistant) by trimming messages one at a time.

Every time truncation occurs, the CLI prints:

```python
[context] Truncated oldest messages to fit token budget.
```

This ensures the chatbot never crashes due to too-long input, and older conversation is pruned gracefully.

## Conversation Loop

The CLI handles user input with a clean loop:

- Prompts with exactly `You: `

- Ignores empty input

- Exits gracefully on `quit`, `exit`, or `/quit`

- Appends each user message to messages before sending

- Appends the assistant reply afterward, preserving context

For example:
```python
messages.append({"role": "user", "content": user_input})

contents = [
    genai.types.Content(
        role="user" if msg["role"] == "user" else "model",
        parts=[genai.types.Part(text=msg["content"])]
    )
    for msg in messages
]

response = client.models.generate_content(
    model=model_name,
    contents=contents
)

assistant_text = response.text.strip()
messages.append({"role": "assistant", "content": assistant_text})

```

## Lessons Learned

1. Stateless APIs require explicit context management - Without sending the full conversation, the assistant can’t respond coherently.

2. Input truncation is critical - Implementing a history trimming strategy ensures the chat runs smoothly, even with long conversations.

3. Token estimation is helpful - Using `count_tokens()` for the messages lets you anticipate and avoid context overflow.

Day 3 was a great reminder that engineering LLM applications is not just about sending prompts. The structure, limits, and state management all matter.