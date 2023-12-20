<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('db.php');

session_start(); // Start the session

$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $helpRequest = $_POST['title'];
    $problemDescription = $_POST['problemText'];

    // Check if the "file" field is set and not empty
    if (isset($_FILES['file']) && $_FILES['file']['error'] !== UPLOAD_ERR_NO_FILE) {
        // Handle file upload
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the image file is a valid image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check === false) {
            $errorMessage = "File is not a valid image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            $errorMessage = "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["file"]["size"] > 500000) {
            $errorMessage = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow only specific file formats
        $allowedFormats = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowedFormats)) {
            $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $errorMessage = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                // Use prepared statement to insert data into the database
                $stmt = $conn->prepare("INSERT INTO Helpdesk (s_cim_potrebuji_pomoct, popis_problemu, img_url, datum_zadosti) 
                                        VALUES (?, ?, ?, CURRENT_TIMESTAMP)");

                $stmt->bind_param("sss", $helpRequest, $problemDescription, $targetFile);

                if ($stmt->execute()) {
                    $successMessage = "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
                    $successMessage .= " Požadavek byl úspěšně přidán.";
                } else {
                    $errorMessage = "Chyba při přidávání požadavku: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $errorMessage = "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        $errorMessage = "Please select a file to upload.";
    }
}
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

    <title>Helpdesk</title>
</head>

<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Helpdesk</h5>
        </div>
        <div class="card-body">
            <?php
            if (!empty($successMessage)) {
                echo '<div class="alert alert-success">' . $successMessage . '</div>';
            } elseif (!empty($errorMessage)) {
                echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
            }
            ?>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">S čím potřebujete pomoct ?</label>
                    <textarea class="form-control" name="title" id="title" rows="3" minlength="1" maxlength="60"
                              placeholder="S čím potřebujete pomoct?"></textarea>
                </div>
                <div class="form-group">
                    <label for="problemText">Popis problému</label>
                    <textarea class="form-control" name="problemText" id="problemText" rows="10" minlength="1"
                              maxlength="5000" placeholder="Popis problému"></textarea>
                </div>
                <div class="form-group">
                    <label for="file">Obrázek</label>
                    <input type="file" class="form-control-file" name="file" id="file">
                </div>
                <div class="form-group">
                    <label for="category">Kategorie</label>
                    <select class="form-control" name="category" id="category">

                    </select>
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
