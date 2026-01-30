<?php
// Enable error reporting for debugging (REMOVE OR SET TO 0 IN PRODUCTION)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../loginQuery/session_start.php';
include '../dbc.php';

// --- IMPORTANT: DEFINE YOUR UPLOAD PATHS HERE ---
// Determine the base upload directory. Adjust this path according to your project structure.
// Example: If 'action.php' is in 'your_project/api/' and 'uploads' is in 'your_project/',
// then '../uploads/' is correct relative to the current file's directory.
// Use '__DIR__' for the absolute path of the current script.
$baseUploadDir = __DIR__ . '/../uploads/'; 

// Define specific paths for products and product thumbnails
$productPath = $baseUploadDir . 'products/';
$productPathThumb = $baseUploadDir . 'products/products_thumb/'; // Dedicated folder for thumbnails

// Ensure the upload directories exist and are writable
// This will attempt to create them if they don't exist.
// You still need to ensure the web server has permissions to create/write to these.
if (!is_dir($productPath)) {
    mkdir($productPath, 0775, true); // 0775 permissions: owner/group can read/write/execute, others read/execute
}
if (!is_dir($productPathThumb)) {
    mkdir($productPathThumb, 0775, true);
}


if (!isset($conn)) {
    $response['status'] = 'error';
    $response['message'] = 'Database connection failed.';
    echo json_encode($response);
    exit;
}

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $case = $_POST['case'];

    switch ($case) {
        case 'InsertUpdate':
            InsertUpdate($conn);
            break;
        case 'InsertUpdateCusGroup':
            InsertUpdateCusGroup($conn);
            break;
        case 'delete_data':
            delete_data($conn);
            break;
        case 'InsertUpdateOffDyas':
            InsertUpdateOffDyas($conn);
            break;
        case 'InsertUpdateProduct': // New case to handle product update
            InsertUpdateProduct($conn);
            break;
        case 'AddProduct': // New case to handle product update
            AddProduct($conn);
            break;
        default:
            $response['status'] = 'error';
            $response['message'] = 'Invalid case';
            echo json_encode($response);
            break;
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
}


function AddProduct($conn)
{
    $response = array();

    // Get product information from POST data
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $group_id = mysqli_real_escape_string($conn, $_POST['group_id']);
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $size_id = mysqli_real_escape_string($conn, $_POST['size_id']); // Get the size_id from POST data
    $order_date = date('Ymd');

    // Fetch product details from tbl_product
    $product_query = "SELECT name, price FROM tbl_product WHERE id = '$product_id'";
    $product_result = mysqli_query($conn, $product_query);
    if ($product_row = mysqli_fetch_assoc($product_result)) {
        $product_name = $product_row['name'];
        $product_price = $product_row['price'];
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Product not found.';
        echo json_encode($response);
        exit;
    }

    $customer_query = "SELECT 
        c.name AS customer_name, 
        dt.name AS delivery_type_name
    FROM tbl_customer c
    LEFT JOIN tbl_delivery_type dt ON c.delivery_type_id = dt.id
    WHERE c.id = '$customer_id' ";

    $customer_result = mysqli_query($conn, $customer_query);

    if ($customer_row = mysqli_fetch_assoc($customer_result)) {
        $customer_name = $customer_row['customer_name'];
        $delivery_type_name = $customer_row['delivery_type_name']; // Fetch the delivery type name
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Customer not found.';
        echo json_encode($response);
        exit;
    }

    // Fetch size details from tbl_size
    $size_query = "SELECT name, unit FROM tbl_size WHERE id = '$size_id'";
    $size_result = mysqli_query($conn, $size_query);
    if ($size_row = mysqli_fetch_assoc($size_result)) {
        $size_name = $size_row['name'];
        $size_value = $size_row['unit']; // This can be used to calculate the total_amount
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Size not found.';
        echo json_encode($response);
        exit;
    }

    // Calculate total_amount (assuming size_value affects the total_amount)
    $total_amount = $product_price * $size_value; // Modify this formula based on your business logic

    // Insert the order into tbl_temp_order
    $insert_sql = "INSERT INTO tbl_temp_order 
                    (order_id, order_date, group_id, customer_id, customer_name, delivery_type, product_id, product_name, 
                     product_price, size_id, size_name, size_value, total_amount, cart_status)
                    VALUES
                    ('$order_id', '$order_date', '$group_id', '$customer_id', '$customer_name', '$delivery_type_name', '$product_id', 
                     '$product_name', '$product_price', '$size_id', '$size_name', '$size_value', '$total_amount', '0')";

    // Execute the query and check for success
    if (mysqli_query($conn, $insert_sql)) {
        $response['status'] = 'success';
        $response['message'] = 'Product added successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error adding product: ' . mysqli_error($conn);
    }

    // Return the response in JSON format
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function InsertUpdateProduct($conn)
{
    $response = array();

    // Get product information from POST data
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $product_row_id = mysqli_real_escape_string($conn, $_POST['product_row_id']);
    $price = mysqli_real_escape_string($conn, $_POST['price']); // Get the price from POST data

    // Get the size value (unit) for the selected size
    $size_query = "SELECT unit FROM tbl_size WHERE id = '$size'";
    $size_result = mysqli_query($conn, $size_query);
    if ($size_result) {
        $size_data = mysqli_fetch_assoc($size_result);
        $size_value = $size_data['unit']; // Assuming 'unit' is the multiplier

        // Calculate the total_amount (size_value * price)
        $total_amount = $size_value * $price;

        // Update the product's size, price, and total_amount
        $update_query = "
        UPDATE tbl_temp_order 
        SET 
            size_id = '$size', 
            size_name = (SELECT name FROM tbl_size WHERE id = '$size'),
            size_value = '$size_value',
            total_amount = '$total_amount'  -- Update total_amount
        WHERE id = '$product_row_id' AND product_id = '$product_id'
        ";

        if (mysqli_query($conn, $update_query)) {
            $response['status'] = 'success';
            $response['message'] = 'Product updated successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error updating product: ' . mysqli_error($conn);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error fetching size value: ' . mysqli_error($conn);
    }

    // Return the response in JSON format
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


function delete_data($conn)
{
    $response = array();

    $deleteId = mysqli_real_escape_string($conn, $_POST['delete_id']);
    $tableName = mysqli_real_escape_string($conn, $_POST['table_name']);  // Get the table name

    // Delete image files first if necessary
    for ($i = 1; $i <= 6; $i++) {
        if (isset($_POST['delete_image' . $i])) {
            $image = $_POST['delete_image' . $i];

            // Delete the image from the server (make sure to check if the file exists before deleting)
            if (file_exists($image)) {
                unlink($image);  // Delete the image file
            }
        }
    }

    // Construct and execute the delete query based on the table name
    $deleteQuery = "DELETE FROM `$tableName` WHERE id = '$deleteId'";

    // Execute the insert query
    if (mysqli_query($conn, $deleteQuery)) {
        $response['status'] = 'success';
        $response['message'] = 'Record deleted successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong. Please try again.';
        // Optionally print the MySQL error for debugging
        echo "Error: " . mysqli_error($conn);
    }

    // Set the content type and return the response in JSON format
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function InsertUpdate($conn)
{
    // Access the global variables defined at the top of the script
    global $productPath;
    global $productPathThumb;

    $response = array();
    $tableName = $_POST['table_name'];
    $pageName = $_POST['page_name'];
    $key_data   = $_POST['simple_data'];
    $image_data = isset($_POST['image_data']) ? $_POST['image_data'] : []; // Check if image_data exists
    $multiple_data = isset($_POST['multiple_data']) ? $_POST['multiple_data'] : []; // Check if multiple_data exists

    $reciveData = array();
    if (count($key_data) > 0) {
        foreach ($key_data as $key) {
            // Safely get data from the POST request
            $value = mysqli_real_escape_string($conn, $_POST[$key]);
            $reciveData[$key] = "'{$value}'";
        }
    }
    // =========================== Image Section start==============
    $i = 1;
    $imageKeyName[1] = "image1fleimage"; // Check if this key is correct as per your form
    $imageKeyName[2] = "image2fleimage"; // Check if this key is correct as per your form
    $imageKeyName[3] = "image3fleimage"; // Check if this key is correct as per your form
    $imageKeyName[4] = "image4fleimage"; // Check if this key is correct as per your form
    $imageKeyName[5] = "image5fleimage"; // Check if this key is correct as per your form
    $imageKeyName[6] = "image6fleimage"; // Check if this key is correct as per your form


    // Initialize an array to hold image upload data
    if (count($image_data) > 0) {
        foreach ($image_data as $key) {
            $image_key = $imageKeyName[$i]; // Ensure this matches the names in your form
            
            // Check if the file was actually uploaded and exists in $_FILES
            if (isset($_FILES[$image_key]) && $_FILES[$image_key]['error'] === UPLOAD_ERR_OK) {
                $image = $_FILES[$image_key];

                $newfile1 = null;
                $thumb1 = null;

                // Pass the correct variable
                [$newfile1, $thumb1] = handleImageUploadTeam($image, $productPath, $productPathThumb);
            
                if ($newfile1 !== null && $thumb1 !== null) {
                    $thumb_name = "thumb{$i}";
                    $reciveData[$key] = "'{$newfile1}'";
                    $reciveData[$thumb_name] = "'{$thumb1}'";
                } else {
                    // Log or handle the case where image upload fails inside handleImageUploadTeam
                    error_log("Image upload failed for key: " . $image_key);
                }
            } else if (isset($_FILES[$image_key])) {
                // Log specific upload errors
                error_log("File upload error for " . $image_key . ": " . $_FILES[$image_key]['error']);
            }
            $i++;
        }
    }
    // =========================== Image Section end==============
    if (count($multiple_data) > 0) {
        foreach ($multiple_data as $key) {
            // Safely get data from the POST request
            $valueAry = $_POST[$key];
            $value = "";
            if (count($valueAry) > 0) {
                $value = implode(',', $valueAry);
            }
            $reciveData[$key] = "'{$value}'";
        }
    }
    // =========================== Multiple Section end==============
    // =========================== Multiple Section end==============


    // Handle Insert or Update
    if (!empty($_POST['id'])) {
        // Update Logic
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $updateStringAry = array();
        foreach ($reciveData as $key => $value) {
            $updateStringAry[] = "{$key}={$value}";
        }
        $updateString = implode(', ', $updateStringAry); // Added space for readability
        // Update Query
        $query = "UPDATE {$tableName} SET {$updateString} WHERE id = '{$id}'";
        $message = "updated";
    } else {
        // Insert Logic
        $insertKey = implode(', ', array_keys($reciveData)); // Added space for readability
        $insertValue = implode(', ', $reciveData); // Added space for readability

        // Insert Query
        $query = "INSERT INTO {$tableName} ($insertKey) VALUES ($insertValue)";
        $message = "added";
    }

    // Execute SQL query
    if (mysqli_query($conn, $query)) {
        $response['status'] = 'success';
        $response['message'] = "{$pageName} {$message} successfully.";
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Something went wrong. Please try again.';
        // Print the MySQL error for debugging
        error_log("MySQL Error: " . mysqli_error($conn)); // Log to server error log
        echo "Error: " . mysqli_error($conn); // Echo for immediate client feedback (remove in production)
    }

    // Return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function handleImageUploadTeam($image, $productPath, $productPathThumb)
{
    // It's good practice to log errors internally for debugging.
    error_log("Attempting to upload image: " . $image['name']);
    error_log("Temp name: " . $image['tmp_name']);
    error_log("Product Path: " . $productPath);
    error_log("Product Thumb Path: " . $productPathThumb);

    if ($image['name'] != "") {
        $imageName = stripslashes($image['name']);
        $imageName = str_replace(' ', '_', $imageName); // Replace spaces with underscores
        $extension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($extension, ['jpg', 'jpeg', 'png'])) { // Excluded 'pdf'
            error_log("Invalid file extension: " . $extension);
            return [null, null];
        }

        $newFileName = uniqid() . '_' . $imageName; // Unique file name
        $uploadedFile = $image['tmp_name'];

        // Move uploaded file
        if (move_uploaded_file($uploadedFile, $productPath . $newFileName)) { // Use $productPath
            error_log("File moved successfully to: " . $productPath . $newFileName);
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                // Generate thumbnail
                list($width, $height) = getimagesize($productPath . $newFileName);
                $thumbWidth = 150;
                $thumbHeight = 150;
                $thumbRatio = min($thumbWidth / $width, $thumbHeight / $height);
                $newWidth = (int)($width * $thumbRatio);
                $newHeight = (int)($height * $thumbRatio);

                $thumbFileName = uniqid() . 'thumb_' . $imageName; // Added underscore for clarity
                $thumbnailPath = $productPathThumb . $thumbFileName; // Use $productPathThumb
                
                $thumbnail = imagecreatetruecolor($newWidth, $newHeight);

                // Handle transparency for PNG images
                if ($extension == 'png') {
                    imagealphablending($thumbnail, false);
                    imagesavealpha($thumbnail, true);
                    $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
                    imagefilledrectangle($thumbnail, 0, 0, $newWidth, $newHeight, $transparent);
                }


                switch ($extension) {
                    case 'jpg':
                    case 'jpeg':
                        $src = imagecreatefromjpeg($productPath . $newFileName);
                        break;
                    case 'png':
                        $src = imagecreatefrompng($productPath . $newFileName);
                        // Preserve transparency for PNG
                        imagealphablending($src, true); // Set to true to read existing alpha
                        imagesavealpha($src, true); // Save alpha channel on source
                        break;
                    default:
                        error_log("Unsupported image type for thumbnail generation: " . $extension);
                        return [$newFileName, null]; // Still return main file name if thumbnail fails
                }

                if ($src) {
                    // Resample and save thumbnail
                    imagecopyresampled($thumbnail, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    
                    // Save the thumbnail based on its type
                    if ($extension == 'png') {
                        imagepng($thumbnail, $thumbnailPath);
                    } else {
                        imagejpeg($thumbnail, $thumbnailPath, 90); // Use 90 quality for JPEG
                    }
                    
                    imagedestroy($src);
                    imagedestroy($thumbnail);
                    error_log("Thumbnail created successfully at: " . $thumbnailPath);
                    return [$newFileName, $thumbFileName];
                } else {
                    error_log("Failed to create image resource from uploaded file: " . $productPath . $newFileName);
                    return [$newFileName, null]; // Still return main file name if thumbnail fails
                }
            } else {
                error_log("File is not JPG/JPEG/PNG, skipping thumbnail generation: " . $productPath . $newFileName);
                return [$newFileName, null]; // Return only the new file name if it's not an image type for thumbnailing
            }
        } else {
            error_log("Failed to move uploaded file from " . $uploadedFile . " to " . $productPath . $newFileName . " Error: " . error_get_last()['message']);
            return [null, null];
        }
    }
    error_log("No file name provided for upload.");
    return [null, null];
}


function InsertUpdateCusGroup($conn)
{
    global $tblCustomerGroup, $tblGroup;  // Assuming $tblGroup is the name of the table where groups are stored
    $response = array();

    // Retrieve the posted data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $group_id = mysqli_real_escape_string($conn, $_POST['group_id']);
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);

    // Check if the customer is already assigned to any group
    $checkQuery = "
        SELECT g.name AS group_name 
        FROM tbl_customer_group cg
        JOIN tbl_group g ON cg.group_id = g.id
        WHERE cg.customer_id = '$customer_id'
    ";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // Fetch the group name the customer is already assigned to
        $existingGroup = mysqli_fetch_assoc($checkResult)['group_name'];

        // If the customer is already assigned to a group, show the error message
        $response['status'] = 'error';
        $response['message'] = "This customer is already assigned to Group '" . $existingGroup . "'.";
    } else {
        // Proceed with the insert query since customer is not yet assigned to any group
        $insertQuery = "INSERT INTO tbl_customer_group (group_id, customer_id) 
                         VALUES ('$group_id', '$customer_id')";

        // Execute the insert query
        if (mysqli_query($conn, $insertQuery)) {
            $response['status'] = 'success';
            $response['message'] = 'Customer Group added successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Something went wrong. Please try again.';
            // Optionally print the MySQL error for debugging
            error_log("MySQL Error in InsertUpdateCusGroup: " . mysqli_error($conn));
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Set the content type and return the response in JSON format
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

function InsertUpdateOffDyas($conn)
{
    global $tblOffDays;  // Assuming this is the name of the table you want to insert into
    $response = array();

    // Get the data from the POST request and sanitize it
    $customer_id = mysqli_real_escape_string($conn, $_POST['customer_id']);
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $from_date = mysqli_real_escape_string($conn, $_POST['from_date']);
    $to_date = mysqli_real_escape_string($conn, $_POST['to_date']);
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);


    // Convert the dates to timestamps for comparison
    $from_timestamp = strtotime($from_date);
    $to_timestamp = strtotime($to_date);

    // Ensure that the From Date is earlier than the To Date
    if ($from_timestamp > $to_timestamp) {
        $response['status'] = 'error';
        $response['message'] = 'From Date should be earlier than To Date';
        echo json_encode($response);
        exit;
    }

    // Array to hold all the values for batch insert
    $values = array();

    // Loop through each date in the range and add it to the values array
    $current_date = $from_timestamp;

    while ($current_date <= $to_timestamp) {
        // Format the current date into 'Y-m-d' format for database insertion
        $formatted_date = date('Y-m-d', $current_date);

        // Add the value for the current date to the array
        $values[] = "('$customer_id', '$product_id', '$formatted_date', '$remark')";

        // Move to the next day
        $current_date = strtotime("+1 day", $current_date);
    }

    // Prepare the SQL for the batch insert
    if (!empty($values)) {
        $insert_sql = "INSERT INTO tbl_off_days (customer_id, product_id, date, remark) VALUES " . implode(', ', $values);

        // Execute the batch insert
        if (mysqli_query($conn, $insert_sql)) {
            $response['status'] = 'success';
            $response['message'] = 'Off days successfully inserted.';
        } else {
            // If an error occurs during insertion, return the error message
            $response['status'] = 'error';
            $response['message'] = 'Error inserting data: ' . mysqli_error($conn);
            error_log("MySQL Error in InsertUpdateOffDyas: " . mysqli_error($conn));
        }
    } else {
        // If no dates were selected, return an error
        $response['status'] = 'error';
        $response['message'] = 'No valid dates to insert.';
    }

    // Return the final response as JSON
    echo json_encode($response);
    exit;
}

?>
