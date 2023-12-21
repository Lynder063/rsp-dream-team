<?php

require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get user ID from URL
$sql = isset($_GET['id_clanku']) ? intval($_GET['id_clanku']) : 0;

$user_role = isset($_SESSION['role_uzivatele']) ? $_SESSION['role_uzivatele'] : null;

// Prepare and execute SQL statement
$stmt = $conn->prepare("SELECT * FROM Clanek WHERE id_clanku = ?");
$stmt->bind_param("i", $sql);
$stmt->execute();
$result = $stmt->get_result();

$clanekFound = $result->num_rows > 0;
$clanek = $clanekFound ? $result->fetch_assoc() : null;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: #202124;
            color: black; /* Changed color to black */
        }

        .navbar-brand img {
            width: 40px;
            height: auto;
        }

        .container {
            margin-top: 20px;
        }

        .card {
            background-color: #424242;
            color: black; /* Changed color to black */
        }

        .card-header {
            background-color: #343a40;
            color: black; /* Changed color to black */
        }

        .article-img {
            max-width: 100%;
            height: auto;
        }

        .form-group label {
            color: black; /* Changed color to black */
        }

        .form-group p {
            color: #6c757d;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <div class="card">
        <?php if ($clanekFound): ?>
            <div class="card-header">
                <h2 class="card-title"><strong><?= htmlspecialchars($clanek['nazev_clanku']) ?></strong></h2>
                <h5><?= htmlspecialchars($clanek['abstrakt_clanku']) ?></h5>
            </div>
            <div class="card-body">
                <img class="article-img" src="<?= htmlspecialchars($clanek['img_url']) ?>" alt="">
                <form action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="articleText"><?= htmlspecialchars($clanek['text_clanku']) ?></label>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="card-body">
                <p>Článek nenalezen.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>
