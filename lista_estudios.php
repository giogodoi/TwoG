<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Estúdios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="https://cdn-icons-png.flaticon.com/512/4300/4300059.png" alt="Logo Estúdio">
        </div>
        <h1>Estúdios Parceiros</h1>
        <p>Gerencie as empresas de desenvolvimento</p>
        
        <p>
            <a href="index.php" style="color: #aaa; text-decoration: none; border-bottom: 1px solid #aaa; font-size: 0.9rem;">
                ← Voltar para Lista de Usuários
            </a>
        </p>
    </header>

    <?php
    include("config.php");
    
    $sql = "SELECT * FROM Estudio ORDER BY Nome ASC";
    $result = mysqli_query($con, $sql);
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome do Estúdio</th>
                <th>País Sede</th>
                <th style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>#" . $row['Id_Estudio'] . "</td>";
                    echo "<td><strong>" . htmlspecialchars($row['Nome']) . "</strong></td>";
                    echo "<td>" . ($row['Pais'] ? htmlspecialchars($row['Pais']) : '-') . "</td>";
                    
                    echo "<td style='text-align: center;'>";
                    

                    echo "<a href='form_estudio.php?id=" . $row['Id_Estudio'] . "' class='btn-action btn-edit'>Editar</a>";

                    echo "<a href='excluir_estudio.php?id=" . $row['Id_Estudio'] . "' class='btn-action btn-delete' onclick='return confirm(\"Tem certeza que deseja excluir este estúdio?\")'>Excluir</a>";
                    
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' style='text-align:center; padding:30px; color: #777;'>Nenhum estúdio cadastrado ainda.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="form_estudio.php" class="btn-create">Cadastrar Novo Estúdio</a>

</body>
</html>