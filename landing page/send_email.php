<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input to prevent email injection
    $name = filter_var(trim($_POST["name"]), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST["message"]), FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Invalid email format.";
        exit;
    }

    // Recipient email address
    $recipient = "yourcompanyemail@gmail.com";

    // Email subject
    $subject = "New Contact Form Submission from $name";

    // Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($recipient, $subject, $email_content, $headers)) {
        // Set a 200 (Success) response code.
        http_response_code(200);
        echo "Thank You! Your message has been sent.";
    } else {
        // Set a 500 (Internal Server Error) response code.
        http_response_code(500);
        echo "Oops! Something went wrong, and we couldn't send your message.";
    }

} else {
    // Set a 403 (Forbidden) response code if not a POST request.
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}
?>