<?php
session_start();
include("db_connection.php");
// Get JSON data from the request
$requestData = json_decode(file_get_contents("php://input"), true);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($requestData['review']) && isset($requestData["pid"])) {
        $review = $requestData["review"];
        $pid = $requestData["pid"];
        $uid = $_SESSION['uid'];
        $sql = "INSERT INTO reviews(u_id, p_id, review) values($uid , $pid , '$review')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
        }
    } elseif (isset($requestData['allReview']) && $requestData['allReview'] == true && isset($requestData["pid"])) {
        $pid = $requestData["pid"];
        $uid = $_SESSION['uid'];
        $sql = "SELECT reviews.*, users.u_name 
                FROM reviews 
                INNER JOIN users ON reviews.u_id = users.u_id
                WHERE reviews.p_id = $pid";

        // Execute the SQL query and fetch the reviews
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);

            // Send the reviews data as JSON
            header('Content-Type: application/json');
            echo json_encode($reviews);
        } else {
            // Handle the query error
            echo json_encode(['error' => 'Unable to fetch reviews', 'sql_error' => mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
