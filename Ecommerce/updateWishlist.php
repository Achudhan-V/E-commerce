<?php
session_start();

include("db_connection.php");

if (isset($_GET['pid'])) {
    $pid = (int)$_GET['pid'];
    $uid = $_SESSION['uid'];

    // Check if the product is already in the wishlist
    $checkQuery = "SELECT wish FROM wishlist WHERE u_id = $uid AND p_id = $pid";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $updateQuery = "UPDATE wishlist SET wish = 1 - wish WHERE u_id = $uid AND p_id = $pid";
        mysqli_query($conn, $updateQuery);
    } else {
        $insertQuery = "INSERT INTO wishlist (u_id, p_id, wish) VALUES ($uid, $pid, 1)";
        mysqli_query($conn, $insertQuery);
    }
} 
elseif(isset($_GET['wish'])){
    // Initial wishlist details
    $uid = $_SESSION['uid'];
    $wishlistQuery = "SELECT wishlist.p_id, products.p_name, products.p_img, products.p_price
                      FROM wishlist
                      INNER JOIN products ON wishlist.p_id = products.p_id
                      WHERE wishlist.u_id = $uid AND wishlist.wish = 1";
    $wishlistResult = mysqli_query($conn, $wishlistQuery);

    if ($wishlistResult) {
        $wishlistItems = mysqli_fetch_all($wishlistResult, MYSQLI_ASSOC);
        echo json_encode($wishlistItems);
    } else {
        echo json_encode(["error" => "Unable to fetch wishlist details"]);
    }
}

elseif(isset($_GET['removeWish'])) {
    $pid = (int)$_GET['removeWish'];
    $uid = $_SESSION['uid'];

    // Update the wishlist table to set wish to 0
    $updateQuery = "UPDATE wishlist SET wish = 0 WHERE u_id = $uid AND p_id = $pid";
    mysqli_query($conn, $updateQuery);
 
}
else {
    // initial wishlist details 
    $uid = $_SESSION['uid'];
    $initialWishlistQuery = "SELECT CAST(p_id AS CHAR) as p_id, wish FROM wishlist WHERE u_id = $uid";
    $initialWishlistResult = mysqli_query($conn, $initialWishlistQuery);

    if ($initialWishlistResult) {
        $wishlistItems = mysqli_fetch_all($initialWishlistResult, MYSQLI_ASSOC);
        echo json_encode($wishlistItems);
    } else {
        echo json_encode(["error" => "Unable to fetch wishlist details"]);
    }
}
?>
