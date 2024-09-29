<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $issue = $data['issue'];

    // Replace with your actual URL where Flask is running
    $url = 'http://localhost:5001/classify';
    $data = array('issue' => $issue);
    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        http_response_code(500);
        echo json_encode(array('error' => 'Error contacting the classification service'));
        exit;
    }

    $classification = json_decode($result, true);

    echo json_encode($classification);
}
?>
