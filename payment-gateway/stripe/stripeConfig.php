<?php
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Adjust path to the root directory
$dotenv->load();
\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY'] ?? null);
// echo json_encode($_ENV);
?>