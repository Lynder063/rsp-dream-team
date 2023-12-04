<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom styles here -->

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

    <title>Article editor</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="MainPage.php">
            <img src="home.png" alt="" width="30" height="30" class="d-inline-block align-top">
            [LOGO]
        </a>
    </nav>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Přidání článku</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="title">Nadpis</label>
                        <textarea class="form-control" id="title" rows="3" minlength="1" maxlength="60"
                            placeholder="Nadpis"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="abstract">Abstrakt</label>
                        <textarea class="form-control" id="abstract" rows="5" minlength="1" maxlength="150"
                            placeholder="Abstrakt"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="articleText">Text článku</label>
                        <textarea class="form-control" id="articleText" rows="10" minlength="1" maxlength="5000"
                            placeholder="Text článku"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Odeslat</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>