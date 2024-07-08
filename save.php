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
    <link rel="stylesheet" href="css/themes/light/mobile/save.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <!-- Save password box -->
    <div class="container mb-main-box">
        <p class="heading">Save Password</p>
        <form method="post" class="form">
            <select class="category" name="category">
                <option value="banking">Banking</option>
                <option value="wallet">Wallet</option>
                <option value="socials">Socials</option>
                <option value="google">Google</option>
                <option value="games">Games</option>
                <option value="others">Others</option>
            </select>

            <select class="platform" name="platform">
                <option value="appleid">Apple ID</option>
                <option value="behance">Behance</option>
                <option value="discord">Discord</option>
                <option value="dribble">Dribble</option>
                <option value="epicgames">Epic Games</option>
                <option value="facebook">Facebook</option>
                <option value="github">Github</option>
                <option value="gmail">Gmail</option>
                <option value="instagram">Instagram</option>
                <option value="microsoft">Microsoft</option>
                <option value="reddit">Reddit</option>
                <option value="snapchat">SnapChat</option>
                <option value="steam">Steam</option>
                <option value="tiktok">TikTok</option>
                <option value="ubisoft">Ubisoft</option>
                <option value="x">X</option>
                <option value="others">Others</option>
            </select>

            <input type="text" class="username" name="username" placeholder="Username/Email" required>

            <input type="text" class="password" name="password" placeholder="Password" required autocomplete="off">

            <input type="submit" class="submit" value="Save" name="submit">
        </form>
        <a href="index.php" class="back">Back</a>
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
    $category = htmlspecialchars($_POST["category"]);
    $platform = htmlspecialchars($_POST["platform"]);
    $username = htmlspecialchars($_POST["username"]);
    $pwd = htmlspecialchars($_POST["password"]);

    // Condition if any field is empty
    if ($username != "" || $category != "" || $pwd != "" || $platform != "") {
        try {
            $query = $con->prepare("INSERT INTO " . $_SESSION["username"] . "(category, platform, username, pwd) VALUES(:category, :platform, :username, :password)");
            $query->bindParam(':category', $category);
            $query->bindParam(':platform', $platform);
            $query->bindParam(':username', $username);
            $query->bindParam(':password', $pwd);
            $query->execute();

            echo "<script>alert('Saved Successfully');</script>";
            header("Location: index.php");
        }catch(Exception $e){
            echo $e->getMessage();
        }
    } else {
        echo "<script>alert('please fill out all the fields!');</script>";
    }
}
?>