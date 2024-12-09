<?php

$action = isset($_GET["action"]) ? $_GET["action"] : null;

//Check if query and Post data are valid
if(!$action || isset($_POST)){
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
        header("location: ". $_SERVER["HTTP_REFERER"]);
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
        header("location: ". $_SERVER["HTTP_REFERER"]);
        exit();
    }
    
    //Check if username and email are valid
    if(!$username && !$email){
        $_SESSION["statusMsg"] = [
            "status" => "error",
            "msg" => "You must provide a valid Username & email!"
        ];
        header("location: ". $_SERVER["HTTP_REFERER"]);
        exit();
    }

    //Check if username already taken

    
    
    //Insert the user in the database & Initialize session

} else if($action === "login"){


} else {
    header("location: ../index.php");
    exit;
}



