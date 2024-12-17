<?php
require_once __DIR__ . '/paypalClient.php';
function createPaypalOrder($amount, $transactionType, $userId, $itemId)
{
    $orderData = [
        'intent' => 'CAPTURE',
        'purchase_units' => [
            [
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => $amount,
                ],
                'description' => $transactionType . ' for user ' . $userId . ' and item ' . $itemId,
            ],
        ],
    ];

    return paypalApiRequest('POST', '/v2/checkout/orders', $orderData);
}
?>