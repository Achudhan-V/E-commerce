<?php
session_start();

// Include your database connection file
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $username = $_POST["username"];
    $password = $_POST["password"];
 
    // Retrieve user data from the database
    $query = "SELECT * FROM users WHERE u_name='$username' AND u_password='$password'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        
        // Verify if a user with the given username and password exists
        if ($row) {
            // Password is correct, create a session
            $_SESSION["uid"] = $row["u_id"];
            $_SESSION["uname"] = $row["u_name"];
            $_SESSION["umailid"] = $row["u_mailid"];
            $response = array("success" => true, "message" => "Login successful. Welcome, $username!");
        } else {
            $response = array("success" => false, "message" => "Invalid username or password.");
        }
    } else {
        $response = array("success" => false, "message" => "Error: " . mysqli_error($conn));
    }
} else {
    $response = array("success" => false, "message" => "Invalid request method.");
}

// Close the database connection
mysqli_close($conn);

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>