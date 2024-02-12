<?php
// Establece la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bibliotecaza";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("La conexión a la base de datos ha fallado: " . $conn->connect_error);
}
?>