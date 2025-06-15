<?php
$url = 'http://www.geoplugin.net/json.gp?ip=192.166.247.179';

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error fetching data: ' . curl_error($ch);
} else {
    // Decode the JSON response
    $data = json_decode($response, true);
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

// Close cURL session
curl_close($ch);
?>