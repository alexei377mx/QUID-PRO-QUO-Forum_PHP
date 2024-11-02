<?php

//$db_servidor = "sql209.infinityfree.com";
//$db_usuario = "if0_36440075";
//$db_contrasena = "0hL3vMGCnFoTTA";
//$db_basedatos = "if0_36440075_foro_production";

$db_servidor = "localhost";
$db_usuario = "root";
$db_contrasena = "";
$db_basedatos = "foro1";

$conexion = new mysqli($db_servidor, $db_usuario, $db_contrasena, $db_basedatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");

/* echo "Conectado a la DB"; */


/* PARA XAMPP */
date_default_timezone_set('America/Mexico_City');

/* PARA infinityfree */
//date_default_timezone_set('America/Los_Angeles');

/* 
quidproquo.great-site.net
*/