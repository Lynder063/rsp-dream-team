<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Menu
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile_editor.php">Upravit profil</a>

                    <?php if (isset($_SESSION['user_id']) && isset($user_role)) : ?>
                        <?php if ($user_role == 3) : ?>
                            <a class="dropdown-item" href="add_article.php">Přidat nový příspěvěk</a>
                        <?php elseif ($user_role == 4) : ?>
                            <a class="dropdown-item" href="list_articles.php">Stav příspěvků</a>
                            <a class="dropdown-item" href="#">Správa témat</a>
                        <?php elseif ($user_role == 5) : ?>
                            <a class="dropdown-item" href="list_articles.php">Stav příspěvků</a>
                            <a class="dropdown-item" href="#">Správa recenzí</a>
                        <?php elseif ($user_role == 6) : ?>
                            <a class="dropdown-item" href="#">Správa databáze</a>
                            <a class="dropdown-item" href="#">Správa serveru</a>
                            <a class="dropdown-item" href="#">Správa webu</a>
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