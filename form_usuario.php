<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro Completo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        .hidden { display: none; }
        .grupo-especifico {
            background-color: #2C2C2E;
            padding: 15px;
            border-radius: 10px;
            margin-top: 10px;
            border: 1px solid #71717144;
        }
        h3 { color: #fff; font-size: 1rem; margin-bottom: 10px; margin-top: 0; }
        .grupo-especifico label { font-size: 0.8rem; display: block; margin-top: 10px; margin-bottom: 5px;}
    </style>
</head>
<body>
    <?php
    include("config.php");
    
    $id = ""; $nome = ""; $email = "";
    $tipo = "Cliente"; 
    $pais = ""; $area = ""; $cargo = ""; $id_estudio_selecionado = "";
    
    // Busca estúdios para preencher o select
    $queryEstudios = "SELECT * FROM Estudio ORDER BY Nome";
    $resultEstudios = mysqli_query($con, $queryEstudios);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
        $sqlCli = "SELECT * FROM Usuario u INNER JOIN Cliente c ON u.Id_Usuario = c.Usuario_Id_Usuario WHERE u.Id_Usuario = $id";
        $resCli = mysqli_query($con, $sqlCli);
        
        $sqlDev = "SELECT * FROM Usuario u INNER JOIN Desenvolvedor d ON u.Id_Usuario = d.Usuario_Id_Usuario WHERE u.Id_Usuario = $id";
        $resDev = mysqli_query($con, $sqlDev);

        if (mysqli_num_rows($resCli) > 0) {
            $row = mysqli_fetch_assoc($resCli);
            $tipo = "Cliente";
            $pais = $row['Pais_Origem'];
        } elseif (mysqli_num_rows($resDev) > 0) {
            $row = mysqli_fetch_assoc($resDev);
            $tipo = "Desenvolvedor";
            $area = $row['Area'];
            $cargo = $row['Cargo'];
            // ATENÇÃO: O nome da coluna no banco novo é Estudio_Id_Estudio
            $id_estudio_selecionado = $row['Estudio_Id_Estudio']; 
        }
        
        if(isset($row)) {
            $nome = $row['nome'];
            $email = $row['email'];
        }
    }
    ?>

    <header>
        <div class="logo"><img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt=""></div>
        <h1><?php echo ($id == "") ? "Novo Cadastro" : "Editar Cadastro"; ?></h1>
        <p><a href="index.php" class="text-white">← Voltar</a></p>
    </header>

    <form action="salvar.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label style="color:#ccc;">Dados Básicos</label>
        <input type="text" name="nome" placeholder="Nome Completo" required value="<?php echo $nome; ?>">
        <input type="email" name="email" placeholder="E-mail" required value="<?php echo $email; ?>">
        <input type="password" name="senha" placeholder="Senha" <?php echo ($id == "") ? "required" : ""; ?>>
        
        <label style="color:#ccc; margin-top:15px;">Tipo de Usuário</label>
        <select name="tipo" id="selectTipo" onchange="mudarFormulario()">
            <option value="Cliente" <?php echo ($tipo == 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
            <option value="Desenvolvedor" <?php echo ($tipo == 'Desenvolvedor') ? 'selected' : ''; ?>>Desenvolvedor</option>
        </select>

        <div id="camposCliente" class="grupo-especifico <?php echo ($tipo != 'Cliente') ? 'hidden' : ''; ?>">
            <h3>Dados do Cliente</h3>
            <label>País de Origem</label>
            <input type="text" name="pais" placeholder="Ex: Brasil" value="<?php echo $pais; ?>">
        </div>

        <div id="camposDev" class="grupo-especifico <?php echo ($tipo != 'Desenvolvedor') ? 'hidden' : ''; ?>">
            <h3>Dados do Desenvolvedor</h3>
            
            <label>Área de Atuação</label>
            <input type="text" name="area" placeholder="Ex: Frontend, Backend..." value="<?php echo $area; ?>">
            
            <label>Cargo</label>
            <input type="text" name="cargo" placeholder="Ex: Júnior, Senior..." value="<?php echo $cargo; ?>">
            
            <label>Estúdio Vinculado</label>
            <select name="id_estudio">
                <option value="">Selecione um Estúdio...</option>
                <?php
                if ($resultEstudios && mysqli_num_rows($resultEstudios) > 0) {
                    mysqli_data_seek($resultEstudios, 0); 
                    while($estudio = mysqli_fetch_assoc($resultEstudios)) {
                        $selected = ($estudio['Id_Estudio'] == $id_estudio_selecionado) ? "selected" : "";
                        echo "<option value='".$estudio['Id_Estudio']."' $selected>".$estudio['Nome']."</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit" style="margin-top:20px;">Salvar Dados</button>
    </form>

    <script>
        function mudarFormulario() {
            const tipo = document.getElementById('selectTipo').value;
            const divCliente = document.getElementById('camposCliente');
            const divDev = document.getElementById('camposDev');

            if (tipo === 'Cliente') {
                divCliente.classList.remove('hidden');
                divDev.classList.add('hidden');
            } else {
                divCliente.classList.add('hidden');
                divDev.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
