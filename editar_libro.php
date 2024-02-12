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

// Procesar la actualización si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nuevoTitulo = $_POST['titulo'];
    $nuevoAutor = $_POST['autor'];
    $nuevoGenero = $_POST['genero'];

    // Actualizar la información del libro
    $query_actualizar = "UPDATE libros SET titulo = '$nuevoTitulo', autor = '$nuevoAutor', genero = '$nuevoGenero' WHERE ISBN = '$ISBN'";
    if ($conn->query($query_actualizar)) {
        echo "Libro actualizado correctamente.";
    } else {
        echo "Error al actualizar el libro: " . $conn->error;
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Editar Libro - El Zorro Ártico</title>
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        /* Agrega estilos según sea necesario */
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

    <h1 style="color: white">Editar Libro</h1>

    <form action="" method="post" name="form_editar_libro">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" value="<?php echo $row_libro['titulo']; ?>" required>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" value="<?php echo $row_libro['autor']; ?>" required>

        <label for="genero">Género:</label>
        <input type="text" id="genero" name="genero" value="<?php echo $row_libro['genero']; ?>" required>

        <input type="submit" value="Actualizar">
    </form>

</body>

<a href="administrador.php">Volver</a>

</html>