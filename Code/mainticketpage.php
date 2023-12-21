<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přehled ticketů</title>
    <!-- Include Bootstrap CSS and Icons -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.17.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #202124;
        }
        .white, h2 {
            color:white;
        }
        .navbar {
            background-color: #343a40 !important;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Add your existing navigation links here -->
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Přehled ticketů</h2>

        <?php
    // Include the database connection file
    include 'db.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
        // Get the article ID to delete
        $id_tiket_to_delete = $_POST['delete'];

        // Delete the record from the database
        $sql = "DELETE FROM tiket WHERE id_tiket = $id_tiket_to_delete";

        if ($conn->query($sql) === TRUE) {
            echo '<div class="alert alert-success">Ticket uzavřen</div>';
        } else {
            echo '<div class="alert alert-danger">Error deleting record: ' . $conn->error . '</div>';
        }
    }

    // Fetch all articles
    $result = $conn->query("SELECT * FROM tiket");

    // Check if there are articles
    if ($result->num_rows > 0) {
        echo '<table class="table table-striped">';
        echo '<thead class="thead-dark"><tr><th>Číslo ticketu: </th><th>Stav řešení</th></tr></thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td class="white">' . $row['id_tiket'] . '</td>';
            echo '<td>
                    <a class="btn btn-info" href="ticketpage.php?id_tiket=' . $row['id_tiket'] . '"><i class="bi bi-pencil"></i> Otevřít</a>
                    <button class="btn btn-success delete-btn" data-toggle="modal" data-target="#deleteModal" data-id="' . $row['id_tiket'] . '"><i class="bi bi-trash"></i>Vyřešeno</button>
                  </td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        // Delete Confirmation Modal
        echo '
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Potvrzení vyřešení</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <p>Vyřešeno?</p>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušit</button>
                    <form method="post" action="">
                      <input type="hidden" id="deleteTicketId" name="delete" value="">
                      <button type="submit" class="btn btn-success">Vyřešeno</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        ';

    } else {
        echo '<div class="alert alert-info">No tickets found.</div>';
    }

    // Close the database connection
    $conn->close();
    ?>

    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- JavaScript for handling delete button click -->
    <script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var ticketId = $(this).data('id');
            $('#deleteTicketId').val(ticketId);
        });
    });
    </script>

</body>

</html>