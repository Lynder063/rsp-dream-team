<?php
// checking if the user is logged in
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Uložení role uživatele ze session do proměnné user_role
$user_role = isset($_SESSION['role_uzivatele']) ? $_SESSION['role_uzivatele'] : null;

// Fetch data from the Clanek table
$sql = "SELECT nazev_clanku, img_url, id_clanku FROM Clanek";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Časopis VŠPJ</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(to left, #4d4d4d 0%, #333333 15%, #333333 85%, #4d4d4d 100%);
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            background-color: lightgrey;
            width: 60%;
            margin: 10px auto;
            padding: 20px;
            border-radius: 10px;

        }

        .img_clanek {
            height: 200px;
            width: auto;
        }

    </style>
    <link rel="icon" href="logo.png" type="image/x-icon">
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container">
    <?php
    $count = 0; // Přesun inicializace proměnné $count sem

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($count % 3 == 0) {
                if ($count > 0) {
                    echo '</div>';
                }
                echo '<div class="row">';
            }

            $nazevClanku = $row['nazev_clanku'];
            $imgUrl = $row['img_url'];

            // Output the HTML for each record
            echo '<div class="col-md-4 mb-4">';
            echo '<a href="articlepage.php?id_clanku=' . $row['id_clanku'] . '">';
            echo '<img class="rounded img_clanek" src="' . $imgUrl . '">';
            echo '</a>';
            echo '<div class="text-center">';
            echo '<a href="articlepage.php?id_clanku=' . $row['id_clanku'] . '" class="nadpis_clanek">' . $nazevClanku . '</a>';
            echo '</div>';
            echo '</div>';

            $count++;
        }

        echo '</div>';
    } else {
        echo '<p>No articles found.</p>';
    }
    ?>
</div>
</body>

</html>