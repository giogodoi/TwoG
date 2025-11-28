<?php
include("config.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$tipo = $_POST['tipo'];


$pais = isset($_POST['pais']) ? $_POST['pais'] : '';
$area = isset($_POST['area']) ? $_POST['area'] : '';
$cargo = isset($_POST['cargo']) ? $_POST['cargo'] : '';

// Recebe o ID do estúdio (se vier vazio, transformamos em NULL para o banco não reclamar de string vazia em campo INT)
$id_estudio = !empty($_POST['id_estudio']) ? $_POST['id_estudio'] : "NULL";



if ($id == "") {
    $sqlUsuario = "INSERT INTO Usuario (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
    
    if (mysqli_query($con, $sqlUsuario)) {
        $ultimo_id = mysqli_insert_id($con); 

        if ($tipo == "Cliente") {
            $sqlFilho = "INSERT INTO Cliente (Usuario_Id_Usuario, Pais_Origem) VALUES ($ultimo_id, '$pais')";
        } else {
            $sqlFilho = "INSERT INTO Desenvolvedor (Usuario_Id_Usuario, Area, Cargo, Id_Estudio) VALUES ($ultimo_id, '$area', '$cargo', $id_estudio)";
        }
        mysqli_query($con, $sqlFilho);
    }
} 

else {
    $sqlBase = "UPDATE Usuario SET nome='$nome', email='$email'";
    if ($senha != "") { $sqlBase .= ", senha='$senha'"; }
    $sqlBase .= " WHERE Id_Usuario=$id";
    mysqli_query($con, $sqlBase);

    if ($tipo == "Cliente") {
        // Usamos ON DUPLICATE KEY UPDATE para o caso de mudarmos o tipo de Dev para Cliente na edição
        $sqlFilho = "INSERT INTO Cliente (Usuario_Id_Usuario, Pais_Origem) VALUES ($id, '$pais') 
                     ON DUPLICATE KEY UPDATE Pais_Origem='$pais'";
    } else {
        $sqlFilho = "INSERT INTO Desenvolvedor (Usuario_Id_Usuario, Area, Cargo, Id_Estudio) VALUES ($id, '$area', '$cargo', $id_estudio) 
                     ON DUPLICATE KEY UPDATE Area='$area', Cargo='$cargo', Id_Estudio=$id_estudio";
    }
    mysqli_query($con, $sqlFilho);
}

header("location: index.php");
?>