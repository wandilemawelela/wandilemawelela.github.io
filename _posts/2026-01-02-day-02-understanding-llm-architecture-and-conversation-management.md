---
layout: post
title: "Day 02 with Google Gemini: Understanding LLM Architecture and Conversation Management"
date: 2026-01-02
---

# Day 02 with Google Gemini: Understanding LLM Architecture and Conversation Management

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

Every time the user sends a message, it’s appended to the list:

