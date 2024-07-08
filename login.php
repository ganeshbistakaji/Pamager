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
    <link rel="stylesheet" href="css/themes/light/mobile/login.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <!-- Log in box -->
    <div class="container mb-main-box">
        <p class="brand">Pamager</p>
        <form method="post" class="form">
            <input type="text" class="username" name="inp-user" placeholder="Username" required autofocus>
            <input type="password" class="password" name="inp-pass" placeholder="Password" required>
            <input type="submit" class="submit" value="Log In" name="submit">
        </form>
        <a href="signup.php" class="signup">Create Account</a>
        <a href="reset.php" class="forget">Forget Password?</a>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>
</body>

</html>

<?php
require "db.php";
if (isset($_POST["submit"])) {
    // Taking data from the form and sanitizing them
    $username = htmlspecialchars($_POST["inp-user"]);
    $pwd = htmlspecialchars($_POST["inp-pass"]);

    // Condition if any field is empty
    if ($username != "" || $email != "" || $pwd != "") {


        $query = $con->prepare("SELECT * FROM accounts WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            if (password_verify($pwd, $result["password"])) {
                // SESSION Values
                $_SESSION["username"] = $result["username"];
                $_SESSION["type"] = $result["type"];
                $_SESSION["status"] = $result["status"];
                $_SESSION["email"] = $result["email"];

                if($_SESSION["status"] == "unverified"){
                    $_SESSION["code"] = $result["verify"];
                }

                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Incorrect Password!');</script>";
            }
        } else {
            echo "<script>alert('Account with that username does not exist!');</script>";
        }
    } else {
        echo "<script>alert('please fill out all the fields!');</script>";
    }
}
?>