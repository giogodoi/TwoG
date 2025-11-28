<?php
include("config.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM Estudio WHERE Id_Estudio = $id";
    
    if(!mysqli_query($con, $sql)){
        echo "Erro ao excluir (verifique se há desenvolvedores vinculados): " . mysqli_error($con);
        die();
    }
}

header("location: lista_estudios.php");
?>