<?php 

// Credenciales de la base de datos.
// Credentials of the database.
define('DB_USER','root');
define('DB_PASSWORD','');
define('DB_HOST', 'localhost');
define('DB_NAME','agendaphp');

$conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
// echo $conn->ping();


?>