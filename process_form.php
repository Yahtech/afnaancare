<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $position = htmlspecialchars($_POST['position']);
    $message = htmlspecialchars($_POST['message']);

    // Recipient email
    $to = "yahyasiyaka@gmail.com"; // Replace with your email address

    // Email subject
    $subject = "New Application from $name";

    // Email body
    $body = "You have received a new application.\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Phone: $phone\n" .
            "Position: $position\n\n" .
            "Additional Information:\n$message";

    // Email headers
    $headers = "From: $email\r\n" .
               "Reply-To: $email\r\n";

    // Send email and display result
    if (mail($to, $subject, $body, $headers)) {
        $success_message = "Thank you for your application, $name! Your application has been submitted successfully.";
    } else {
        $error_message = "Something went wrong. We were unable to send your application. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
    }

    .container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    label {
      font-weight: bold;
      margin-bottom: 5px;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    textarea {
      resize: vertical;
    }

    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #45a049;
    }

    .message {
      text-align: center;
      padding: 10px;
      margin: 20px 0;
      border-radius: 5px;
    }

    .success {
      background-color: #d4edda;
      color: #155724;
    }

    .error {
      background-color: #f8d7da;
      color: #721c24;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Application Form</h1>
    <?php if (isset($success_message)): ?>
      <div class="message success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
      <div class="message error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form action="" method="POST">
      <label for="name">Full Name:</label>
      <input type="text" id="name" name="name" placeholder="Enter your full name" required>

      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>

      <label for="position">Position Applying For:</label>
      <select id="position" name="position" required>
        <option value="Caregiver">Caregiver</option>
        <option value="Nurse">Nurse</option>
        <option value="Administrator">Administrator</option>
        <option value="Other">Other</option>
      </select>

      <label for="message">Additional Information:</label>
      <textarea id="message" name="message" rows="5" placeholder="Enter any additional information"></textarea>

      <button type="submit">Submit Application</button>
    </form>
  </div>
</body>

</html>
