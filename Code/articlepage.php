<?php

$servername = "lynder.xyz";
$username = "dreamteam";
$password = "Password1*";
$dbname = "kolcak";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from URL
$sql = isset($_GET['id_clanku']) ? intval($_GET['id_clanku']) : 0;

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
    <a class="navbar-brand" href="index.php"><img class="headerrrrr" src="home.png" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Add your existing navigation links here -->
    </div>
</nav>

<div class="container mt-4">
    <div class="card">
    <?php if ($clanekFound): ?>
            <div class="card-header">
             <h2 class="card-title"><strong><?= htmlspecialchars($clanek['nazev_clanku']) ?></strong></h2>
            <h5 for="abstract"><?= htmlspecialchars($clanek['abstrakt_clanku']) ?></h5>
            <p for="title"><?= htmlspecialchars($clanek['autor_clanku']) ?></p>
            </div>
            <div class="card-body">
                <img class="article-img"src="<?= htmlspecialchars($clanek['img_url']) ?>" alt="">
                <form action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="articleText"><?= htmlspecialchars($clanek['text_clanku']) ?></label>
                        
                    
                
                    </div>
                    
                  
                </form>
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