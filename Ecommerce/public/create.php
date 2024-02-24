<?php
session_start();
include('../db_connection.php');
require_once '../vendor/autoload.php';
require_once '../secrets.php';

$stripe = new \Stripe\StripeClient($stripeSecretKey);

// Function to fetch the total amount from the user's cart in the database
function calculateOrderAmountFromDatabase($userId): int {
    global $conn;  // Assuming $conn is your MySQLi connection object

    $userId = mysqli_real_escape_string($conn, $userId);

    $query = "SELECT SUM(total) as totalAmount FROM cart WHERE u_id = '$userId'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return isset($row['totalAmount']) ? (int)$row['totalAmount'] : 0;
    } else {
        // Handle the query error if needed
        return 0;
    }
}

header('Content-Type: application/json');

try {
    // Check if the user is logged in
    if (!isset($_SESSION['uid'])) {
        throw new Exception('User not logged in.');
    }

    // Now you have the user ID
    $userId = $_SESSION['uid'];

    // Create a description for the payment
    $description = "Payment for items from user's cart";
    
    
    // Customer information (name and address)
    // Replace with the actual customer details
    $customerName = $_SESSION['uname'];
    $customerEmail = $_SESSION['umailid'];
    $customerAddress = [
        'line1' => '123 Main Street',
        'city' => 'City',
        'state' => 'State',
        'postal_code' => '12345',
        'country' => 'US', // Replace with a country outside India
    ];
    // Create the customer
    $customer = $stripe->customers->create([
        'name' => $customerName,
        'email' => $customerEmail,
        'address' => $customerAddress,
    ]);

    // Now you have the customer ID
    $customerId = $customer->id;

    // Create the payment intent with the customer ID and description
    $paymentIntent = $stripe->paymentIntents->create([
        'amount' => calculateOrderAmountFromDatabase($userId),
        'currency' => 'inr',
        'automatic_payment_methods' => [
            'enabled' => true,
        ],
        'customer' => $customerId,
        'description' => $description, // Add the description for the payment
    ]);

    // Return the client secret
    $output = [
        'clientSecret' => $paymentIntent->client_secret,
    ];

    echo json_encode($output);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
