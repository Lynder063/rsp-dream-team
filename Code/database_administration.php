<?php
session_start();
require_once('db.php');

$user_role = isset($_SESSION['role_uzivatele']) ? $_SESSION['role_uzivatele'] : null;

// Check if the user is logged in and has admin role
if (!isset($_SESSION['user_id']) || $user_role == 6) {
    // If not, redirect to login or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Function to fetch all tables from the database
function getTables($conn) {
    $tables = array();
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
    return $tables;
}

// Fetch all tables
$tables = getTables($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Administration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
        .main-content-box {
            width: 400px;
            text-align: center;
            margin: auto;
        }

        .btn-group {
            margin-top: 20px;
        }

        .table-list {
            text-align: left;
            margin-top: 20px;
        }

        .pozadi {
            flex: 1;
            background-color: lightgrey;
            width: 60%;
            margin: 10px auto;
            padding: 20px;
            border-radius: 10px;
            color: black;
        }

        .entry-list {
            display: none;
        }

        .entry-list.active {
            display: block;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="pozadi">
    <div class="main-content-box">
        <h2>Database Administration</h2>

        <div class="table-list">
            <h3>Available Tables:</h3>
            <div class="btn-group">
                <?php foreach ($tables as $table): ?>
                    <button class="btn btn-primary show-entries" data-target="<?php echo $table; ?>"><?php echo $table; ?></button>
                <?php endforeach; ?>
            </div>
        </div>

        <?php foreach ($tables as $table): ?>
            <div id="<?php echo $table; ?>" class="entry-list">
                <h3>Entries for <?php echo $table; ?>:</h3>
                <?php
                // Fetch entries for each table
                $entries = array();
                $result = $conn->query("SELECT * FROM $table");
                while ($row = $result->fetch_assoc()) {
                    $entries[] = $row;
                }
                ?>
                <ul>
                    <?php foreach ($entries as $entry): ?>
                        <li><?php echo json_encode($entry); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const showEntriesButtons = document.querySelectorAll('.show-entries');
        const entryLists = document.querySelectorAll('.entry-list');

        showEntriesButtons.forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.dataset.target;
                entryLists.forEach(list => list.classList.remove('active'));
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>
</body>

</html>
