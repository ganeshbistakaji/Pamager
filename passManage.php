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

    <!-- STYLESHEET -->
    <!-- Mobile -->
    <link rel="stylesheet" href="css/themes/light/mobile/passManage.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <!-- Save password box -->
    <div class="container mb-main-box">
        <p class="heading">Manage Password</p>
        <?php
        require "db.php";
        $dataId = $_SESSION["dataId"];
        $query = $con->prepare("SELECT * FROM " . $_SESSION["username"] . " WHERE id=:dataId");
        $query->bindParam("dataId", $dataId);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC); ?>
        <div class="form">
            <img src="images/icons/<?php echo $_SESSION["theme"] . "/" . $result["platform"]; ?>.png" alt=""
                class="icon">
            <div class="username"><?php echo $result["username"]; ?></div>
            <div class="password"><?php echo $result["pwd"]; ?></div>
            <input type="number" class="manageId" name="manageId" value="<?php echo $result["id"]; ?>" hidden>
            <input type="submit" class="submit" value="Delete" name="submit">
        </div>
        <a href="index.php" class="back">Back</a>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>
        // Copy Password
        function copyText(element) {
            // Check if the Clipboard API is supported
            if (!navigator.clipboard) {
                alert("Copying to clipboard is not supported by your browser.");
                return;
            }

            // Get the text content of the clicked element
            const text = element.textContent;

            // Write the text to the clipboard
            navigator.clipboard.writeText(text)
                .then(() => {
                    alert("Text copied to clipboard!");
                })
                .catch(err => {
                    alert("Failed to copy text: " + err);
                });
        }

        const textElement = document.querySelector(".password");
        textElement.addEventListener("click", () => copyText(textElement));

        // Copy username
        function copyText(element) {
            // Check if the Clipboard API is supported
            if (!navigator.clipboard) {
                alert("Copying to clipboard is not supported by your browser.");
                return;
            }

            // Get the text content of the clicked element
            const text = element.textContent;

            // Write the text to the clipboard
            navigator.clipboard.writeText(text)
                .then(() => {
                    alert("Text copied to clipboard!");
                })
                .catch(err => {
                    alert("Failed to copy text: " + err);
                });
        }

        const userElement = document.querySelector(".username");
        userElement.addEventListener("click", () => copyText(userElement));
    </script>
</body>

</html>