<?php
// Start session and include database connection
// Assuming '../dbc.php' contains your database connection ($conn) and other config variables.
include '../loginQuery/session_start.php';
include '../dbc.php';

// Start output buffering to prevent header issues if there's any preceding output
ob_start();

// Set the content type to JSON immediately
header('Content-Type: application/json');

// Initialize a response array
$response = ['error' => 'An unknown error occurred.'];

// Check if 'action' parameter is set in the GET request
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getCities':
            // Ensure 'state_id' is provided in the POST request for getCities
            if (isset($_POST['state_id'])) {
                // Sanitize the input to prevent SQL injection
                $stateId = mysqli_real_escape_string($conn, $_POST['state_id']);

                $query = "SELECT * FROM tbl_city WHERE state_id = '$stateId'";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    $cities = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $cities[] = $row;
                    }
                    $response = $cities; // Return the array of cities
                } else {
                    // Log the actual MySQL error for debugging on the server
                    error_log("MySQL error in getCities: " . mysqli_error($conn));
                    $response = ['error' => 'Failed to fetch cities from database.'];
                }
            } else {
                $response = ['error' => 'State ID not provided for getCities action.'];
            }
            break;

        case 'getPrice':
            // Ensure 'product_id' is provided in the GET request for getPrice
            if (isset($_GET['product_id'])) {
                // Sanitize the product ID
                $productId = mysqli_real_escape_string($conn, $_GET['product_id']);

                // Query to get the price of the selected product
                // Using prepared statements is highly recommended for security, especially with user input.
                // For simplicity, sticking to the existing mysqli_query here but noting the best practice.
                $query = "SELECT price FROM tbl_product WHERE id = '$productId'";
                $result = mysqli_query($conn, $query);

                // Check if the product exists and return the price
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $response = ['price' => $row['price']]; // Return the price
                } else {
                    $response = ['error' => 'Product not found or no price available.'];
                }
            } else {
                $response = ['error' => 'Product ID not provided for getPrice action.'];
            }
            break;

        default:
            $response = ['error' => 'Invalid action specified.'];
            break;
    }
} else {
    $response = ['error' => 'Action parameter not specified.'];
}

// Clear any buffered output before sending the JSON response
ob_clean();

// Send the JSON response
echo json_encode($response);

// End output buffering
ob_end_flush();
?>