<?php
// Collect form data
$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];
$food_items = isset($_POST['food']) ? implode(", ", $_POST['food']) : '';  // Combine selected food items into a string

// Database credentials
$host = "localhost";
$user = "root";
$pwd = "";
$db = "login_page";  // Replace with your actual database name

// Establish database connection
$connection = mysqli_connect($host, $user, $pwd, $db);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Validate inputs
if (empty($name) || empty($email) || empty($address) || empty($food_items)) {
    echo "<script>alert('All fields are required!'); window.history.back();</script>";
    exit();
}

// Prepare SQL query to insert data into the pickup table
$sql = "INSERT INTO pickup (name, email, address, items) VALUES (?, ?, ?, ?)";

// Prepare and bind statement
$stmt = $connection->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ssss", $name, $email, $address, $food_items);  // Bind the form fields and selected food items

    // Execute the statement
    if ($stmt->execute()) {
        // Success, show alert and redirect
        echo "<script>
                alert('Pickup request booked successfully!');
                window.location.href = 'contribute.html'; // Redirect to the contribute page
              </script>";
    } else {
        // Error executing query
        echo "<script>alert('Error: Unable to book pickup. Please try again later.'); window.history.back();</script>";
    }

    // Close statement
    $stmt->close();
} else {
    // Error preparing statement
    echo "<script>alert('Error: Unable to prepare query.'); window.history.back();</script>";
}

// Close the database connection
mysqli_close($connection);
?>
