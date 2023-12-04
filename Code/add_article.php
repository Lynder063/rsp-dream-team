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

    <title>Article editor</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index_admin.php">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Umělá inteligence</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Hardware</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Software</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Periférie</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profile_editor.php">Správa článek</a>
                        <a class="dropdown-item" href="profile_editor.php">Správa uživatelů</a>
                        <a class="dropdown-item" href="profile_editor.php">Správa komentářů</a>
                        <a class="dropdown-item" href="profile_editor.php"></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.php">Odhlásit</a>
                    </div>
                </li>
            </ul>
        </div>
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>