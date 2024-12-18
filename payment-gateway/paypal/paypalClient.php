<?php
function paypalApiRequest($method, $endpoint, $data = null)
{
    $url = $_ENV['PAYPAL_API_BASE'] . $endpoint;
    // echo $url;
    $ch = curl_init($url);

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . getPaypalAccessToken(),
    ];

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($status >= 200 && $status < 300) {
        return json_decode($response, true);
    } else {
        throw new Exception("PayPal API Error: " . $response);
    }
}

function getPaypalAccessToken()
{
    $url = $_ENV['PAYPAL_API_BASE'] . '/v1/oauth2/token';
    // echo "Request URL: " . $url . "<br>";  // Log the request URL for debugging

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_USERPWD, $_ENV['PAYPAL_CLIENT_ID'] . ':' . $_ENV['PAYPAL_SECRET']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');

    $response = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error_message = curl_error($ch); // Get cURL error if any

    curl_close($ch);

    // Log response and error message for debugging
    echo "Response: " . $response;

    if ($status >= 200 && $status < 300) {
        $data = json_decode($response, true);
        return $data['access_token'];
    } else {
        // If there's an error, throw the exception with the response and status
        throw new Exception("PayPal API Error: " . $response . " (Status: " . $status . ")");
    }
}



?>