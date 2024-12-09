<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <title>Register</title>
</head>
<body>
    <?php include "./navbar.php" ?>
    <main id="content">
        <div class="form-container">
            <?php if(isset($_SESSION["statusMsg"])) : ?> 
                <p class="status-msg <?= $_SESSION["statusMsg"]["status"] ?>"> <?= $_SESSION["statusMsg"]["msg"] ?> </p>
            <?php endif ?>
            <div class="inner-form">
                <h1>Register</h1>
                <form action="./auth/handleForm.php?action=register" method="POST">
                    <div class="form-item">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="form-item">
                        <label for="email">Mail</label>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-item">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="form-item">
                        <label for="password_confirm">Confirm password</label>
                        <input type="password" name="password_confirm" id="password_confirm" required>
                    </div>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>