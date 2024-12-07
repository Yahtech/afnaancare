<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Validate data
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error";
        exit;
    }

    // Set the recipient email address
    $recipient = "yahyasiyaka@gmail.com"; // Replace with your email address

    // Set the email subject
    $email_subject = "New Contact Form Submission: $subject";

    // Build the email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Build the email headers
    $email_headers = "From: $name <$email>";

    // Send the email
    if (mail($recipient, $email_subject, $email_content, $email_headers)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "error";
}
?>
