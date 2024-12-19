<?php
require_once 'stripeConfig.php';

function createStripePayment($amount, $currency = 'usd', $description = 'Test Payment', $paymentMethod = null)
{
    try {
        // default to test payment method if none is provided
        $paymentMethod = $paymentMethod ?? 'pm_card_visa';

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100, // Amount in cents
            'currency' => $currency,
            'description' => $description,
            'payment_method' => $paymentMethod,//here applied payment method actually
            'confirm' => true, //Automatically confirm the payment
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never'
            ],
        ]);
        // echo json_encode($paymentIntent); // Send the data as JSON
        // exit;
        return [
            'client_secret' => $paymentIntent->client_secret, // Return client_secret for frontend
            'payment_id' => $paymentIntent->id,
            'status' => $paymentIntent->status,
            'amount' => $amount,
        ];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
?>