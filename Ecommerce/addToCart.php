<?php
session_start();
include("db_connection.php");

if (isset($_GET['p_id'])) {
    $productId = mysqli_real_escape_string($conn, $_GET['p_id']);
    $userId = $_SESSION['uid'];

    // Check if the product is already added to the cart by the user
    $checkQuery = "SELECT * FROM cart WHERE u_id = '$userId' AND p_id = '$productId'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Product already added to the cart
        echo json_encode(["message" => "Product already added to cart"]);
    } else {
        // Add the product to the cart
        $productPrice = mysqli_real_escape_string($conn, $_GET['p_price']);
        $insertQuery = "INSERT INTO cart (u_id, p_id, quantity, total) VALUES ('$userId', '$productId', 1, '$productPrice')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo json_encode(["message" => "Product added to cart successfully"]);
        } else {
            echo json_encode(["message" => "Failed to add product to cart"]);
        }
    }
} else {
    echo json_encode(["message" => "Invalid request"]);
}

// Close the database connection
mysqli_close($conn);
?>