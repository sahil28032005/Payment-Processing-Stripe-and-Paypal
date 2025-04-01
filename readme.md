# Payment Gateway Integration

This project demonstrates a payment gateway integration with support for **Stripe** and **PayPal** using PHP. The project is organized to help you set up, configure, and test the payment gateways quickly and efficiently.

---

## Project Structure

```
project-root/
├── composer.json
├── composer.lock
├── payment-processor.php
└── payment-gateway-task/
    ├── paypal/
    │   └── .env
    ├── stripe/
    │   └── .env
```

---

## Prerequisites

- PHP 7.4 or later.
- **XAMPP** or any other PHP server.
- [Composer](https://getcomposer.org/) installed.
- Internet connection to fetch dependencies via Composer.

---

## Setup Guide

### 1. Configure Environment Variables

#### Stripe Configuration
Navigate to the `stripe` folder inside `payment-gateway-task` and edit the `.env` file:

```
STRIPE_SECRET_KEY=your_stripe_secret_key
```

#### PayPal Configuration
Navigate to the `paypal` folder inside `payment-gateway-task` and edit the `.env` file:

```
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret
PAYPAL_API_BASE=https://api-m.sandbox.paypal.com
```

> **Note:** Replace the placeholders (`your_*`) with your actual API credentials.

---

### 2. Install Dependencies

Run the following command to install the required PHP packages:

```bash
composer install
```

This will install all dependencies defined in the `composer.json` file, similar to how `npm install` works for Node.js projects.

---

### 3. Start the PHP Server

You can use **XAMPP** or any other PHP server of your choice. For example, to start the built-in PHP server, navigate to the project directory and run:

```bash
php -S localhost:8000
```

---

### 4. Test the Payment Gateways

#### PayPal
To test PayPal, use the following GET request:

```
https://localhost/payment-processor.php?user_id=1&item_id=2&payment_amount=10&gateway=paypal&transaction_type=wallet_reload
```

#### Stripe
To test Stripe, use the following GET request:

```
https://localhost/payment-processor.php?user_id=1&item_id=2&payment_amount=10&gateway=stripe&transaction_type=wallet_reload
```

---

### 5. Highlight: Switching Payment Gateways

The `gateway` parameter in the URL controls which payment processor to use. For example:

- `gateway=paypal`: Routes the request to the **PayPal** integration.
- `gateway=stripe`: Routes the request to the **Stripe** integration.

You can change this dynamically based on your application requirements.

---

## Additional Notes

- Ensure your `.env` files are not publicly exposed for security purposes.
- Use valid API credentials while testing or deploying.
- You can integrate additional payment gateways by extending the current architecture.

---

## Troubleshooting

- **Environment Variables Not Loading**: Double-check that your `.env` files are properly formatted and saved.
- **Composer Installation Fails**: Ensure Composer is correctly installed and added to your system's PATH.
- **Server Not Starting**: Confirm your PHP installation and server configuration.

---
## Cloning the Repository

To clone this repository, use the following command:

```bash
git clone https://github.com/sahil28032005/Payment-Processing-Stripe-and-Paypal.git

Happy coding! 🚀
