<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Estúdio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
    include("config.php");
    $id = "";
    $nome = "";
    $pais = "";
    $titulo = "Novo Estúdio";
    $botao = "Cadastrar";

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM Estudio WHERE Id_Estudio = $id";
        $result = mysqli_query($con, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $nome = $row['Nome'];
            $pais = $row['Pais'];
            $titulo = "Editar Estúdio";
            $botao = "Salvar Alterações";
        }
    }
    ?>

    <header>
        <div class="logo">
            <img src="https://cdn-icons-png.flaticon.com/512/4300/4300059.png" alt="">
        </div>
        <h1><?php echo $titulo; ?></h1>
        <p><a href="lista_estudios.php" class="text-white">← Voltar para lista de estúdios</a></p>
    </header>

    <form action="salvar_estudio.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label style="text-align:left; color:#ccc; margin-left:5px;">Nome do Estúdio</label>
        <input type="text" name="nome" placeholder="Ex: Nintendo" required value="<?php echo $nome; ?>">

        <label style="text-align:left; color:#ccc; margin-left:5px;">País Sede</label>
        <input type="text" name="pais" placeholder="Ex: Japão" value="<?php echo $pais; ?>">

        <button type="submit" style="margin-top: 20px;"><?php echo $botao; ?></button>
    </form>
</body>
</html>