<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recipients
    $to = "burhan.032728@gmail.com, Info@kangaroopublishers.com";

    // Collect form data safely
    $treat = htmlspecialchars($_POST['treat'] ?? '');
    $manuscript_ready = htmlspecialchars($_POST['manuscript_ready'] ?? '');
    $book_type = htmlspecialchars($_POST['book_type'] ?? '');
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $description = htmlspecialchars($_POST['description'] ?? '');

    // Email subject
    $subject = "New Three Step Form Submission from $name";

    // Email body
    $message = "
Treat Yourself With: $treat
Manuscript Ready: $manuscript_ready
Book Type: $book_type
Name: $name
Email: $email
Phone: $phone
Description: $description
";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email (no file attachment in this form)
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    mail($to, $subject, $message, $headers);

    // Redirect back to homepage after submit
    header("Location: index.html?success=1");
    exit();
}
?>