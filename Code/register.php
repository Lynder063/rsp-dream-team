<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('db.php');

// Check the connection (You can remove this block if you prefer not to echo anything on successful connection)
if ($conn->connect_error) {
    echo "Connected NE!1";
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];


    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: register.php?error=1");
        exit;
    }

    $role = 2;
    // Generate a random salt
    $salt = bin2hex(random_bytes(16));

    // Combine the password and salt, and hash it using SHA-256
    $hashed_password = hash('sha256', $password . $salt);

    $sql = "INSERT INTO Uzivatel (uzivatelske_jmeno, jmeno_uzivatele, prijmeni_uzivatele, email_adresa, heslo, salt, role_uzivatele) VALUES ('$username', '$firstname', '$lastname', '$email', '$hashed_password', '$salt', '$role')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <title>Registarce</title>

</head>

<style>
    body {
        background: linear-gradient(to left, #4d4d4d 0%, #333333 35%, #333333 65%, #4d4d4d 100%);

    }

    form {
        background-color: rgb(255, 255, 255, 0.1);
        padding: 50px;
        padding-top: 10px;
        width: 250px;
        height: 600px;
        text-align: center;
        font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
        font-size: 20px;
        color: silver;
        font-weight: bold;
        border-radius: 10px;
        margin-top: 160px;

    }

    form label {
        display: block;
        margin: 10px 0;
    }

    input:hover {
        background-color: grey;
    }

    input:focus {
        background-color: grey;
    }

    .Reg {

        text-align: center;
        font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
        font-size: 40px;
        color: white;
        font-weight: bold;

    }

    .button {
        background-color: #222;
        border-radius: 6px;
        border-style: none;
        box-sizing: border-box;
        color: silver;
        cursor: pointer;
        display: inline-block;
        font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.5;
        margin: 0;
        outline: none;
        overflow: hidden;
        padding: 9px 20px 8px;
        position: relative;
        text-align: center;
        text-transform: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        width: 80%;
    }

    .seconary{
        font-size: 12px;
        width: 50%;
    }

    .button:hover,
    .button:focus {
        opacity: .75;
    }

    .form {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        margin: 0;
    }

    img {
        position: absolute;
        top: 20px;
        left: 20px;
        transition: 1s;
    }

    img:hover {
        transform: scale(1.5);
    }
</style>

<body>

    <a href="index.php"><img src="home.png" alt=""></a>



    <div class="form">

        <form method="post" id="registrationForm">
            <h1 class="Reg">Registrace</h1>
            <label for="username">Uživatelské jméno</label>
            <input type="text" id="username" name="username" required><br>

            <label for="firstname">Jméno</label>
            <input type="text" id="firstname" name="firstname" required><br>

            <label for="lastname">Příjmení</label>
            <input type="text" id="lastname" name="lastname" required><br>

            <label for="email">E-mail</label>
            <input type="text" id="email" name="email" required><br>

            <label for="password">Heslo</label>
            <input type="password" id="password" name="password" required><br>

            <label for="confirm_password">Potvrzení hesla</label>
            <input type="password" id="confirm_password" name="confirm_password" required><br>

            <br><br>
            <input type="submit" value="Registrovat" class="button" name="submit">
            <br><br>
            <a href="login.php"> <label class="button seconary">Přihlásit</label></a>
        </form>
    </div>
</body>

</html>