<?php
include 'responses.php';

$userMessage = strtolower(trim($_POST['message']));

$response = "Mujhe samajh nahi aaya. Kripya dusra prashna puchhein.";

// Check against predefined responses
foreach ($botResponses as $question => $answer) {
    if (strpos($userMessage, $question) !== false) {
        $response = $answer;
        break;
    }
}

echo $response;
