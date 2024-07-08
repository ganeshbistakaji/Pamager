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
    <link rel="stylesheet" href="css/themes/light/mobile/signup.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <!-- Sign up box -->
    <div class="container mb-main-box">
        <p class="brand">Pamager</p>
        <form method="post" class="form">
            <input type="text" class="username" name="inp-user" placeholder="Username" required autofocus>
            <input type="email" class="email" name="inp-email" placeholder="Email address" required>
            <input type="password" class="password" name="inp-pass" placeholder="Password" required>
            <input type="submit" class="submit" value="Sign Up" name="submit">
        </form>
        <a href="login.php" class="login">Log In</a>
        <p class="consent">By signing up you agree to our <span class="tos">terms of service</span> and <span
                class="pp">privacy policy</span>.</p>
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

if (isset($_POST["submit"])) {
    // Taking data from the form and sanitizing them
    $username = htmlspecialchars($_POST["inp-user"]);
    $email = htmlspecialchars($_POST["inp-email"]);
    $pwd = htmlspecialchars($_POST["inp-pass"]);
    $type = 0;
    $themeType = "light";
    $reset = "generate";
    $verifyEmail = mt_rand(100000, 999999);
    $status = "unverified";
    // Hasing the password
    $options = [
        'cost' => 12,
    ];
    $hash_pwd;

    if (defined('PASSWORD_ARGON2ID')) {
        $hash_pwd = password_hash($pwd, PASSWORD_ARGON2ID, $options);
    } else {
        $hash_pwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    }

    // Regex
    $user_regex = '/^[A-Za-z0-9_.]+$/';
    $pwd_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*-])[A-Za-z0-9!@#$%^&*-]{8,}$/';

    // Condition if any field is empty
    if ($username != "" || $email != "" || $pwd != "") {

        // Condition for password pattern
        if (preg_match($pwd_regex, $pwd)) {

            // Condition for blocked username
            if (preg_match($user_regex, $username) && $username != "accounts" && $username != "admin") {

                // Checking if username already exists or not
                $query = $con->prepare("SELECT * FROM accounts WHERE username = :username");
                $query->bindParam(':username', $username);
                $query->execute();

                if ($query->rowCount() > 0) {
                    echo "<script>alert('This username already exists!');</script>";
                } else {

                    // Checking if email already exists or not
                    $query = $con->prepare("SELECT * FROM accounts WHERE email = :email");
                    $query->bindParam(':email', $email);
                    $query->execute();

                    if ($query->rowCount() > 0) {
                        echo "<script>alert('Account with this email already exists!');</script>";
                    } else {

                        // Insert Data
                        $query = $con->prepare("INSERT INTO accounts(username, email, password, type, reset, theme, verify, status) VALUES(:username, :email, :password, :type, :reset, :theme, :verify, :status)");
                        $query->bindParam(':username', $username);
                        $query->bindParam(':email', $email);
                        $query->bindParam(':password', $hash_pwd);
                        $query->bindParam(':type', $type);
                        $query->bindParam(':reset', $reset);
                        $query->bindParam(':theme', $themeType);
                        $query->bindParam(':verify', $verifyEmail);
                        $query->bindParam('status', $status);
                        $query->execute();

                        $query = $con->prepare("CREATE TABLE $username (
                            id INT PRIMARY KEY AUTO_INCREMENT,
                            category VARCHAR(255),
                            platform VARCHAR(255),
                            username VARCHAR(255),
                            pwd VARCHAR(5000)
                          )");
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
                            $mail->Subject = 'Verify Your Pamager Account';
                            $mail->Body = "Please Verify Your Pamager Account With The Following Code: " . $verifyEmail;
                            $mail->AltBody = "Please Verify Your Pamager Account With The Following Code: " . $verifyEmail;

                            $mail->send();
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        echo "<script>alert('Account created successfully!');</script>";
                    }

                }
            } else {
                echo "<script>alert('Username can only be alpha-numeric and only contain a-z, 1-0, ., _');</script>";
            }
        } else {
            echo "<script>alert('Password must contain one Uppercase, lowercase, number, symbol and must be minimum 8 characters long.');</script>";
        }
    } else {
        echo "<script>alert('please fill out all the fields!');</script>";
    }
}
?>