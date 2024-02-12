<?php
session_start();
$nombre = $_SESSION['nombre'];
$rol = $_SESSION['rol'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/estilos.css">
	<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 
	<title>Biblioteca - El Zorro Ártico</title>
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
				<h3 class="titulo">Bienvenid@ a la visita</h3>
			</div>
		</div>
	</main>