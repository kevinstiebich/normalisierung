<?php
// Zeigt alle Fehler an – super nützlich beim Entwickeln! - ausschalten wenn live
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Verbindungsdaten einmalig aus config.php laden
require_once 'config.php';

// Content-Type Header: Teilt dem Browser mit, dass er JSON erwarten soll
header('Content-Type: application/json');

// Verbindung aufbauen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung prüfen
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['tabelle'])) {
    switch ($_GET['tabelle']) {
        case 'bestellpositionen':
            $sql = "SELECT * FROM bestellpositionen";
            break;
        case 'bestellungen':
            $sql = "SELECT * FROM bestellungen";
            break;
        case 'hersteller':
            $sql = "SELECT * FROM hersteller";
            break;
        case 'kunden':
            $sql = "SELECT * FROM kunden";
            break;
        case 'produkte':
            $sql = "SELECT * FROM produkte";
            break;
        default:
            die("nicht vorhandener Parameter");
            break;
    }

    // Ergebnis abrufen
    $result = $conn->query($sql);

    $data = []; // leeres Array vorbereiten
    if ($result->num_rows > 0) {
        // fetch_assoc() holt eine Zeile nach der anderen als assoziatives Array
        while($row = $result->fetch_assoc()) {
            $data[] = $row; // Jede Zeile zum Array hinzufügen
        }
    }
    //$daten = $result->fetch_all(MYSQLI_ASSOC);

    // PHP-Array in einen JSON-String umwandeln und in einer Variable speichern
    $json = json_encode($data);
    
} else {
    die("Parameter angeben");
}

// JSON ausgeben
echo($json);
$conn->close();
?>