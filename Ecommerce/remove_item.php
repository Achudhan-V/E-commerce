<?php
session_start();

// Include your database connection file
include("db_connection.php");

$uid = $_SESSION['uid'];

// Get the p_id parameter from the URL
$p_id = $_GET['p_id'];

// Perform the delete operation in the cart table
$deleteQuery = "DELETE FROM cart WHERE u_id = $uid AND p_id = $p_id";
  $sql = mysqli_query($conn, $deleteQuery);

  $uid = $_SESSION['uid'];
  $totalAmountQuery = "SELECT SUM(total) AS totalAmount FROM cart where u_id = $uid";
  $totalAmountResult = mysqli_query($conn, $totalAmountQuery);
  $totalAmountData = mysqli_fetch_assoc($totalAmountResult);
  $totalAmount = $totalAmountData['totalAmount'];

if($sql){
    echo json_encode(["success" => true , "tot" => $totalAmount]);
}
else{
    echo json_encode(["success" => false]);
}

exit();


?>
