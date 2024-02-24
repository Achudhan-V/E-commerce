<?php
include("db_connection.php");

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $mailid = $_POST["mailid"];
    $password = $_POST["password"];

    // Check if email is valid using a regex pattern
    if (!filter_var($mailid, FILTER_VALIDATE_EMAIL)) {
        $response['success'] = false;
        $response['message'] = "Invalid email address.";
    } elseif (strlen($password) < 8) {
    $response['success'] = false;
    $response['message'] = "Password must be at least 8 characters long.";
} else {
        // email already exists or not?
        $checkQuery = "SELECT COUNT(*) as count FROM users WHERE u_mailid = '$mailid'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if ($checkResult) {
            $row = mysqli_fetch_assoc($checkResult);
            $count = $row['count'];

            if ($count > 0) {
                $response['success'] = false;
                $response['message'] = "Email address already exists.";
            } else {
                // Email does not exist, proceed with database insertion
                $query = "INSERT INTO users (u_name, u_mailid, u_password) VALUES ('$username', '$mailid', '$password')";

                try {
                    $result = mysqli_query($conn, $query);
                    if ($result) {
                        $response['success'] = true;
                        $response['message'] = "Registration successful. Now you can login";
                    } else {
                        $response['success'] = false;
                        $response['message'] = "Registration failed.";
                    }
                } catch (mysqli_sql_exception $e) {
                    $response['success'] = false;
                    $response['message'] = "Registration failed.";
                }
            }
        } else {
            $response['success'] = false;
            $response['message'] = "Error occurred while checking email address.";
        }
    }
}

// Close the database connection
mysqli_close($conn);

// Send the JSON response
echo json_encode($response);
?>