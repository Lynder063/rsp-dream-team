<?php

include 'db.php';
// Get user ID from URL
$sql = isset($_GET['id_tiket']) ? intval($_GET['id_tiket']) : 0;

// Prepare and execute SQL statement
$stmt = $conn->prepare("SELECT * FROM tiket WHERE id_tiket = ?");
$stmt->bind_param("i", $sql);
$stmt->execute();
$result = $stmt->get_result();

$tiketFound = $result->num_rows > 0;
$tiket = $tiketFound ? $result->fetch_assoc() : null;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelpDesk</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #202124;
            color: black;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="mainticketpage.php"><img class="headerrrrr" src="home.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Add your existing navigation links here -->
    </div>
</nav>

<div class="container mt-4">
    <div class="card">
    <?php if ($tiketFound): ?>
            <div class="card-header">
             <h2 class="card-title"><strong>Číslo ticketu: <?= htmlspecialchars($tiket['id_tiket']) ?></strong></h2>
             <h4>Popis problému: </h4>
            <p for="title"><?= htmlspecialchars($tiket['text_tiket']) ?></p>
            </div>
            <?php else: ?>
            <div class="card-body">
                <p>User not found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>