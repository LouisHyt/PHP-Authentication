<nav id="navbar">
    <a class="logo" href="./index.php">Auth website</a>
    <div class="actions">
        <?php if(isset($_SESSION["user"])) : ?>
            <a href="./dashboard.php">dashboard</a>
            <a href="./auth/handleAuth.php?action=logout">Logout</a>
        <?php else : ?>
            <a href="./login.php">Login</a>
            <a href="./register.php">Register</a>
        <?php endif ?>
    </div>
</nav>