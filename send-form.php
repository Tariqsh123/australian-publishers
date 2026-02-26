<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $to = "burhan.032728@gmail.com, Info@kangaroopublishers.com";

    // Determine which form is submitted
    if(isset($_POST['name1'])){
        $name = htmlspecialchars($_POST['name1']);
        $email = htmlspecialchars($_POST['email1']);
        $phone = htmlspecialchars($_POST['phone1']);
        $country = htmlspecialchars($_POST['country1']);
        $book_title = htmlspecialchars($_POST['book_title1']);
        $genre = htmlspecialchars($_POST['genre1']);
        $details = htmlspecialchars($_POST['details1']);
        $file_field = 'file1';
        $subject = "New Book Quote Request from $name";

    } elseif(isset($_POST['name2'])){
        $name = htmlspecialchars($_POST['name2']);
        $email = htmlspecialchars($_POST['email2']);
        $phone = htmlspecialchars($_POST['phone2']);
        $country = htmlspecialchars($_POST['country2']);
        $book_title = htmlspecialchars($_POST['book_title2']);
        $genre = htmlspecialchars($_POST['genre2']);
        $details = htmlspecialchars($_POST['details2']);
        $file_field = 'file2';
        $subject = "New Consultation Request from $name";
    } else {
        // No recognized form submitted
        header("Location: index.html");
        exit();
    }

    $message = "
Name: $name
Email: $email
Phone: $phone
Country: $country
Book Title: $book_title
Genre: $genre
Details: $details
";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Handle file attachment
    if(isset($_FILES[$file_field]) && $_FILES[$file_field]['error'] == 0){
        $file_tmp = $_FILES[$file_field]['tmp_name'];
        $file_name = $_FILES[$file_field]['name'];
        $file_type = $_FILES[$file_field]['type'];
        $file_size = $_FILES[$file_field]['size'];
        $handle = fopen($file_tmp, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $encoded_content = chunk_split(base64_encode($content));

        $boundary = md5("random"); 

        $headers .= "MIME-Version: 1.0\r\n"; 
        $headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"\r\n";

        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
        $body .= $message."\r\n";

        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $file_type; name=\"".$file_name."\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"".$file_name."\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $encoded_content."\r\n";
        $body .= "--$boundary--";

        mail($to, $subject, $body, $headers);

    } else {
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        mail($to, $subject, $message, $headers);
    }

    // Redirect back to index.html
    header("Location: index.html?success=1");
    exit();
}
?>