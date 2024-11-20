<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Validate data
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
        exit();
    }

    // Set the recipient email address
    $to = "vssaikrishna2003@gmail.com";  // Replace with your actual email
    $subject = "Contact Form Submission from: $name";

    // Prepare the email body
    $email_content = "You have received a new message from your website contact form.\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Message:\n$message\n";

    // Set the headers for the email
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send the email
    if (mail($to, $subject, $email_content, $headers)) {
        echo json_encode(['status' => 'success', 'message' => 'Your message has been sent successfully!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to send message. Please try again later.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
