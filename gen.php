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
    <link rel="stylesheet" href="css/themes/light/mobile/gen.css">
    <!-- Tablet -->
    <!-- Desktop -->
    <title>Pamager</title>
</head>

<body>
    <!-- Save password box -->
    <div class="container mb-main-box">
        <p class="heading">Generate Password</p>
        <div class="form">
            <div class="password"></div>
            <input type="submit" class="submit" value="Generate" name="submit" onclick="generateStrongPassword();">
        </div>
        <a href="index.php" class="back">Back</a>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>
        // Generate strong password
        function generateStrongPassword() {
            const characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*-";
            let password = "";
            let length =10;

            // Ensure at least one of each character type
            let hasUppercase = false;
            let hasLowercase = false;
            let hasNumber = false;
            let hasSpecial = false;

            // Generate random characters until all types are present and length is met
            while (password.length < length || !hasUppercase || !hasLowercase || !hasNumber || !hasSpecial) {
                const character = characters.charAt(Math.floor(Math.random() * characters.length));

                password += character;

                hasUppercase = hasUppercase || character.toUpperCase() === character;
                hasLowercase = hasLowercase || character.toLowerCase() === character;
                hasNumber = hasNumber || !isNaN(character);
                hasSpecial = hasSpecial || /[!@#$%^&*-]+/.test(character);

                if(password.length >= 10){
                    break;
                }
            }

            document.querySelector(".password").innerHTML = password;
        }

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

    </script>
</body>

</html>