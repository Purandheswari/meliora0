<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issue = $_POST['issue'];

    // Replace with your Flask server URL
    $url = 'http://localhost:5001/classify';
    $data = json_encode(array('issue' => $issue));

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        die('Error contacting the classification service');
    }

    $classification = json_decode($result, true);

    if (isset($classification['classification']) && $classification['classification'] === 'trivial') {
        echo "<script>alert('Error: Trivial issues like \'pen\' or \'pencil\' are not permitted');</script>";
        echo "<script>window.history.back();</script>"; // Redirect back to the form
        exit;
    }

    // If not trivial, proceed with storing the issue in the database or other actions
    echo "Issue submitted successfully";
    // Insert code to save issue to the database or perform other actions
}
?>
