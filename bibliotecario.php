<?php
session_start();

// Verificar si el usuario tiene el rol de "bibliotecario"
if ($_SESSION['rol'] !== 'bibliotecario') {
    // Redirigir o mostrar un mensaje de error
    header("Location:notallowed.html");
    exit();
}

include('bbdd.php'); // Asegúrate de incluir tu archivo de conexión a la base de datos

// Definir las listas predefinidas para género y nivel de lectura
$generos = ['Ficción', 'No Ficción', 'Misterio', 'Aventura', 'Romance'];
$nivelesLectura = ['1Bach', '2ESO', '3ESO', '4ESO', 'Universidad'];

// Variables para almacenar mensajes de error
$mensajeError = '';
$isbnError = '';
$tituloError = '';
$autorError = '';
$generoError = '';
$nivelLecturaError = '';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];
    $nivelLectura = $_POST['nivel_lectura'];

    // Validar la primera letra del título (mayúscula)
    if (!ctype_upper(substr($titulo, 0, 1))) {
        $tituloError = 'La primera letra del título debe ser mayúscula.';
    }

    // Validar el género
    if (!in_array($genero, $generos)) {
        $generoError = 'Selecciona un género válido.';
    }

    // Validar el nivel de lectura
    if (!in_array($nivelLectura, $nivelesLectura)) {
        $nivelLecturaError = 'Selecciona un nivel de lectura válido.';
    }

    // Verificar si hay errores antes de realizar la inserción en la base de datos
    if (empty($tituloError) && empty($generoError) && empty($nivelLecturaError)) {
        // Verificar si el libro ya existe en la base de datos (usando ISBN como clave primaria)
        $query_existe = "SELECT * FROM libros WHERE ISBN = '$isbn'";
        $result_existe = $conn->query($query_existe);

        if ($result_existe->num_rows === 0) {
            // Insertar el nuevo libro en la base de datos
            $query_insertar = "INSERT INTO libros (ISBN, titulo, autor, genero, nivel_lectura) VALUES ('$isbn', '$titulo', '$autor', '$genero', '$nivelLectura')";
            
            if ($conn->query($query_insertar)) {
                $mensajeError = 'Libro agregado correctamente.';
            } else {
                $mensajeError = 'Error al agregar el libro: ' . $conn->error;
            }
        } else {
            // El libro ya existe
            $isbnError = 'Ya existe un libro con este ISBN.';
        }
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Bibliotecario - Alta de Libros</title>
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

    <h1>Alta de Libros</h1>

    <form action="bibliotecario.php" method="post" name="form_alta_libro">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>
        <span class="error"><?php echo $isbnError; ?></span>

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <span class="error"><?php echo $tituloError; ?></span>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required>

        <label for="genero">Género:</label>
        <select id="genero" name="genero" required>
            <?php
            foreach ($generos as $genero) {
                echo "<option value='$genero'>$genero</option>";
            }
            ?>
        </select>
        <span class="error"><?php echo $generoError; ?></span>

        <label for="nivel_lectura">Nivel de Lectura:</label>
        <select id="nivel_lectura" name="nivel_lectura" required>
            <?php
            foreach ($nivelesLectura as $nivel) {
                echo "<option value='$nivel'>$nivel</option>";
            }
            ?>
        </select>
        <span class="error"><?php echo $nivelLecturaError; ?></span>

        <input type="submit" value="Agregar Libro">
    </form>

    <p class="mensaje"><?php echo $mensajeError; ?></p>

</body>

</html>
