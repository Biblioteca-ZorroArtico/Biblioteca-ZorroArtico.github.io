<?php

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener datos del formulario
    $nombre = $_POST["nombre"];
    $password = $_POST["password"];

    include('bbdd.php');

    // Recibir datos del formulario
$username = $_POST['nombre'];
$password = $_POST['password'];

// Verificar si el usuario está registrado
$sql = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Usuario autenticado y redirigirlo a la página según su rol
    $stmt = $conn->prepare("SELECT rol FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);
    $stmt->execute();
    $stmt->bind_result($rol);
    $stmt->fetch();
    $stmt->close();

    // Inicio y guardado del valor del rol en la sesión
    if (isset($_POST["enviar"])) {
        session_start();

        $_SESSION["nombre"] = htmlentities($_POST["nombre"]);

        $_SESSION["rol"] = $rol;

        header("Location: $rol.php");
    }
    
} else {
    // Usuario no registrado
    echo "Usuario no registrado. Por favor, verifica tus datos.";
}

// Cerrar conexión a la base de datos
$conn->close();
}
?>