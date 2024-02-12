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
// Realiza la conexión a la base de datos (asegúrate de tener este código)
include('bbdd.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $genero = $_POST["genero"];

    // Consulta SQL para filtrar los libros según los parámetros del formulario
    $sql = "SELECT * FROM libros WHERE ";
    $conditions = [];

    if (!empty($titulo)) {
        $conditions[] = "titulo LIKE '%$titulo%'";
    }

    if (!empty($autor)) {
        $conditions[] = "autor LIKE '%$autor%'";
    }

    if (!empty($genero)) {
        $conditions[] = "genero = '$genero'";
    }

    // Combinar las condiciones con AND
    $sql .= implode(" AND ", $conditions);

    //implode para unir todas las condiciones con el operador lógico AND
    //Esto significa que todos los criterios deben cumplirse para que un libro sea seleccionado

    // Ejecutar la consulta
    $result = $conn->query($sql);

    // Verificar si la consulta fue exitosa
    if ($result) {
        // Mostrar los resultados o un mensaje de que no se encontraron libros
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>Título: " . $row['titulo'] . " | Autor: " . $row['autor'] . " | Género: " . $row['genero'] . "</p>";
            }
        } else {
            echo "<p>No se encontraron libros con los criterios especificados</p>";
        }

        // Liberar el resultado
        $result->free();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
}
?>

<br>
<a href="socio.php">Volver</a>