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
    $returnUrl = $_GET['return_url'] ?? '';

    switch ($gateway) {
        case 'stripe':
            // process stripe payment
            $response = createStripePayment($amount, 'usd', 'Test Payment', null, $returnUrl);
            if (isset($response['error'])) {
                echo json_encode(['success' => false, 'message' => $response['error']]);
                break;
            }
            if (isset($response['requires_action']) && $response['requires_action']) {
                echo json_encode([
                    'success' => true,
                    'requires_action' => true,
                    'payment_intent_client_secret' => $response['payment_intent_client_secret'],
                    'redirect_url' => $response['redirect_url'],
                ]);
                break;
            }
            $formatedResponse = formatStripeResponse($response);
            echo json_encode($formatedResponse);
            break;
        case 'paypal':
            // process paypal payment
            $response = processPaypalPayment($amount, $userId, $itemId, $transactionType);
            if (isset($response['error'])) {
                echo json_encode(['success' => false, 'message' => $response['error']]);
            } else {
                echo json_encode($response);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid gateway specified.']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle payment confirmation
    $gateway = $_POST['gateway'] ?? '';
    $paymentIntentId = $_POST['payment_intent_id'] ?? '';

    if ($gateway === 'stripe' && $paymentIntentId) {
        $response = confirmStripePayment($paymentIntentId);
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request parameters.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

function processPaypalPayment($amount, $userId, $itemId, $transactionType)
{
    require_once __DIR__ . '/payment-gateway/paypal/paypalConfig.php';
    require_once __DIR__ . '/payment-gateway/paypal/paypalClient.php';
    require_once __DIR__ . '/payment-gateway/paypal/paypalHelper.php';

    try {
        // Step 1: Create a new PayPal order
        $order = createPaypalOrder($amount, $transactionType, $userId, $itemId);

        // Step 2: Format the response
        return [
            'success' => true,
            'order_id' => $order['id'],
            'amount' => $amount,
            'status' => $order['status'],
            'message' => 'PayPal order created successfully!',
        ];
    } catch (Exception $e) {
        return [
            'error' => 'PayPal Payment Error: ' . $e->getMessage(),
        ];
    }
}
?>