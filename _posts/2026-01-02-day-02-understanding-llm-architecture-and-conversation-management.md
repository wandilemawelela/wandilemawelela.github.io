---
layout: post
title: "Day 02: Understanding LLM Architecture and Conversation Management"
date: 2026-01-02
---

# Day 02: Understanding LLM Architecture and Conversation Management

Day 02 was all about learning how to manage conversations with LLMs and building a small Python chatbot using Google’s Gemini API. My goal was to implement a loop that maintains conversation context, handles user input gracefully, and prints assistant responses.  

---

A major insight was understanding that LLM APIs are stateless. Models do not retain past interactions, so conversation history must be explicitly managed by the application. This fundamentally changes how conversational AI systems are designed — without a structured messages array, the model cannot maintain context or produce coherent responses.

---

## Personal Takeaways

- LLMs are sophisticated functions, not databases. They generate outputs based entirely on the input provided each call.  
- Stateless APIs require careful conversation management. Every user and assistant turn must be stored and sent to the model for context.  
- Understanding Transformers and self-attention helped me see why full conversation history is critical. Self-attention enables the model to weigh prior tokens appropriately and generate meaningful responses.

---

## Setting Up Conversation Management

To manage conversation context, I created a `messages` list that stores each turn as a dictionary with `role` and `content`:

```python
messages: list[dict[str, str]] = []
```

Every time the user sends a message, it’s appended to the list:

```python
messages.append({"role": "user", "content": user_input})
```

After the assistant responds, that message is also appended, so context is preserved for the next turn.

## Handling User Input

I implemented a clean interactive loop with the following behaviors:
- Prompt the user with exactly `You: `
- Ignore empty input and reprompt without calling the API
- Exit gracefully if the user types `quit`, `exit`, or `/quit`

This ensures the chatbot feels natural to interact with while handling edge cases properly.

## Sending Messages to the LLM
To send the conversation to Gemini, I used the `generate_content` method from the official `google-genai` SDK:

```python
response = client.models.generate_content(
    model="gemini-2.5-flash",
    contents=convert_messages_to_gemini_format(messages),
)
```
The full `messages` list is converted into the required format and sent with every request, ensuring the assistant can generate contextually accurate replies.

## Key Learnings

- Stateless APIs require explicit conversation management — models don’t remember previous messages.

- Structured message history is crucial — each turn must include the role (user or assistant) and the text.

- Clean input handling improves UX — ignoring empty input and graceful exits are simple but important.

- Environment variables matter — .env + python-dotenv ensures API keys are managed securely.

- Understanding architecture shapes design — knowing about Transformers and self-attention explains why context must be explicitly sent each turn.
