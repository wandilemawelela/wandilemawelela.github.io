<?php
if(isset($_POST['submit'])) {
    $to = "wandilemmawelela@gmail.com";
    $subject = "New message from your portfolio website!";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $headers = "From: $name <$email>";

    if(mail($to, $subject, $message, $headers)) {
        echo "Your message has been sent successfully.";
    } else {
        echo "Error: There was a problem sending your message.";
    }
}
?>