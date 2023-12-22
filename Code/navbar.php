<head>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><a href="index.php"><img src="home.png" height="45px"
                                                                                    width="45px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto"></ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Menu
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile_editor.php">Upravit profil</a>
                    <a class="dropdown-item" href="createticket.php">HelpDesk</a>
                    <?php if (isset($_SESSION['user_id']) && isset($user_role)) : ?>
                    <?php if ($user_role == 3) : ?>
                    <a class="dropdown-item" href="add_article.php">Přidat nový příspěvek</a>
                    <?php elseif ($user_role == 4) : ?>
                    <a class="dropdown-item" href="list_articles.php">Stav příspěvků</a>
                    <a class="dropdown-item" href="#">Správa témat</a>
                    <?php elseif ($user_role == 5) : ?>
                    <a class="dropdown-item" href="list_articles.php">Stav příspěvků</a>
                    <a class="dropdown-item" href="#">Správa recenzí</a>
                    <?php elseif ($user_role == 6) : ?>
                    <a class="dropdown-item" href="database_administration.php">Správa databáze</a>
                    <a class="dropdown-item" href="#">Správa serveru</a>
                    <a class="dropdown-item" href="#">Správa webu</a>
                    <a class="dropdown-item" href="list_articles.php">Správa článků</a>
                    <a class="dropdown-item" href="mainticketpage.php">Správa ticketů</a>
                    <a class="dropdown-item" href="edit_roles.php">Správa rolí</a>
                    <?php endif; ?>
                    <?php else : ?>
                    <a class="dropdown-item" href="login.php">Přihlásit</a>
                    <?php endif; ?>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="login.php">Odhlásit</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
