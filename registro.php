<?php
// LLama a el segmento de código en bbdd.php
include('bbdd.php');

// Obtiene los datos del formulario
$email = $_POST['email'];
$nombre = $_POST['nombre'];
$password = $_POST['password']; // Se recomienda almacenar contraseñas hasheadas
$rol = 'socio';

// Verifica si el usuario ya existe
$sql = "SELECT * FROM usuarios WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Este usuario ya está registrado.";
} else {
    // Inserta el nuevo usuario en la BBDD
    $sql_insert = "INSERT INTO usuarios (email, nombre, password, rol) VALUES ('$email', '$nombre', '$password', '$rol')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "Usuario registrado con éxito.";
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }
}

// Cierra la conexión
$conn->close();
?>
