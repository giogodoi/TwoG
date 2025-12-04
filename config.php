<?php
$host = "127.0.0.1";
$user = "root";
$pass = ""; 
$bd   = "mydb";


$con = mysqli_connect($host, $user, $pass, $bd);


if (!$con) {
    die("Erro ao conectar com o banco de dados: " . mysqli_connect_error());
}
?>
