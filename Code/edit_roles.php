<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('db.php');

session_start(); // Start the session

$user_role = isset($_SESSION['role_uzivatele']) ? $_SESSION['role_uzivatele'] : null;

$successMessage = "";
$errorMessage = "";

// Fetch user records for display
$usersSql = "SELECT * FROM Uzivatel";
$usersResult = $conn->query($usersSql);

// Fetch roles for the dropdown, excluding the role with ID = 1
$rolesSql = "SELECT * FROM Role_a_opravneni WHERE id_opravneni != 1";
$rolesResult = $conn->query($rolesSql);

// Store role options in an array
$roleOptions = [];
if ($rolesResult->num_rows > 0) {
    while ($roleRow = $rolesResult->fetch_assoc()) {
        $roleOptions[] = ['id' => $roleRow['id_opravneni'], 'name' => $roleRow['nazev_role']];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $role = $_POST['role'];

    // Prevent users from selecting a role with ID = 1
    if ($role == 1) {
        $errorMessage = "Cannot assign Role with ID = 1.";
    } else {
        // Use prepared statement to update the role in the Uzivatel table
        $stmt = $conn->prepare("UPDATE Uzivatel SET role_uzivatele = ? WHERE id_uzivatele = ?");
        $stmt->bind_param("ii", $role, $userId);

        if ($stmt->execute()) {
            $successMessage = "Role updated successfully.";
        } else {
            $errorMessage = "Error updating role: " . $stmt->error;
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="cz">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Editace rolí</title>
    <style>
        body {
            background-color: #202124;
            color: #ffffff;
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

        h5{
            color: #343a40;
        }
    </style>

</head>

<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Editace rolí</h5>
            </div>
            <div class="card-body">
                <?php
                if (!empty($successMessage)) {
                    echo '<div class="alert alert-success">' . $successMessage . '</div>';
                } elseif (!empty($errorMessage)) {
                    echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
                }
                ?>

                <!-- Display existing users in a table -->
                <?php if ($usersResult->num_rows > 0) : ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Surname</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($userRow = $usersResult->fetch_assoc()) : ?>
                                <tr>
                                    <td><?php echo $userRow['id_uzivatele']; ?></td>
                                    <td><?php echo $userRow['jmeno_uzivatele']; ?></td>
                                    <td><?php echo $userRow['prijmeni_uzivatele']; ?></td>
                                    <td><?php echo $userRow['email_adresa']; ?></td>
                                    <td><?php echo $userRow['uzivatelske_jmeno']; ?></td>
                                    <td><?php echo $userRow['role_uzivatele']; ?></td>
                                    <td>
                                        <form method="POST" action="">
                                            <input type="hidden" name="user_id" value="<?php echo $userRow['id_uzivatele']; ?>">
                                            <div class="form-group">
                                                <select class="form-control" name="role">
                                                    <?php
                                                    foreach ($roleOptions as $option) {
                                                        echo '<option value="' . $option['id'] . '">' . $option['name'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Change Role</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>