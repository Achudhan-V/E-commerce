<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['admin'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$requestData = json_decode(file_get_contents("php://input"), true);
    if (isset($requestData['adminname']) && isset($requestData['password'])) {
        // Login functionality
        $name = $requestData['adminname'];
        $pass = $requestData['password'];

        if ($name === "Administrator" && $pass === "wondercart123") {
            $_SESSION['admin'] = true;
            echo json_encode(['success' => true, 'message' => 'Login successful']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
        }
    } elseif (isset($requestData['getMaxId']) && $requestData['getMaxId'] === true && isset($requestData['range'])) {
        // Fetch max product ID functionality
        $range = (int)$requestData['range'];
        $maxIdQuery = "SELECT MAX(p_id) AS maxId FROM products WHERE p_id >= $range AND p_id < " . ($range + 100);
        $maxIdResult = mysqli_query($conn, $maxIdQuery);

        if ($maxIdResult) {
            $maxIdData = mysqli_fetch_assoc($maxIdResult);
            $maxId = $maxIdData['maxId'] ?? $range-1;  //for 1st item in a category the $range is starting p_id.
            
            $maxId+=1; //increment by one because next product shud be inserted.
           
            echo json_encode(['success' => true, 'maxId' => $maxId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to fetch max p_id.']);
        }
    } elseif (isset($requestData['insertItem']) && $requestData['insertItem'] === true) {
        // Insert item into products table
        $pid = $requestData['pid'];
        $pname = $requestData['pname'];
        $psrc = $requestData['psrc'];
        $pprice = $requestData['pprice'];
        $pdesc = $requestData['pdesc'];
        $pavail = $requestData['pavail'];

        $insertQuery = "INSERT INTO products (p_id, p_name, p_price, p_description, p_img, available) 
                        VALUES ('$pid', '$pname', '$pprice','$pdesc', '$psrc', '$pavail')";
        
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            echo json_encode(['success' => true, 'message' => 'Item inserted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert item.']);
        }
    } 
    elseif (isset($requestData['getRows']) && $requestData['getRows'] === true && isset($requestData['range'])) {
    // Fetch rows functionality
    $range = (int)$requestData['range'];
    $fetchRowsQuery = "SELECT p_id, p_name, p_img, p_price, p_description, available
                      FROM products WHERE p_id >=" . $range ." AND p_id < " . ($range + 100);
    $fetchRowsResult = mysqli_query($conn, $fetchRowsQuery);

    if ($fetchRowsResult) {
       $rows = mysqli_fetch_all($fetchRowsResult, MYSQLI_ASSOC);
// Apply utf8_encode to each field value
foreach ($rows as &$row) {
    foreach ($row as &$value) {
        $value = utf8_encode($value);
    }
}

$response = array_values($rows);
$jsonResponse = json_encode(['success' => true, 'rows' => $response]); 

if ($jsonResponse === false) {
    echo "JSON Error: " . json_last_error_msg();
} else {
    echo $jsonResponse;
}
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch rows']);
    }
}

    elseif(isset($requestData['removeRow']) && $requestData['removeRow'] === true && isset($requestData['pid'])){
        $pid = (int)$requestData['pid'];

        $sql = "DELETE FROM products where p_id = $pid";
        $sqlc="DELETE FROM cart where p_id = $pid";
        $sqlquery = mysqli_query($conn , $sql);
        $sqlcquery = mysqli_query($conn , $sqlc);
        if($sqlquery){
            if($sqlcquery){
                echo json_encode(['success' => true , "msg" => "product $pid deleted"]);
            }

        }
        else{
          echo json_encode(["success" => false , "msg" => "Failed to delete"]);
        }
    }
    else {
        echo json_encode(['success' => false, 'message' => 'Invalid request parameters.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
