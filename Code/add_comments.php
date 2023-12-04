<?php
require_once('db.php');

$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrola připojení
if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}

// Přidání komentáře
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pridat_komentar"])) {
    $jmeno = $_POST["jmeno"];
    $text = $_POST["text"];

    $sql = "INSERT INTO komentare (jmeno, text) VALUES ('$jmeno', '$text')";

    if ($conn->query($sql) === TRUE) {
        echo "Komentář byl úspěšně přidán.";
    } else {
        echo "Chyba při přidávání komentáře: " . $conn->error;
    }
}

// Smazání komentáře
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["smazat_komentar"])) {
    $id_komentare = $_POST["id_komentare"];

    $sql = "DELETE FROM komentare WHERE id=$id_komentare";

    if ($conn->query($sql) === TRUE) {
        echo "Komentář byl úspěšně smazán.";
    } else {
        echo "Chyba při mazání komentáře: " . $conn->error;
    }
}

// Získání a zobrazení komentářů
$sql = "SELECT * FROM komentare";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . "<br>";
        echo "Jméno: " . $row["jmeno"] . "<br>";
        echo "Text: " . $row["text"] . "<br>";
        echo "Čas: " . $row["cas"] . "<br>";
        echo "<form method='post' action=''>
                <input type='hidden' name='id_komentare' value='" . $row["id"] . "'>
                <input type='submit' name='smazat_komentar' value='Smazat'>
              </form>";
        echo "<hr>";
    }
} else {
    echo "Žádné komentáře zatím nebyly přidány.";
}

// Uzavření připojení k databázi
$conn->close();
?>

<!-- Formulář pro přidání komentáře -->
<form method="post" action="">
    Jméno: <input type="text" name="jmeno"><br>
    Text: <textarea name="text"></textarea><br>
    <input type="submit" name="pridat_komentar" value="Přidat komentář">
</form>