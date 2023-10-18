<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Registarce</title>
</head>

<style>
    body {
        background: linear-gradient(to left, #4d4d4d 0%, #333333 35%, #333333 65%,  #4d4d4d 100%);

    }
    form{
        background-color: rgb(255, 255, 255, 0.1); ;
        padding:50px;
        width:250px;
        height:420px;
        text-align: center;
        font-family: "Farfetch Basis","Helvetica Neue",Arial,sans-serif;
        font-size:20px;
        color:silver;
        font-weight:bold;
        border-radius:10px;

    }
    form label {
        display: block;
        margin: 10px 0;
    }
    input:hover{
        background-color:grey;
    }
    input:focus{
        background-color:grey;
    }
    .Reg{

        text-align: center;
        font-family: "Farfetch Basis","Helvetica Neue",Arial,sans-serif;
        font-size:40px;
        color:silver;
        font-weight:bold;

    }

    .button{
        background-color: #222;
        border-radius: 6px;
        border-style: none;
        box-sizing: border-box;
        color:silver;
        cursor: pointer;
        display: inline-block;
        font-family: "Farfetch Basis","Helvetica Neue",Arial,sans-serif;
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

    .button:hover,.button:focus {
        opacity: .75;
    }

    .form{
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
        margin: 0;
    }
</style>

<body>


<h1 class="Reg">Registrace</h1>

<div class="form">
    <form action="proces.php" method="post" class="xd">
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

        <label for="confirm_password">Potvrďte heslo</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <br><br>
        <input type="submit" value="Registrovat" class="button">
    </form>
</div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "your_database_name";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, firstname, lastname, email, password) VALUES ('$username', '$firstname', '$lastname', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>