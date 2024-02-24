<?php
session_start();
include("db_connection.php");

// Check if the request is for updating quantity and total
if (isset($_POST['updateQuantity'])) {
    $uid = $_SESSION['uid'];
    $productId = $_POST['productId'];
    $newQuantity = $_POST['newQuantity'];

    // Get the price and availability of the product
    $productInfoQuery = "SELECT p_price FROM products WHERE p_id = $productId";
    $productInfoResult = mysqli_query($conn, $productInfoQuery);

    if ($productInfoResult) {
        $productInfo = mysqli_fetch_assoc($productInfoResult);
        $productPrice = $productInfo['p_price'];
        
        $newTotal = $newQuantity * $productPrice;

            
            $updateCartQuery = "UPDATE cart SET quantity = $newQuantity, total = $newTotal WHERE u_id = $uid AND p_id = $productId";
            $updateCartResult = mysqli_query($conn, $updateCartQuery);

            $totalAmountQuery = "SELECT SUM(total) AS totalAmount FROM cart where u_id = $uid";
            $totalAmountResult = mysqli_query($conn, $totalAmountQuery);
            $totalAmountData = mysqli_fetch_assoc($totalAmountResult);
            $totalAmount = $totalAmountData['totalAmount'];

           if($updateCartResult){
            echo json_encode([
                'success' => true,
                'message' => 'Quantity updated successfully',
                'newTotal' => $newTotal,
                'totalAmount' => $totalAmount ,
            ]);

            exit;
        }
    }
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update quantity',
    ]);
    exit;
}

//  send the cart table response
$uid = $_SESSION['uid'];
$cartQuery = "SELECT c.p_id, p.p_img , p.p_name, p.p_price , c.quantity, c.total, p.available 
              FROM cart c INNER JOIN products p
               ON c.p_id = p.p_id
                WHERE c.u_id = $uid";

$cartResult = mysqli_query($conn, $cartQuery);
$cartData = [];

while ($cartItem = mysqli_fetch_assoc($cartResult)) {
    $cartData[] = $cartItem;
}

echo json_encode($cartData);
?>
