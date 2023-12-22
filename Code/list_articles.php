<?php

session_start();

require_once('db.php');

$user_role = isset($_SESSION['role_uzivatele']) ? $_SESSION['role_uzivatele'] : null;

// Check if the user is logged in and has an admin role
if (!isset($_SESSION['user_id']) || $user_role < 4) {
    // If not, redirect to login or handle unauthorized access
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Articles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(to left, #4d4d4d 0%, #333333 15%, #333333 85%, #4d4d4d 100%);
            margin: 0;
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
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>List of Articles</h2>

    <?php
    // Include the database connection file
    include 'db.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        // Get the article ID to delete
        $id_clanku_to_delete = $_POST['delete'];

        // Delete the record from the database
        $sql = "DELETE FROM Clanek WHERE id_clanku = $id_clanku_to_delete";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success">Record deleted successfully</div>';
        } else {
            echo '<div class="alert alert-danger">Error deleting record: ' . $conn->error . '</div>';
        }
    }

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
            echo '<td>
                    <a class="btn btn-info" href="edit_article.php?id_clanku=' . $row['id_clanku'] . '"><i class="bi bi-pencil"></i> Edit</a>
                    <button class="btn btn-danger delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="' . $row['id_clanku'] . '"><i class="bi bi-trash"></i> Delete</button>
                  </td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        // Delete Confirmation Modal
        echo '
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure you want to delete this article?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="post" action="">
                      <input type="hidden" id="deleteArticleId" name="delete" value="">
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        ';

    } else {
        echo '<div class="alert alert-info">No articles found.</div>';
    }

    $conn->close();
    ?>

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
