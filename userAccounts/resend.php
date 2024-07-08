<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
require "../db.php";
require '../vendor/autoload.php'; // Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$verifyEmail = mt_rand(100000, 999999);
$_SESSION["code"] = $verifyEmail;
$username = $_SESSION["username"];
$email = $_SESSION["email"];

$query = $con->prepare("UPDATE accounts SET verify=:verify WHERE username=:username");
$query->bindParam(':verify', $verifyEmail);
$query->bindParam(':username', $username);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);


$mail = new PHPMailer(true);  // Create a new PHPMailer instance


try {
    //Server settings
    $mail->SMTPDebug = 0;                    // Enable verbose debug output
    $mail->isSMTP();                         // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                // Enable SMTP authentication
    $mail->Username = 'Your Email'; // SMTP username
    $mail->Password = 'Your Password';     // SMTP password
    $mail->SMTPSecure = 'tls';               // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                 // TCP port to connect to

    //Recipients
    $mail->setFrom('Your Email', 'Pamager');
    $mail->addAddress($email, $username); // Add a recipient

    // Content
    $mail->isHTML(true);                     // Set email format to HTML
    $mail->Subject = 'Verify Your Pamager Account';
    $mail->Body = "Please Verify Your Pamager Account With The Following Code: " . $verifyEmail;
    $mail->AltBody = "Please Verify Your Pamager Account With The Following Code: " . $verifyEmail;

    $mail->send();

    header("Location: verify.php");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}