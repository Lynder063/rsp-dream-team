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
            width: 80%;
            margin: auto;
        }

        .btn-group {
            margin-top: 20px;
        }

        .table-list {
            margin-top: 20px;
        }

        .pozadi {
            flex: 1;
            background-color: lightgrey;
            width: 80%;
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

        .table-container {
            overflow-x: auto;
            max-width: 100%;
        }
    </style>
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="pozadi">
    <div class="main-content-box">
        <h2>Database Administration</h2>

        <div class="table-list">
            <?php foreach ($tables as $table): ?>
                <h3><?php echo $table; ?></h3>
                <div class="table-container">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <?php
                            // Fetch column names for each table
                            $columns = array();
                            $result = $conn->query("DESCRIBE $table");
                            while ($row = $result->fetch_assoc()) {
                                if ($table === 'uzivatel' && ($row['Field'] === 'heslo' || $row['Field'] === 'salt')) {
                                    continue; // Skip 'heslo' and 'salt' columns for 'uzivatel' table
                                }
                                $columns[] = $row['Field'];
                            }
                            foreach ($columns as $column): ?>
                                <th><?php echo $column; ?></th>
                            <?php endforeach; ?>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Fetch entries for each table
                        $entries = array();
                        $result = $conn->query("SELECT * FROM $table");
                        while ($row = $result->fetch_assoc()) {
                            $entries[] = $row;
                        }
                        foreach ($entries as $entry): ?>
                            <tr>
                                <?php foreach ($columns as $column): ?>
                                    <td><?php echo $entry[$column]; ?></td>
                                <?php endforeach; ?>
                                <td>
                                    <form method="post" action="edit_entry.php">
                                        <input type="hidden" name="table" value="<?php echo $table; ?>">
                                        <input type="hidden" name="id" value="<?php echo $entry['id']; ?>">
                                        <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                    </form>
                                    <form method="post" action="delete_entry.php" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                        <input type="hidden" name="table" value="<?php echo $table; ?>">
                                        <input type="hidden" name="id" value="<?php echo $entry['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableHeaders = document.querySelectorAll('.table-list h3');
        const entryLists = document.querySelectorAll('.entry-list');

        tableHeaders.forEach(header => {
            header.addEventListener('click', function () {
                const targetId = this.textContent;
                entryLists.forEach(list => list.classList.remove('active'));
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>
</body>

</html>
