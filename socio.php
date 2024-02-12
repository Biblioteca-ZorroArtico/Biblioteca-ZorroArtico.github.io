<?php
session_start();
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
if ($_SESSION['rol'] !== 'socio' && $_SESSION['rol'] !== 'bibliotecario' && $_SESSION['rol'] !== 'administrador') {
	// Redirigir o mostrar un mensaje de error
	header("Location:notlogged.html");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/form.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 
	<title>Biblioteca - El Zorro Ártico</title>

	<style>
		h3, p, h2 {
			color: white; 
			font-size: 20px;
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
	<main>
		<div class="pelicula-principal">
			<div class="contenedor">
				<h3 class="titulo">Bienvenido, <?php echo $nombre;?></h3>
			</div>
		</div>
	</main>

	<!-- Formulario de consulta de libros -->
<form action="consulta_libros.php" method="post">
	<h4>Búsqueda de libros</h4>
    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="titulo">

    <label for="autor">Autor:</label>
    <input type="text" id="autor" name="autor">

    <label for="genero">Género:</label>
    <input type="text" id="genero" name="genero">

    <input type="submit" value="Buscar">
</form>

<!-- Formulario de comentarios y puntuación -->
<form action="comentarios.php" method="post">
	<h4>Comenta un libro &#128522;</h4>
    
<?php
// Realiza la conexión a la base de datos (asegúrate de tener este código)
include('bbdd.php');

// Consulta SQL para obtener los títulos de los libros
$sql_libros = "SELECT titulo FROM libros";
$result_libros = $conn->query($sql_libros);
?>
	
	<label for="libro">Seleccione un libro:</label>
    <select name="libro" id="libro">
        <!-- Opciones de libros obtenidas de la base de datos -->
<?php
// Verificar si la consulta fue exitosa
if ($result_libros) {
    // Iterar sobre los resultados y generar opciones
    while ($row_libro = $result_libros->fetch_assoc()) {
        echo "<option value='" . $row_libro['titulo'] . "'>" . $row_libro['titulo'] . "</option>";
    }

     // Liberar el resultado
     $result_libros->free();
} else {
        echo "Error en la consulta: " . $conn->error;
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
    </select>

    <label for="comentario">Comentario:</label>
    <textarea id="comentario" name="comentario"></textarea>

    <label for="puntuacion">Puntuación:</label>
    <select id="puntuacion" name="puntuacion">
        <option value="1">1 estrella</option>
        <option value="2">2 estrellas</option>
        <option value="3">3 estrellas</option>
        <option value="4">4 estrellas</option>
        <option value="5">5 estrellas</option>
    </select>

    <input type="submit" value="Enviar">
</form>



<!-- Mostrar todos los libros de la biblioteca -->
<section class="biblioteca">
    <h2>Libros de la biblioteca</h2>
    <!-- Aquí se mostrarán todos los libros de la biblioteca -->
</section>

<!-- Mostrar comentarios de un libro seleccionado -->
<section class="comentarios">
    <h2>Comentarios del libro seleccionado</h2>
    <!-- Aquí se mostrarán los comentarios del libro seleccionado -->
</section>





</body>