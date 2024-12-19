<?php
require_once 'stripeConfig.php';

function createStripePayment($amount, $currency = 'usd', $description = 'Test Payment', $paymentMethod = null, $returnUrl = null)
{
    try {
        // default to test payment method if none is provided
        $paymentMethod = $paymentMethod ?? 'pm_card_visa';

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => $amount * 100, // Amount in cents
            'currency' => $currency,
            'description' => $description,
            'payment_method' => $paymentMethod, // here applied payment method actually
            'confirm' => true, // Automatically confirm the payment
            'payment_method_types' => ['card'], // Specify payment method types
            'payment_method_options' => [
                'card' => [
                    'request_three_d_secure' => 'automatic', // Enable 3D Secure
                ],
            ],
            'return_url' => $returnUrl, // Specify the return URL for 3D Secure authentication
            'automatic_payment_methods' => [
                'enabled' => false, // Disable automatic payment methods to avoid redirects
            ],
        ]);

        // Check if 3D Secure authentication is required
        if ($paymentIntent->status === 'requires_action' && $paymentIntent->next_action->type === 'redirect_to_url') {
            return [
                'requires_action' => true,
                'payment_intent_client_secret' => $paymentIntent->client_secret,
                'redirect_url' => $paymentIntent->next_action->redirect_to_url->url,
            ];
        }

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

function confirmStripePayment($paymentIntentId)
{
    try {
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
        $paymentIntent->confirm();

        if ($paymentIntent->status === 'succeeded') {
            return [
                'success' => true,
                'payment_id' => $paymentIntent->id,
                'status' => $paymentIntent->status,
                'amount' => $paymentIntent->amount,
            ];
        } else {
            return [
                'success' => false,
                'status' => $paymentIntent->status,
                'message' => 'Payment confirmation failed.',
            ];
        }
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
?>