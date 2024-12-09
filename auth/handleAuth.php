<?php

require "../utils/connect.php";

$action = isset($_GET["action"]) ? $_GET["action"] : null;

//Check if query and Post data are valid
if(!$action || !isset($_POST)){
    header("location: ../index.php");
    exit;
}


session_start();

if($action === "register"){

    //Check if passwords match
    if($_POST["password"] !== $_POST["password_confirm"]){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "Passwords does not match!"
        ];
        header("location: ../register.php");
        exit();
    }
    
    // Data validation
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, "password", FILTER_VALIDATE_REGEXP, [
        "options"=> [
            "regexp" => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-_]).{12,14}$/"
        ]
    ]);
    
    //Check if password is valid
    if(!$password){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "Passwords must be between 12 and 14 characters with at least 1 uppercase, 1 lowercase, 1 digit and 1 special character!"
        ];
        header("location: ../register.php");
        exit();
    }
    
    //Check if username and email are valid
    if(!$username && !$email){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "You must provide a valid Username & email!"
        ];
        header("location: ../register.php");
        exit();
    }

    //Check if username or email already taken
    $pdo = Connect::seConnecter();
    $request = $pdo->prepare("
        SELECT id
        FROM user
        WHERE username=:username OR email=:email
    ");
    $request->bindValue(":username", $username, \PDO::PARAM_STR);
    $request->bindValue(":email", $email, \PDO::PARAM_STR);
    $request->execute();
    $user = $request->fetch(\PDO::FETCH_ASSOC);

    if($user){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "Email or Username already taken"
        ];
        header("location: ../register.php");
        exit();
    }

    //Insert the user in the database & Initialize session
    try{
        $hashpassword = password_hash($password, PASSWORD_ARGON2ID);
        $request = $pdo->prepare("
            INSERT INTO user (username, email, password)
            VALUES (:username, :email, :password)
        ");
        $request->bindValue(":username", $username, \PDO::PARAM_STR);
        $request->bindValue(":email", $email, \PDO::PARAM_STR);
        $request->bindValue(":password", $hashpassword, \PDO::PARAM_STR);
        $request->execute();
    } catch(\PDOException $error){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "Sorry...An internal Error occured."
        ];
        header("location: ../register.php");
        exit();
    }

    $_SESSION["user"] = [
        "username" => $username,
        "email" => $email
    ];
    header("location: ../index.php");

} else if($action === "login"){

    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username || !$password){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "Please provide a Username and a password!"
        ];
        header("location: ../login.php");
        exit();
    }

    $pdo = Connect::seConnecter();
    $request = $pdo->prepare("
        SELECT password, username, email
        FROM user
        WHERE username=:username
    ");
    $request->bindValue(":username", $username, \PDO::PARAM_STR);
    $request->execute();
    $user = $request->fetch(\PDO::FETCH_ASSOC);

    if(!$user){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "The username or the password is wrong!"
        ];
        header("location: ../login.php");
        exit();
    }

    $iscorrectpassword = password_verify($password, $user["password"]);
    if(!$iscorrectpassword){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "The username or the password is wrong!"
        ];
        header("location: ../login.php");
        exit();
    }

    $_SESSION["user"] = [
        "username" => $user["username"],
        "email" => $user["email"]
    ];
    header("location: ../index.php");


} else if($action === "logout"){

    if(isset($_SESSION["user"])){
        unset($_SESSION["user"]);
    }

    header("location: ../index.php");

} else {
    header("location: ../index.php");
    exit;
}



