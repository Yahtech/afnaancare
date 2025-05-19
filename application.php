<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $position = htmlspecialchars($_POST['position']);
    $message = htmlspecialchars($_POST['message']);

    // Collect file data
    $cv = $_FILES['cv'];

    // Email settings
    $to = 'yahyasiyaka@gmail.com'; // Replace with your email address
    $subject = "New Application from $name";

    // Email message
    $body = "
        <h2>New Application Received</h2>
        <p><strong>Full Name:</strong> $name</p>
        <p><strong>Email Address:</strong> $email</p>
        <p><strong>Phone Number:</strong> $phone</p>
        <p><strong>Position Applying For:</strong> $position</p>
        <p><strong>Additional Information:</strong> $message</p>
    ";

    // Email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Handle file upload
    if ($cv['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $cv['tmp_name'];
        $fileName = $cv['name'];
        $fileType = $cv['type'];
        $fileContent = file_get_contents($fileTmpPath);
        $encodedFile = chunk_split(base64_encode($fileContent));

        // Add attachment headers
        $boundary = md5(time());
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

        // Email body with attachment
        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/html; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n";
        $body .= "\r\n$body\r\n";

        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n";
        $body .= "\r\n$encodedFile\r\n";
        $body .= "--$boundary--\r\n";
    }

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        echo "<p>Application submitted successfully. Thank you!</p>";
    } else {
        echo "<p>There was an error submitting your application. Please try again.</p>";
    }
} else {
    echo "<p>Invalid request method.</p>";
}
?>