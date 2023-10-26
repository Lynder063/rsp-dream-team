<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Přihlášení</title>
</head>

<style>
    body {
        background: linear-gradient(to left, #4d4d4d 0%, #333333 35%, #333333 65%,  #4d4d4d 100%);

    }
    form{
        background-color: rgb(255, 255, 255, 0.1); ;
        padding:50px;
        width:250px;
        height:250px;
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
    .login{
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
<h1 class="login">Přihlášení</h1>
<div class="form">
    <form action="proces.php" method="post" class="xd">

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
?>