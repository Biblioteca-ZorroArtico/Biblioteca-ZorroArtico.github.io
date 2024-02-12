<?php
include('bbdd.php'); // Asegúrate de incluir tu archivo de conexión a la base de datos

// Consulta para obtener todos los libros y sus puntuaciones
$query = "SELECT ISBN, titulo, puntuacion_media FROM libros";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca - El Zorro Ártico</title>
    <link rel="stylesheet" href="css/estilos.css"> <!-- Ajusta la ruta según tu estructura de archivos -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 
    <style>

        ul {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        li {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .comentarios {
            margin-top: 30px;
        }

        .comentario {
            background-color: #eee;
            padding: 10px;
            margin-bottom: 10px;
        }

        .titulo {
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
            <a href="biblio.php" class="activo">Biblioteca</a>
        </nav>
    </div>
</header>

<main>
    <div class="contenedor">
        <h3 class="titulo">Biblioteca</h3>

        <?php
        // Array de nombres de imágenes
        $imagenes = [
            'libro1.jpg', 'libro2.jpg', 'libro3.jpg', 'libro4.jpg', 'libro5.jpg',
            'libro6.jpg', 'libro7.jpg', 'libro8.jpg', 'libro9.jpg', 'libro10.jpg',
            'libro11.jpg', 'libro12.jpg', 'libro13.jpg', 'libro14.jpg', 'libro15.jpg',
            'libro16.jpg', 'libro17.jpg', 'libro18.jpg', 'libro19.jpg', 'libro20.jpg', 'libro21.jpg'
        ];

        // Verificar si la consulta fue exitosa
        if ($result) {
            // Mostrar la lista de libros con títulos y puntuaciones medias
            echo "<ul>";
            $counter = 0; // Índice del array de nombres de imágenes
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                // Usar el índice actual para obtener el nombre de la imagen
                $rutaImagen = "img/libros/{$imagenes[$counter]}";
                echo "<img src='{$rutaImagen}' alt='Portada del libro'>";
                echo "<h4>{$row['titulo']}</h4>";
                echo "<p>Puntuación Media: {$row['puntuacion_media']}</p>";
                echo "</li>";

                $counter++;
            }
            echo "</ul>";

            // Liberar el resultado
            $result->free();

            // Consulta SQL para obtener los últimos 5 comentarios
            $sql_ultimos_comentarios = "SELECT usuarios.nombre AS nombre_usuario, valoraciones.puntuacion, valoraciones.comentario, valoraciones.fecha_valoracion
                                        FROM valoraciones
                                        JOIN usuarios ON valoraciones.email_usuario = usuarios.email
                                        ORDER BY valoraciones.fecha_valoracion DESC
                                        LIMIT 5";
            $result_ultimos_comentarios = $conn->query($sql_ultimos_comentarios);

            // Mostrar los últimos 5 comentarios
            if ($result_ultimos_comentarios) {
                echo "<div class='comentarios'>";
                echo "<h4 class='titulo'>Últimos 5 Comentarios</h4>";
                while ($row_ultimo_comentario = $result_ultimos_comentarios->fetch_assoc()) {
                    echo "<div class='comentario'>";
                    echo "<p><strong>{$row_ultimo_comentario['nombre_usuario']}</strong> - Puntuación: {$row_ultimo_comentario['puntuacion']}</p>";
                    echo "<p>{$row_ultimo_comentario['comentario']}</p>";
                    echo "<p>Fecha de valoración: {$row_ultimo_comentario['fecha_valoracion']}</p>";
                    echo "</div>";
                }
                echo "</div>";

                // Liberar el resultado de los últimos comentarios
                $result_ultimos_comentarios->free();
            } else {
                echo "Error en la consulta de últimos comentarios: " . $conn->error;
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </div>
</main>

</body>
</html>
