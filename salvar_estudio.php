<?php
include("config.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$pais = $_POST['pais'];

if (empty($pais)) {
    die("Erro: O 'País' é obrigatório. <a href='javascript:history.back()'>Voltar</a>");
}

if ($id == "") {

    $sql = "INSERT INTO Estudio (Nome, Pais) VALUES ('$nome', '$pais')";
} else {

    $sql = "UPDATE Estudio SET Nome='$nome', Pais='$pais' WHERE Id_Estudio=$id";
}


if (mysqli_query($con, $sql)) {
    header("location: lista_estudios.php");
} else {
    echo "<h3>Ocorreu um erro ao salvar!</h3>";
    echo "<p>Erro: " . mysqli_error($con) . "</p>";
    echo "<a href='lista_estudios.php'>Voltar</a>";
}
?>
