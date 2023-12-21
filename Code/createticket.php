<?php

session_start();

require_once('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$successMessage = '';
$errorMessage = '';

$user_role = isset($_SESSION['role_uzivatele']) ? $_SESSION['role_uzivatele'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ticketText = $_POST['ticketText'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO tiket (text_tiket) VALUES (?)");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">

    <style>
        h5{
            color: #343a40;
        }

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

        .card {
            background-color: #424242;
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

        .alert {
            color: #000000; /* Dark text for alerts */
        }
    </style>

    <title>HelpDesk</title>
</head>

<body>
<?php include 'navbar.php'; ?>

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
            <form id="ticketform" method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="ticketText">Popis problému:</label>
                    <textarea class="form-control" name="ticketText" id="ticketText" rows="10" minlength="10" maxlength="5000" placeholder="Text ticketu" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Odeslat</button>
            </form>
        </div>
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
