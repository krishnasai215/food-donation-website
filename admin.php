<?php
// Start session
session_start();

// Check if the user is logged in and is admin
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@admin.com') {
    header("Location: loginsignup.html");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$password = "";  // Your MySQL password
$dbname = "login_page";  // Your database name

$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data for all tables
$appointment_sql = "SELECT * FROM appointment";
$appointment_result = $conn->query($appointment_sql);

$users_sql = "SELECT * FROM users";
$users_result = $conn->query($users_sql);

$pickup_sql = "SELECT * FROM pickup";
$pickup_result = $conn->query($pickup_sql);

$donations_sql = "SELECT * FROM donations";
$donations_result = $conn->query($donations_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-black">

    <!-- Navbar -->
    <nav class=" top-0 left-0 w-full flex justify-between items-center p-4 bg-gray-950 bg-opacity-50 z-20">
        <span class="text-white text-5xl font-bold p-5">Admin Dashboard</span>
        <a href="loginsignup.html" class="text-white rounded-lg border border-white px-4 py-2 hover:bg-white hover:text-black transition-colors">Logout</a>
    </nav>

    <main class="container mx-auto mt-16 p-4">
       <!-- <h1 class="text-3xl font-bold mb-6 text-center text-white">Admin Dashboard</h1> -->
</br>
</br>
        <!-- Appointment Table -->
        <h2 class="text-2xl font-bold mb-4 text-white">Appointments</h2>
        <?php if ($appointment_result->num_rows > 0): ?>
            <table class="min-w-full bg-white rounded-lg overflow-hidden mb-8">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Appointment Time</th>
                        <th class="py-2 px-4 text-left">Location</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = $appointment_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo $row['id']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['name']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['email']; ?></td>
                            <td class="py-2 px-4"><?php echo date("F j, Y, g:i a", strtotime($row['appointment_time'])); ?></td>
                            <td class="py-2 px-4"><?php echo $row['location']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No appointments found.</p>
        <?php endif; ?>

        <!-- Users Table -->
        <h2 class="text-2xl font-bold mb-4 text-white">Users</h2>
        <?php if ($users_result->num_rows > 0): ?>
            <table class="min-w-full bg-white rounded-lg overflow-hidden mb-8">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Email</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = $users_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo $row['id']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['name']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['email']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>

        <!-- Pickup Table -->
        <h2 class="text-2xl font-bold mb-4 text-white">Pickup Requests</h2>
        <?php if ($pickup_result->num_rows > 0): ?>
            <table class="min-w-full bg-white rounded-lg overflow-hidden mb-8">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Food Item</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Address</th>
                        <th class="py-2 px-4 text-left">Appointment Time</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = $pickup_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo $row['id']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['name']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['items']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['email']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['address']; ?></td>
                            <td class="py-2 px-4"><?php echo date("F j, Y, g:i a", strtotime($row['appointment_time'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pickup requests found.</p>
        <?php endif; ?>

        <!-- Donations Table -->
        <h2 class="text-2xl font-bold mb-4 text-white">Donations</h2>
        <?php if ($donations_result->num_rows > 0): ?>
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Email</th>
                        <th class="py-2 px-4 text-left">Amount</th>
                        <th class="py-2 px-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php while ($row = $donations_result->fetch_assoc()): ?>
                        <tr>
                            <td class="py-2 px-4"><?php echo $row['id']; ?></td>
                            <td class="py-2 px-4"><?php echo $row['email']; ?></td>
                            <td class="py-2 px-4"><?php echo "₹" . $row['amount']; ?></td>
                            <td class="py-2 px-4"><?php echo date("F j, Y", strtotime($row['donation_date'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No donations found.</p>
        <?php endif; ?>
    </main>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
