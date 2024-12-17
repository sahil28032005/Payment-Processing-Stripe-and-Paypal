<?php
// stripeHelper.php

function formatStripeResponse($response) {
    if (isset($response['error'])) {
        return ['success' => false, 'message' => $response['error']];
    } else {
        return [
            'success' => true,
            'payment_id' => $response['payment_id'], // Use array access syntax here
            'amount' => $response['amount'] / 100, // Use array access syntax here
            // 'status' => $response['status'], // Use array access syntax here
            'client_secret' => $response['client_secret'],  // Adding client_secret for frontend use
        ];
    }
}
?>
