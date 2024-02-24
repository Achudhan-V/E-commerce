<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

session_start();

include("db_connection.php");

if (isset($_GET['search']) || isset($_GET['x'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $x = mysqli_real_escape_string($conn, $_GET['x']);
    // Fetch all rows
    $all = "SELECT p_id, p_name, p_price, p_img, p_description FROM products WHERE p_id >= $x AND p_id < ($x+100)";
    $allquery = mysqli_query($conn, $all);
    $allarray = array();

    if ($allquery) {
        $allarray = mysqli_fetch_all($allquery, MYSQLI_ASSOC);
    }
    // Apply htmlspecialchars to escape HTML content in the description
    foreach ($allarray as &$product) {
        $product['p_description'] = htmlspecialchars($product['p_description'], ENT_QUOTES, 'UTF-8');
    }

    // Remove spaces
    $searchLower = str_replace(' ', '', strtolower($search));

if (trim($searchLower) !== "") {
    $filteredProducts = [];

    //filtering logic 
    foreach ($allarray as $product) {
        $productNameLower = str_replace(' ', '', strtolower($product['p_name']));
        $result = strpos($productNameLower, $searchLower) !== false;
        if ($result) {
            $filteredProducts[] = $product;
        }
    }

    echo json_encode(array_values($filteredProducts));
} else {
    // If search is empty, return all products
    echo json_encode(array_values($allarray));
}


} else {
    echo json_encode(['error' => 'Invalid request parameters']);
}
mysqli_close($conn);
?>
