<?php
include("config.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $sql = "DELETE FROM Usuario WHERE Id_Usuario = $id";
    mysqli_query($con, $sql);
}


header("location: index.php");
?>