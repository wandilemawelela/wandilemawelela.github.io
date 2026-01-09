---
layout: post
title: "Day 05: Few-Shot Prompting, Reasoning Control, and Power-User Commands"
date: 2026-01-05
---

# Day 05: Few-Shot Prompting, Reasoning Control, and Power-User Commands

Today was a big step forward in prompting techniques and conversational control. I focused on moving beyond basic chat interactions and into intentional prompt design—specifically few-shot prompting, reasoning control, and user-driven prompt modifiers.

## Few-Shot Prompting: Teaching the Model by Example?

I started by implementing a few-shot classification task: a simple movie review sentiment classifier. Instead of relying on zero-shot behavior, I embedded exactly three labeled examples directly into the prompt. Then I passed one unlabeled review and required the model to output only a single label: `Positive` or `Negative`.

This exercise reinforced a core insight: Few-shot prompting is not about verbosity — it’s about precision and constraint.

With just three examples, the model consistently inferred the correct sentiment without extra explanation.

## Reasoning Comparison: Zero-Shot vs Step-By-Step

Next, I explored how explicit reasoning instructions affect output quality.

I ran the same math word problem twice: "A coffee shop sells cups for $3 each and muffins for $2 each…"

- ZERO SHOT → Asked the question as-is
- STEP BY STEP → Prefixed with:
  “Explain your reasoning step-by-step, then give the final answer.”

Printing both outputs side-by-side made the difference obvious:

- Zero-shot answers were often shorter and more brittle
- Step-by-step prompts produced clearer, more reliable reasoning

This demonstrated why reasoning instructions are a tool, not a default — they should be used intentionally.

## Adding a Power-User `/cot` Command

The highlight of the day was enhancing the chatbot UX with a one-shot Chain-of-Thought toggle.

I added a `/cot` command to the CLI with the following behavior:

- Typing `/cot` enables step-by-step reasoning for the next user message only
- The command itself is not stored in chat history
- After one response, CoT mode automatically turns off
- Clear on-screen feedback confirms mode changes

## Key Takeaway

- Few-shot prompting can outperform zero-shot with minimal examples
- Explicit reasoning instructions materially change output quality
- Chain-of-thought should be opt-in, not always-on
- Prompting techniques belong in code, not just prompts
- Small UX features dramatically improve developer experience
