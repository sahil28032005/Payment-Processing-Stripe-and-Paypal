<?php
require_once 'payment-gateway/stripe/stripeClient.php';
require_once 'payment-gateway/stripe/stripeHelper.php';
// Set content type to JSON
header('Content-Type: application/json');

// creating payment hit module main
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // accept params from get request
    $gateway = $_GET['gateway'] ?? '';
    $amount = $_GET['payment_amount'] ?? 0;
    $userId = $_GET['user_id'] ?? '';
    $itemId = $_GET['item_id'] ?? '';
    $transactionType = $_GET['transaction_type'] ?? '';

    switch ($gateway) {
        case 'stripe':
            //process stripe payment
            $response = createStripePayment($amount);
            if (isset($response['error'])) {
                echo json_encode(['success' => false, 'message' => $response['error']]);
                break;
            }
            $formatedResponse = formatStripeResponse($response);
            echo json_encode($formatedResponse);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid gateway specified.']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

?>