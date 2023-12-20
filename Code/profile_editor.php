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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Editor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .main-content-box {
            width: 400px;
            text-align: center;
            margin: auto;
        }

        .btn-group {
            margin-top: 20px;
        }

        .form-group {
            display: none;
        }

        .form-group.active {
            display: block;
        }

        .username-display {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>
<a href="index.php"><img src="home.png" alt=""></a>
<div class="main-content-box">

    <div class="username-display">
        <?php
        // Display the username of the logged-in user
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $query = "SELECT uzivatelske_jmeno FROM Uzivatel WHERE id_uzivatele='$userId'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo $row['uzivatelske_jmeno'];
            }
        }

        $conn->close();
        ?>
    </div>

    <div class="btn-group">
        <button class="btn btn-primary show-form" data-target="changeUsername">Uživatelské jméno</button>
        <button class="btn btn-primary show-form" data-target="changeEmail">Email</button>
        <button class="btn btn-primary show-form" data-target="changePassword">Heslo</button>
    </div>

    <div id="changeUsername" class="form-group">
        <br>
        <h3>Uživatelské jméno</h3>
        <form method="post">
            <label for="oldUsername">Staré uživatelské jméno:</label>
            <input type="text" name="oldUsername" class="form-control" required>
            <label for="newUsername">Nové uživatelské jméno:</label>
            <input type="text" name="newUsername" class="form-control" required>
            <br>
            <button type="submit" name="changeUsernameBtn" class="btn btn-primary">Změnit</button>
        </form>
    </div>

    <div id="changeEmail" class="form-group">
        <br>
        <h3>Email</h3>
        <form method="post">
            <label for="oldEmail">Starý email:</label>
            <input type="email" name="oldEmail" class="form-control" required>
            <label for="newEmail">Nový email:</label>
            <input type="email" name="newEmail" class="form-control" required>
            <br>
            <button type="submit" name="changeEmailBtn" class="btn btn-primary">Změnit</button>
        </form>
    </div>

    <div id="changePassword" class="form-group">
        <br>
        <h3>Heslo</h3>
        <form method="post">
            <label for="oldPassword">Staré heslo:</label>
            <input type="password" name="oldPassword" class="form-control" required>
            <label for="newPassword">Nové heslo:</label>
            <input type="password" name="newPassword" class="form-control" required>
            <label for="newPasswordAgain">Nové heslo znovu:</label>
            <input type="password" name="newPasswordAgain" class="form-control" required>
            <br>
            <button type="submit" name="changePasswordBtn" class="btn btn-primary">Změnit</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.show-form');
        const formGroups = document.querySelectorAll('.form-group');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.dataset.target;
                formGroups.forEach(group => group.classList.remove('active'));
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>
</body>

</html>
