<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <!-- Include Bootstrap CSS and Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Edit Article</h2>

        <?php
        // Include the database connection file
        include 'db.php';

        // Check if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve data from form
            $id_clanku = $_POST["id_clanku"];
            $nazev_clanku = mysqli_real_escape_string($conn, $_POST["nazev_clanku"]);
            $autor_clanku = mysqli_real_escape_string($conn, $_POST["autor_clanku"]);
            $abstrakt_clanku = mysqli_real_escape_string($conn, $_POST["abstrakt_clanku"]);
            $text_clanku = mysqli_real_escape_string($conn, $_POST["text_clanku"]);
            $klicova_slova = mysqli_real_escape_string($conn, $_POST["klicova_slova"]);
            $img_url = mysqli_real_escape_string($conn, $_POST["img_url"]);

            // Update the record in the database
            $sql = "UPDATE Clanek SET
                nazev_clanku = '$nazev_clanku',
                autor_clanku = '$autor_clanku',
                abstrakt_clanku = '$abstrakt_clanku',
                text_clanku = '$text_clanku',
                klicova_slova = '$klicova_slova',
                img_url = '$img_url'
                WHERE id_clanku = $id_clanku";

            if ($conn->query($sql) === TRUE) {
                echo '<div class="alert alert-success">Record updated successfully</div>';
            } else {
                echo '<div class="alert alert-danger">Error updating record: ' . $conn->error . '</div>';
            }
        }

        // Fetch the existing record for editing
        $id_clanku_to_edit = $_GET["id_clanku"];
        $result = $conn->query("SELECT * FROM Clanek WHERE id_clanku = $id_clanku_to_edit");
        $row = $result->fetch_assoc();
        ?>

        <form method="post" action="">
            <input type="hidden" name="id_clanku" value="<?php echo $row['id_clanku']; ?>">
            <div class="form-group">
                <label for="nazev_clanku">Nazev Clanek:</label>
                <input type="text" class="form-control" id="nazev_clanku" name="nazev_clanku"
                    value="<?php echo $row['nazev_clanku']; ?>" required>
            </div>
            <div class="form-group">
                <label for="autor_clanku">Autor Clanek:</label>
                <input type="text" class="form-control" id="autor_clanku" name="autor_clanku"
                    value="<?php echo $row['autor_clanku']; ?>" required>
            </div>
            <div class="form-group">
                <label for="abstrakt_clanku">Abstrakt Clanek:</label>
                <textarea class="form-control" id="abstrakt_clanku" name="abstrakt_clanku" rows="3"
                    required><?php echo $row['abstrakt_clanku']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="text_clanku">Text Clanek:</label>
                <textarea class="form-control" id="text_clanku" name="text_clanku" rows="6"
                    required><?php echo $row['text_clanku']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="klicova_slova">Klicova Slova:</label>
                <input type="text" class="form-control" id="klicova_slova" name="klicova_slova"
                    value="<?php echo $row['klicova_slova']; ?>" required>
            </div>
            <div class="form-group">
                <label for="img_url">Image URL:</label>
                <input type="text" class="form-control" id="img_url" name="img_url"
                    value="<?php echo $row['img_url']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="list_articles.php" class="btn btn-secondary">Back to List</a>
        </form>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>