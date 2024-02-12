<?php
session_start();
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
if ($_SESSION['rol'] !== 'administrador') {
    // Redirigir o mostrar un mensaje de error
    header("Location:notlogged.html");
    exit();
}
// Código para conectar con la BBDD
include('bbdd.php');

// Obtener información de usuarios
$query = "SELECT nombre, rol FROM usuarios";
$result = $conn->query($query);

// Obtener información de libros
$query_libros = "SELECT ISBN, titulo, autor, genero, puntuacion_media FROM libros";
$result_libros = $conn->query($query_libros);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>El Zorro Ártico - Administrador</title>
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        table {
            font-family: 'Helvetica', sans-serif;
            border-collapse: collapse;
            width: 50%;
            border: 2px solid #000;
            padding: 8px;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            background-color: #fff;
        }

        th {
            background-color: #04AA6D;
            color: white;
        }

        h1, h2 {
            color: white;
        }

        form {
            margin-top: 20px;
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
    <h1>Bienvenido, <?php echo $nombre; ?></h1>

<!-- REGISTRO DE USUARIOS -->

    <form action="registro_admin.php" method="post" name="form_reg_admin">
        <h2>Crear usuario</h2>
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" required maxlength="60">

        <label for="nombre">Nombre de usuario:</label>
        <input type="text" id="nombre" name="nombre" required maxlength="30">

        <label class="password" for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="rol">Rol:</label>

        <select name="rol" id="rol" required>
            <option value="socio" selected>Socio</option>
            <option value="bibliotecario">Bibliotecario</option>
            <option value="administrador">Administrador</option>
            <option value="visitante">Visitante</option>

        </select>

        <input type="submit" value="Enviar">

    </form>

<!-- TABLA DE USUARIOS -->

    <?php
    // Verificar si la consulta fue exitosa
    if ($result) {
        // Mostrar la tabla con la información de usuarios
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Rol</th><th>Acciones</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['nombre'] . "</td>";
            echo "<td>" . $row['rol'] . "</td>";
            echo "<td><a href='cambiar_rol.php?nombre=" . $row['nombre'] . "'>Cambiar Rol</a></td>";
            echo "</tr>";
        }

        echo "</table>";

        // Liberar el resultado
        $result->free();
    } else {
        echo "Error en la consulta: " . $conn->error;
    }
    ?>
    
<!-- TABLA DE LIBROS -->

<?php
    // Verificar si la consulta de libros fue exitosa
    if ($result_libros) {
        // Mostrar la tabla con la información de libros
        echo "<table id='libros-table'>";
        echo "<tr><th>ISBN</th><th>Título</th><th>Autor</th><th>Género</th><th>Puntuación Media</th><th>Acciones</th></tr>";

        while ($row_libro = $result_libros->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row_libro['ISBN'] . "</td>";
            echo "<td>" . $row_libro['titulo'] . "</td>";
            echo "<td>" . $row_libro['autor'] . "</td>";
            echo "<td>" . $row_libro['genero'] . "</td>";
            echo "<td>" . $row_libro['puntuacion_media'] . "</td>";
            echo "<td><a href='editar_libro.php?ISBN=" . $row_libro['ISBN'] . "'>Editar</a> | <a href='borrar_libro.php?ISBN=" . $row_libro['ISBN'] . "'>Borrar</a></td>";
            echo "</tr>";
        }

        echo "</table>";

        // Liberar el resultado de libros
        $result_libros->free();
    } else {
        echo "Error en la consulta de libros: " . $conn->error;
    }
    ?>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>

</body>

</html>
