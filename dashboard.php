<?php
    session_start();
    if(!isset($_SESSION["user"])){
        header("location: ./index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Dashboard</title>
</head>
<body>
    <?php include "./navbar.php" ?>
    <main id="content">
        <h1>Welcome on your dashboard: <?= $_SESSION["user"]["username"] ?></h1>
        <p>email :  <?= $_SESSION["user"]["email"] ?></p>
    </main>
</body>
</html>