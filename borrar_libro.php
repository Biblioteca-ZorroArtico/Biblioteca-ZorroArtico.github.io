<?php
session_start();

// Verificar el rol del usuario
if ($_SESSION['rol'] !== 'administrador') {
    // Redirigir o mostrar un mensaje de error
    header("Location:notlogged.html");
    exit();
}

// Código para conectar con la BBDD
include('bbdd.php');

// Verificar si se proporciona un ISBN válido en la URL
if (isset($_GET['ISBN'])) {
    $ISBN = $_GET['ISBN'];

    // Consulta SQL para obtener información del libro
    $query_libro = "SELECT ISBN, titulo, autor, genero, puntuacion_media FROM libros WHERE ISBN = '$ISBN'";
    $result_libro = $conn->query($query_libro);

    // Verificar si la consulta fue exitosa
    if ($result_libro && $result_libro->num_rows > 0) {
        $row_libro = $result_libro->fetch_assoc();
    } else {
        // Si no se encuentra el libro, puedes redirigir o mostrar un mensaje de error
        echo "Libro no encontrado.";
        exit();
    }
} else {
    // Si no se proporciona un ISBN, puedes redirigir o mostrar un mensaje de error
    echo "ISBN no proporcionado.";
    exit();
}

// Procesar la eliminación si se confirmó
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    // Eliminar el libro de la base de datos
    $query_eliminar = "DELETE FROM libros WHERE ISBN = '$ISBN'";
    if ($conn->query($query_eliminar)) {
        echo "Libro eliminado correctamente.";
    } else {
        echo "Error al eliminar el libro: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Borrar Libro - El Zorro Ártico</title>
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        body {
            color:white;
        }
    </style>
</head>

<body>

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

    <h1>Borrar Libro</h1>

    <p>¿Estás seguro de que deseas eliminar el siguiente libro?</p>

    <p><strong>Título:</strong> <?php echo $row_libro['titulo']; ?></p>
    <p><strong>Autor:</strong> <?php echo $row_libro['autor']; ?></p>
    <p><strong>Género:</strong> <?php echo $row_libro['genero']; ?></p>

    <form action="" method="post" name="form_borrar_libro">
        <input type="submit" name="confirmar" value="Confirmar">
        <a href="administrador.php">Cancelar</a>
    </form>

</body>

</html>
