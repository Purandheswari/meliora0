<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

function getChatbotResponse($message) {
    $client = new Client();
    $apiKey = 'you_key'; 
    $responseMessage = "Hello! How can I help you today?";

    try {
        $response = $client->post('https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill', [
            'headers' => [
                'Authorization' => "Bearer $apiKey",
                'Content-Type' => 'application/json',
            ],
            'json' => ['inputs' => $message],
        ]);

        $data = json_decode($response->getBody(), true);

      

        // Check if the response contains the expected data
        if (!empty($data[0]['generated_text'])) {
            $responseMessage = $data[0]['generated_text'];
        }
    } catch (Exception $e) {
        // Log or handle the exception as needed
        // Optionally, customize the fallback message
        $responseMessage = "Sorry, there seems to be an issue. Please try again later.";
    }

    return $responseMessage;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents('php://input');
    $request = json_decode($postData, true);
    if (isset($request['message'])) {
        $message = $request['message'];
        $response = getChatbotResponse($message);
        echo $response;
    }
}
?>
