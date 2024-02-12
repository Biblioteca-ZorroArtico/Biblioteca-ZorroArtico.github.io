<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - El Zorro Ártico</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
		h3, p, h2, #text {
			color: white; 
			font-size: 20px;
		}
        
	</style>
    
</head>

<header>
    <div class="contenedor">
        <h2 class="logotipo">El Zorro Ártico</h2>
        <nav>
            <a href="index.html">Inicio</a>
            <a href="form_reg.html">Registrarse</a>
            <a href="form_login.html">Iniciar Sesión</a>
            <a href="biblio.php">Biblioteca</a>
        </nav>
    </div>
</header>

<h2>Resultados de búsqueda:</h2><br><br>



<?php
session_start();

// Obtener el rol y nombre del usuario de la sesión
$rol_usuario = $_SESSION["rol"];
$nombre_usuario = $_SESSION["nombre"];

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $titulo_libro = $_POST["libro"];
    $comentario = $_POST["comentario"];
    $puntuacion = $_POST["puntuacion"];

    // Realiza la conexión a la base de datos (asegúrate de tener este código)
    include('bbdd.php');

    // Consulta SQL para obtener el email del usuario
    $sql_email = "SELECT email FROM usuarios WHERE nombre = '$nombre_usuario'";
    $result_email = $conn->query($sql_email);

    // Verificar si la consulta fue exitosa
    if ($result_email) {
        // Obtener el email del resultado de la consulta
        $row_email = $result_email->fetch_assoc();
        $email_usuario = $row_email["email"];

        // Liberar el resultado
        $result_email->free();

        // Consulta SQL para obtener el ISBN del libro seleccionado
        $sql_isbn = "SELECT ISBN FROM libros WHERE titulo = '$titulo_libro'";
        $result_isbn = $conn->query($sql_isbn);

        // Verificar si la consulta fue exitosa
        if ($result_isbn) {
            // Obtener el ISBN del resultado de la consulta
            $row_isbn = $result_isbn->fetch_assoc();
            $isbn_libro = $row_isbn["ISBN"];

            // Liberar el resultado
            $result_isbn->free();

            // Consulta SQL para verificar si ya existe una valoración del usuario para el libro
            $sql_check = "SELECT * FROM valoraciones WHERE ISBN = '$isbn_libro' AND email_usuario = '$email_usuario'";
            $result_check = $conn->query($sql_check);

            // Verificar si ya existe una valoración
            if ($result_check && $result_check->num_rows > 0) {
                echo "Ya has realizado una valoración para este libro.";
            } else {
                // Consulta SQL para insertar la valoración en la tabla valoraciones
                $sql_insert = "INSERT INTO valoraciones (ISBN, email_usuario, puntuacion, comentario, fecha_valoracion) VALUES ('$isbn_libro', '$email_usuario', '$puntuacion', '$comentario', CURDATE())";

                // Verificar si la inserción fue exitosa
                if ($conn->query($sql_insert) === TRUE) {
                    echo "<p>Valoración realizada con éxito</p>";
                } else {
                    echo "<p>Error al realizar la valoración: </p>" . $conn->error;
                }
            }
        } else {
            echo "<p>Error en la consulta para obtener el ISBN: </p>" . $conn->error;
        }
    } else {
        echo "<p>Error en la consulta para obtener el email: </p>" . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>
<br>
<a href="socio.php">Volver</a>