<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Usuários</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <div class="logo">
            <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="Logo">
        </div>
        <h1>Lista de Usuários</h1>
        <p>Gerencie o acesso ao sistema</p>
        <p>
        <a href="lista_estudios.php" style="color: #4CAF50; text-decoration: none; border-bottom: 1px solid #4CAF50;">
        🏢 Gerenciar Estúdios
    </a>
</p>
    </header>

    <?php
    include("config.php");
    
    $sql = "SELECT * FROM Usuario ORDER BY Id_Usuario DESC";
    $result = mysqli_query($con, $sql);
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>#" . $row['Id_Usuario'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td style='text-align: center;'>";
                    
                
                    echo "<a href='form_usuario.php?id=" . $row['Id_Usuario'] . "' class='btn-action btn-edit'>Editar</a>";
                    
                 
                    echo "<a href='excluir.php?id=" . $row['Id_Usuario'] . "' class='btn-action btn-delete' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>Excluir</a>";
                    
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; padding: 30px;'>Nenhum usuário encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="form_usuario.php" class="btn-create">Adicionar Novo Usuário</a>

</body>
</html>