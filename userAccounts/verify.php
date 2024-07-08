<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
}
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
    <link rel="stylesheet" href="../css/themes/light/mobile/verify.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <div class="container mb-main-box">
        <p class="brand">Verify Account</p>
        <form method="post" class="form">
            <input type="text" class="verify" name="verify-code" placeholder="Verification Code" required autofocus>
            <input type="submit" name="submit" class="submit" value="Verify">
        </form>
        <a href="resend.php" class="resend">Resend Code</a>
        <a href="../index.php" class="back">Back</a>
        <p class="info">Verification code has been sent to your email address.</p>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>

<?php
require "../db.php";
if (isset($_POST["submit"])) {
    // Taking data from the form and sanitizing them
    $code = htmlspecialchars($_POST["verify-code"]);
    $username = $_SESSION["username"];

    // Condition if any field is empty
    if ($code != "") {
        if ($_SESSION["code"] == $code) {
            $query = $con->prepare("UPDATE accounts SET status='verified' WHERE username=:username");
            $query->bindParam(':username', $username);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $_SESSION["status"] = "verified";

            
            echo "<script>window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('please enter a valid verification code!');</script>";
        }
    } else {
        echo "<script>alert('please enter your verification code!');</script>";
    }
}
?>