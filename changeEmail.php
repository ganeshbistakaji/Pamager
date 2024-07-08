<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords"
        content="Manager, Password, Password Manager, Password Save, Password Gen, Generator, Password Generator">
    <meta name="description"
        content="Pamager is a free open source project which can be hosted by anybody for free and create their own local password manager website, app or host it for the public.">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- STYLESHEET -->
    <!-- Mobile -->
    <link rel="stylesheet" href="css/themes/light/mobile/changeEmail.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <!-- Log in box -->
    <div class="container mb-main-box code">
        <p class="brand">Change Email</p>
        <form method="post" class="form">
            <input type="email" class="email" name="email-inp" placeholder="New Email Address" required autofocus>
            <input type="submit" class="submit" value="Send Code" name="send-code">
        </form>
        <a href="index.php" class="back">Back</a>
    </div>

    <div class="container mb-main-box new-email">
        <p class="brand">Change Email</p>
        <form method="post" class="form">
            <input type="text" class="code" name="code-inp" placeholder="Verification Code" required>
            <input type="submit" class="submit" value="Reset" name="reset">
        </form>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>

<?php
require "db.php";
require 'vendor/autoload.php'; // Load Composer's autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["send-code"])) {

    $resetCode = mt_rand(100000, 999999);
    $email = $_POST["email-inp"];
    $_SESSION["email"] = $email;
    $username = $_SESSION["username"];

    $query = $con->prepare("UPDATE accounts SET reset=:reset WHERE username=:username");
    $query->bindParam(':reset', $resetCode);
    $query->bindParam(':username', $username);
    $query->execute();


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
        $mail->Subject = 'Change Email Pamager';
        $mail->Body = "Please Enter The Following Code To Change Your Email: " . $resetCode;
        $mail->AltBody = "Please Enter The Following Code To Change Your Email: " . $resetCode;
        $mail->send();
        echo "<script>
        document.querySelector('.code').style.display = 'none';
        document.querySelector('.new-email').style.display = 'block';
        </script>";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($_POST["reset"])) {

    $code = htmlspecialchars($_POST["code-inp"]);
    $email = $_SESSION["email"];
    $username = $_SESSION["username"];


    // Getting code from DB
    $query = $con->prepare("SELECT reset from accounts WHERE username=:username");
    $query->bindParam(':username', $username);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    // Condition if any field is empty
    if ($email != "") {

        if ($code == $result["reset"]) {
            $query = $con->prepare("UPDATE accounts SET email=:email WHERE username=:username");
            $query->bindParam(':email', $email);
            $query->bindParam(':username', $username);
            $query->execute();
            header("Location: logout.php");
        } else {
            echo "<script>alert('Incorrect Code');</script>";
        }
    } else {
        echo "<script>alert('please enter a email!');</script>";
    }
}
?>