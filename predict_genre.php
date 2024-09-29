<?php
function callPythonAPI($text, $vocab) {
    $url = 'http://localhost:5000/predict';
    $data = json_encode(['text' => $text, 'vocab' => $vocab]);

    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { 
        return "Error";
    }
    
    return json_decode($result, true);
}

// Example usage
$text = "I cannot pay my tuition fees, because of technical issues. Age: 21. GPA: 4.62. Year: 1 . Gender: F";
$vocab = array(
    "i" => 1, "cannot" => 2, "pay" => 3, "my" => 4, "tuition" => 5,
    "fees" => 6, "because" => 7, "of" => 8, "technical" => 9, "issues" => 10,
    "<unk>" => 0  // Include unknown token in vocab
); // Example vocab, adjust according to your vocab

$response = callPythonAPI($text, $vocab);
if ($response != "Error") {
    echo "Predicted Genre: " . $response['prediction'];
} else {
    echo "Error in prediction";
}
?>
