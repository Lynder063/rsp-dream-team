<?php
 include 'db.php';

$successMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketText = $_POST['ticketText']; // Make sure this matches your form field

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tiket (text_tiket) VALUES (?)"); // Adjust this to match your table structure
    $stmt->bind_param("s", $ticketText);

    // Execute and check for errors
    if ($stmt->execute()) {
        $successMessage = "Ticket byl úspěšně vytvořen.";
    } else {
        $errorMessage = "Chyba při přidávání ticketu: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">

    <style>
        body {
            background-color: #202124;
            color: #ffffff;
        }

        .navbar {
            background-color: #343a40 !important;
        }

        .card {
            background-color: #2c2c2c;
            color: #ffffff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-control {
            background-color: #383838;
            color: #ffffff;
            border: 1px solid #6c757d;
        }
    </style>

    <title>HelpDesk</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Add your existing navigation links here -->
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Ticket</h5>
            </div>
            <div class="card-body">
                <?php
                if (!empty($successMessage)) {
                    echo '<div class="alert alert-success">' . $successMessage . '</div>';
                } elseif (!empty($errorMessage)) {
                    echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
                }
                ?>
                <form id="ticketform "method="POST" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="articleText">Popis problému: </label>
                        <textarea class="form-control" name="ticketText" id="ticketText" rows="10" minlength="10" maxlength="5000" placeholder="Text ticketu" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Odeslat</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>