<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('db.php');

session_start(); // Start the session

$error_message = "";

$user_role = 1;
$_SESSION['role_uzivatele'] = $user_role;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database based on the entered username
    $sql = "SELECT * FROM Uzivatel WHERE uzivatelske_jmeno = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['heslo'];
        $stored_salt = $row['salt'];

        // Combine the entered password with the stored salt and hash it
        $hashed_password = hash('sha256', $password . $stored_salt);

        // Check if the hashed password matches the stored hashed password
        if ($hashed_password === $stored_password) {
            $_SESSION['user_id'] = $row['id_uzivatele'];
            $_SESSION['role_uzivatele'] = $row['role_uzivatele']; // Přidání role do session

            // Přesměrování na index.php bez ohledu na roli
            header("Location: index.php");
            exit;
        }
    }

    $error_message = "Špatné uživatelské jméno nebo heslo";
}
?>


<!DOCTYPE html>
<html lang="cs">

<head>
    <title>Přihlášení</title>
</head>

<style>
    body {
        background: linear-gradient(to left, #4d4d4d 0%, #333333 35%, #333333 65%, #4d4d4d 100%);

    }

    form {
        background-color: rgb(255, 255, 255, 0.1);
        padding: 50px;
        padding-top: 20px;
        width: 250px;
        height: 470px;
        text-align: center;
        font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
        font-size: 20px;
        color: silver;
        font-weight: bold;
        border-radius: 10px;
        margin-top: 150px;

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

    .login {
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
        margin-top: 13px ;
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

    .error-message {
        color: #ff3333;
        font-weight: bold;
    }
</style>

<body>
<a href="index.php"><img src="home.png" alt=""></a>

<div class="form">
    <form method="post">
        <h1 class="login">Přihlášení</h1>
        <br>
        <label for="username">Uživatelské jméno</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Heslo</label>
        <input type="password" id="password" name="password" required><br><br>
        <br>
        <input type="submit" value="Přihlásit" class="button">
        <a href="register.php"> <label class="button seconary">Registrace</label></a>
        <p class="error-message"><?php echo $error_message; ?></p>
        <br>
    </form>
</div>
</body>

</html>