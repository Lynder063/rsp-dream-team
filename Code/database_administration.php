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

        .pozadi{
            flex: 1;
            background-color: lightgrey;
            width: 60%;
            margin: 10px auto;
            padding: 20px;
            border-radius: 10px;
            color: black;
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
            <ul>
                <?php foreach ($tables as $table): ?>
                    <li><?php echo $table; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
</body>

</html>
