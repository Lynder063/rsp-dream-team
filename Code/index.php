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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <style>
        .img_clanek {
            height: 200px;
            width: auto;
        }

        .navbar-brand {
            width: 10%;
        }
    </style>
    <link rel="icon" href="logo.png" type="image/x-icon">
</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            $count = 0;

            // Output rows in groups of 3
            while ($row = $result->fetch_assoc()) {
                if ($count % 3 == 0) {
                    // Close previous row if not the first row
                    if ($count > 0) {
                        echo '</div>';
                    }

                    // Open a new row for every 3 records
                    echo '<div class="row">';
                }

                $nazevClanku = $row['nazev_clanku'];
                $imgUrl = $row['img_url'];

                // Output the HTML for each record
                echo '<div class="col-md-4 mb-4">';
                echo '<a href="articlepage.php?id_clanku=' . $row['id_clanku'] . '"><img class="rounded img_clanek" src="' . $imgUrl . '"></a>';
                echo '<div class="text-center">';
                echo '<a href="articlepage.php?id_clanku=' . $row['id_clanku'] . '" class="nadpis_clanek">' . $nazevClanku . '</a>';
                echo '</div>';
                echo '</div>';

                $count++;
            }

            // Close the last row
            echo '</div>';
        } else {
            // Handle case when no rows are found
            echo '<p>No articles found.</p>';
        }
        ?>
    </div>
</body>

</html>