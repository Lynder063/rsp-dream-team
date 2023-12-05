<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Articles</title>
    <!-- Include Bootstrap CSS and Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Seznam článků</h2>

        <?php
        // Include the database connection file
        include 'db.php';

        // Fetch all articles
        $result = $conn->query("SELECT * FROM Clanek");

        // Check if there are articles
        if ($result->num_rows > 0) {
            echo '<table class="table table-striped">';
            echo '<thead class="thead-dark"><tr><th>ID</th><th>Nazev Clanek</th><th>Actions</th></tr></thead>';
            echo '<tbody>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['id_clanku'] . '</td>';
                echo '<td>' . $row['nazev_clanku'] . '</td>';
                echo '<td><a class="btn btn-info" href="edit_article.php?id_clanku=' . $row['id_clanku'] . '"><i class="bi bi-pencil"></i> Edit</a></td>';
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert alert-info">No articles found.</div>';
        }

        // Close the database connection
        $conn->close();
        ?>

    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>