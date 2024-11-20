<?php
// Collect form data
$name = $_POST['name'];
$email = $_POST['email'];
$location = $_POST['location'];  // This will contain the value "Orphanage"

// Database credentials
$host = "localhost";
$user = "root";
$pwd = "";
$db = "login_page";

// Establish database connection
$connection = mysqli_connect($host, $user, $pwd, $db);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if the name and email fields are filled
if (empty($name) || empty($email)) {
    echo "<script>alert('All fields are required!'); window.history.back();</script>";
    exit();
}

// Prepare SQL query to insert data into the appointment table
$sql = "INSERT INTO appointment (name, email, location) VALUES (?, ?, ?)"; // Assuming 'location' column is added in the 'appointment' table

// Prepare and bind statement
$stmt = $connection->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sss", $name, $email, $location);  // Bind the 'location' value as well

    // Execute the statement
    if ($stmt->execute()) {
        // Success, show alert and redirect
        echo "<script>
                alert('Appointment booked successfully!');
                window.location.href = 'contribute.html'; // Redirect to contribute page
              </script>";
    } else {
        // Error executing query
        echo "<script>alert('Error: Unable to book appointment. Please try again later.'); window.history.back();</script>";
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
