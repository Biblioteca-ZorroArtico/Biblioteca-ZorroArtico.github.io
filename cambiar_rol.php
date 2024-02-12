<?php

// Obtener el nombre del usuario desde el parámetro en la URL
$nombre_usuario = $_GET['nombre'];

include('bbdd.php');

// Consulta para obtener el rol actual del usuario
$query = "SELECT rol FROM usuarios WHERE nombre = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $nombre_usuario);
$stmt->execute();
$stmt->bind_result($rol_actual);
$stmt->fetch();
$stmt->close();

// Lógica para cambiar el rol (Ajusta según tus necesidades)
if ($rol_actual === 'socio') {
    $nuevo_rol = 'bibliotecario';
}
if ($rol_actual === 'bibliotecario') {
    $nuevo_rol = 'administrador';
}
if ($rol_actual === 'administrador') {
    $nuevo_rol = 'visitante';
}
if ($rol_actual === 'visitante') {
    $nuevo_rol = 'socio';
}


// Actualizar el rol del usuario
$query_update = "UPDATE usuarios SET rol = ? WHERE nombre = ?";
$stmt_update = $conn->prepare($query_update);
$stmt_update->bind_param("ss", $nuevo_rol, $nombre_usuario);
$stmt_update->execute();
$stmt_update->close();

// Redirigir de nuevo a administrador.php
header("Location: administrador.php");
exit();
?>
