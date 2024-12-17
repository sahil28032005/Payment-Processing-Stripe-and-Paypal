<?php
require_once 'stripeConfig.php';

function createStripePayment($amount, $currency = 'usd', $description = 'Test Payment')
{
    try {
        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100, // Amount in cents
            'currency' => $currency,
            'description' => $description,
        ]);
        // echo json_encode($paymentIntent); // Send the data as JSON
        // exit;
        return [
            'client_secret' => $paymentIntent->client_secret, // Return client_secret to frontend
            'payment_id' => $paymentIntent->id,
            'status' => $paymentIntent->status,
            'amount' => $amount,
        ];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
?>