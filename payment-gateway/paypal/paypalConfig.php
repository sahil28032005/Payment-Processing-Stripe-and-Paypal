<?php
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Adjust path to the root directory
$dotenv->load();
// \Stripe\Stripe::setApiKey($_ENV['PAYPAL_CLIENT_ID'] ?? null);
// \Stripe\Stripe::setApiKey($_ENV['PAYPAL_SECRET'] ?? null);
// \Stripe\Stripe::setApiKey($_ENV['PAYPAL_API_BASE'] ?? null);
// Test output
// echo $_ENV['PAYPAL_API_BASE'] . "<br>";
// echo $_ENV['PAYPAL_CLIENT_ID'] . "<br>";
// echo $_ENV['PAYPAL_SECRET'] . "<br>";

define('PAYPAL_API_BASE', getenv('PAYPAL_API_BASE'));
define('PAYPAL_CLIENT_ID', getenv('PAYPAL_CLIENT_ID'));
define('PAYPAL_SECRET', getenv('PAYPAL_SECRET'));

?>