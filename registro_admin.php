<?php
include('bbdd.php');
$email = $_POST['email'];
$nombre = $_POST['nombre'];
$password = $_POST['password'];
$rol = $_POST['rol'];

$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Este usuario ya está registrado.";
} else {
    
    $sql_insert = "INSERT INTO usuarios (email, nombre, password, rol) VALUES ('$email', '$nombre', '$password', '$rol')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }
}

$conn->close();

?>