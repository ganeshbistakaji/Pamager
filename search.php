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
    <link rel="stylesheet" href="css/themes/light/mobile/search.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <!-- Mobile View -->
    <!-- Nav -->
    <nav class="container mb-nav">
        <form action="backend/searchHandler.php" method="post">
            <input type="text" placeholder="Search Passwords" class="searchbar">
            <input type="submit" value="Submit" hidden>
            
        </form>
        <div class="pfp">
            <img src="images/user/profile.avif" alt="" class="profile" class="profile" onclick="window.location.href='userAccounts/accountHome.php';">
        </div>
    </nav>

    

    <!-- Recents -->
    <div class="container mb-recent">

        <div class="items">
            <?php
            require "db.php";
            require "theme.php";
            $searchQuery = $_SESSION["searchQuery"];
            $query = $con->prepare("SELECT * FROM " . $_SESSION["username"] . " WHERE username LIKE :searchQuery OR category LIKE :searchQuery OR platform LIKE :searchQuery");
            $query->bindParam(":searchQuery", $searchQuery);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            if (count($results) > 0) {
                foreach ($results as $result) {
                    ?>
                    <form class="box" method="post">
                        <div class="left">
                            <div class="icon">
                                <img src="images/icons/<?php echo $_SESSION["theme"] . "/" . $result["platform"]; ?>.png" alt=""
                                    class="logo">
                            </div>
                            <div class="category-name">
                                <p class="name"><?php echo $result["username"]; ?></p>
                                <p class="app"><?php echo $result["platform"]; ?></p>
                            </div>
                        </div>

                        <input type="number" class="dataId" name="dataId" value="<?php echo $result["id"]; ?>" hidden>

                        <div class="right">
                            <input type="submit" class="view" name="submit" value="view">
                        </div>
                    </form>
                    <?php
                }
            } else {
                ?>
                <p class='notexist'>No recent passwords</p>
                <?php
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

</body>

</html>

<?php
if (isset($_POST["submit"])) {
    // Taking data from the form and sanitizing them
    $dataId = htmlspecialchars($_POST["dataId"]);
    $_SESSION["dataId"] = $dataId;
    echo '<script type="text/javascript">
            window.location = "passManage.php";
          </script>';
}
?>