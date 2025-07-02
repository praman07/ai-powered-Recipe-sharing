<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ingredients'])) {
    $ingredients = trim($_POST['ingredients']);
    $apiKey = "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";
    $payload = [
        "model" => "anthropic/claude-3-sonnet",
  "messages" => [
    [
        "role" => "user",
        "content" => "You are a friendly Indian recipe assistant.

The user entered: $ingredients

If these seem like real food ingredients (like onion, tomato, rice), suggest:
1. A complete Indian recipe title
2. Ingredients with proper quantities
3. Simple, clear step-by-step instructions

BUT — if the input is gibberish or unrecognizable as food, politely respond:
'Sorry, the ingredients do not seem valid. Please try again with real ingredients.'"
    ]
],

        "max_tokens" => 1000,
    ];

    $ch = curl_init("https://openrouter.ai/api/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $apiKey",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);

    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    if (isset($result['choices'][0]['message']['content'])) {
        echo nl2br(htmlspecialchars($result['choices'][0]['message']['content']));
    } elseif (isset($result['error'])) {
        echo "❌ Error: " . htmlspecialchars($result['error']['message']);
    } else {
        echo "❌ Unexpected response. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>
