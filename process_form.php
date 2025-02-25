<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $position = htmlspecialchars($_POST['position']);
    $message = htmlspecialchars($_POST['message']);

    // Handle file upload
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] == UPLOAD_ERR_OK) {
        $cvTempPath = $_FILES['cv']['tmp_name'];
        $cvName = $_FILES['cv']['name'];
        $cvType = $_FILES['cv']['type'];
        $cvContent = chunk_split(base64_encode(file_get_contents($cvTempPath)));
    } else {
        die("Error uploading CV. Please try again.");
    }

    // Email details
    $to = "yahyasiyaka@gmail.com"; // Replace with your email address
    $subject = "New Application Submission";
    $boundary = md5(uniqid(time()));

    // Headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Message Body
    $body = "--$boundary\r\n";
    $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n";
    $body .= "\r\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Position: $position\n";
    $body .= "Message: $message\n";
    $body .= "\r\n";

    // Attach CV
    $body .= "--$boundary\r\n";
    $body .= "Content-Type: $cvType; name=\"$cvName\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$cvName\"\r\n";
    $body .= "\r\n";
    $body .= $cvContent;
    $body .= "\r\n";
    $body .= "--$boundary--";

    // Send Email
    if (mail($to, $subject, $body, $headers)) {
        echo "Your application has been submitted successfully.";
    } else {
        echo "Failed to send your application. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
