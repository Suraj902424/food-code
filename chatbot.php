<?php
// OpenAI API key
$apiKey = "YOUR_API_KEY_HERE";

// User message (frontend se aayega)
$userMessage = "Hello, chatbot!";

// API request data
$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => $userMessage]
    ]
];

// CURL request
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

// Response decode
$result = json_decode($response, true);
echo $result['choices'][0]['message']['content'];
?>
