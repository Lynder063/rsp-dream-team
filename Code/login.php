<?php
session_start(); // Start the session
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
        ;
        padding: 50px;
        width: 250px;
        height: 250px;
        text-align: center;
        font-family: "Farfetch Basis", "Helvetica Neue", Arial, sans-serif;
        font-size: 20px;
        color: silver;
        font-weight: bold;
        border-radius: 10px;

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
        color: silver;
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
        right: 20px;
        transition: 1s;
    }

    img:hover {
        transform: scale(1.5);
    }
</style>

<body>
    <a href="MainPage.php"><img src="home.png" alt=""></a>
    <h1 class="login">Přihlášení</h1>
    <div class="form">
        <form method="post">

            <label for="username">Uživatelské jméno</label>
            <input type="text" id="username" name="username" required><br><br>

            <label for="password">Heslo</label>
            <input type="password" id="password" name="password" required><br><br>
            <br>
            <input type="submit" value="Přihlásit" class="button">
        </form>
    </div>
</body>

</html>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('db.php');

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
            // Authentication successful, redirect to MainPage.php
            header("Location: MainPage.php");
            exit;
        }
    }

    // TODO FRONTEND: přidat lepší zdělení špatného zadání informací
    echo "Špatné uživatelské jméno nebo heslo";
}
