<?php
session_start();
require_once('db.php');

// Je uživatel přihlášen ?
if (!isset($_SESSION['user_id'])) {
    // Jestli ne jde na login
    header("Location: login.php");
    exit();
}

// Žádný blbý znaky
function sanitize_input($data)
{
    return htmlspecialchars(strip_tags($data));
}

// Změna uživatelskýho jména
if (isset($_POST['changeUsernameBtn'])) {
    $oldUsername = sanitize_input($_POST['oldUsername']);
    $newUsername = sanitize_input($_POST['newUsername']);
    $userId = $_SESSION['user_id'];

    // Starý uživatelský jméno
    $query = "SELECT uzivatelske_jmeno FROM Uzivatel WHERE id_uzivatele='$userId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $oldUsernameFromDB = $row['uzivatelske_jmeno'];

        // Podívej se jestli hodnoty matchují s databází
        if ($oldUsername === $oldUsernameFromDB) {
            // Update
            $sql = "UPDATE Uzivatel SET uzivatelske_jmeno='$newUsername' WHERE id_uzivatele='$userId'";

            if ($conn->query($sql) === TRUE) {
                echo "Uživatelské jméno změněno";
            } else {
                echo "Error při updatu uživatelského jména: " . $conn->error;
            }
        } else {
            echo "Staré uživatelské jméno není správné";
        }
    } else {
        echo "Error při získávání údajů o uživateli: " . $conn->error;
    }
}


// Změna emailu
if (isset($_POST['changeEmailBtn'])) {
    $oldEmail = sanitize_input($_POST['oldEmail']);
    $newEmail = sanitize_input($_POST['newEmail']);
    $userId = $_SESSION['user_id'];

    // Starý email
    $query = "SELECT email_adresa FROM Uzivatel WHERE id_uzivatele='$userId'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $oldEmailFromDB = $row['email_adresa'];

        // Podívej se jestli zadaný email matchuje
        if ($oldEmail === $oldEmailFromDB) {
            // Update
            $sql = "UPDATE Uzivatel SET email_adresa='$newEmail' WHERE id_uzivatele='$userId'";

            if ($conn->query($sql) === TRUE) {
                echo "Email změněn";
            } else {
                echo "Error při updatu emailu: " . $conn->error;
            }
        } else {
            echo "Starý email není správný";
        }
    } else {
        echo "Error při získávání údajů o uživateli: " . $conn->error;
    }
}

// Změna hesla
if (isset($_POST['changePasswordBtn'])) {
    $oldPasswordInput = sanitize_input($_POST['oldPassword']);
    $newPassword = sanitize_input($_POST['newPassword']);
    $newPasswordAgain = sanitize_input($_POST['newPasswordAgain']);
    $userId = $_SESSION['user_id'];

    // Nezadal uživatel stejná hesla ?
    if ($newPassword !== $newPasswordAgain) {
        echo "Nová hesla se neshodují.";
    } else {
        // Staré heslo a salt
        $query = "SELECT heslo, salt FROM Uzivatel WHERE id_uzivatele='$userId'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $oldHashedPassword = hash('sha256', $oldPasswordInput . $row['salt']);

            // Podívej se jestli zadané heslo matchuje
            if ($oldHashedPassword === $row['heslo']) {
                // Nová sůl
                $newSalt = bin2hex(random_bytes(16));
                $newHashedPassword = hash('sha256', $newPassword . $newSalt);

                // Update
                $sql = "UPDATE Uzivatel SET heslo='$newHashedPassword', salt='$newSalt' WHERE id_uzivatele='$userId'";

                if ($conn->query($sql) === TRUE) {
                    echo "Heslo změněno";
                } else {
                    echo "Error při změně hesla: " . $conn->error;
                }
            } else {
                echo "Staré heslo není správné";
            }
        } else {
            echo "Error při získávání údajů o uživateli: " . $conn->error;
        }
    }
}



$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile editor</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <a href="index.php"><img src="home.png" alt=""></a>
    <div class="main-content-box1   ">
        <div class="change-button" id="changeUsernameBtn">
            <h3>Uživatelské jméno</h3>
            <form method="post">
                <label for="oldUsername">Staré uživatelské jméno:</label>
                <input type="text" name="oldUsername" required>
                <label for="newUsername">Nové uživatelské jméno:</label>
                <input type="text" name="newUsername" required>
                <button type="submit" name="changeUsernameBtn">Změnit</button>
            </form>
        </div>
        <div class="change-button">
            <h3>Email</h3>
            <form method="post">
                <label for="oldEmail">Starý email:</label>
                <input type="email" name="oldEmail" required>
                <label for="newEmail">Nový email:</label>
                <input type="email" name="newEmail" required>
                <button type="submit" name="changeEmailBtn">Změnit</button>
            </form>
        </div>
        <div class="change-button" id="changePasswordBtn">
            <h3>Heslo</h3>
            <form method="post">
                <label for="oldPassword">Staré heslo:</label>
                <input type="password" name="oldPassword" required>
                <label for="newPassword">Nové heslo:</label>
                <input type="password" name="newPassword" required>
                <label for="newPasswordAgain">Nové heslo:</label>
                <input type="password" name="newPasswordAgain" required>
                <button type="submit" name="changePasswordBtn">Změnit</button>
            </form>
        </div>
    </div>
</body>

</html>