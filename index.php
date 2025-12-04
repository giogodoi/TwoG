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
            <a href="lista_estudios.php" style="color: #4CAF50; text-decoration: none; border-bottom: 1px solid #4CAF50; font-weight: bold;">
                🏢 Gerenciar Estúdios
            </a>
        </p>
    </header>

    <?php
    include("config.php");
    
    // Nota: Como o banco é 'mydb', as tabelas estão corretas.
    $sql = "SELECT u.Id_Usuario, u.nome, u.email, 
                   c.Pais_Origem, 
                   d.Cargo, d.Area 
            FROM Usuario u
            LEFT JOIN Cliente c ON u.Id_Usuario = c.Usuario_Id_Usuario
            LEFT JOIN Desenvolvedor d ON u.Id_Usuario = d.Usuario_Id_Usuario
            ORDER BY u.Id_Usuario DESC";
            
    $result = mysqli_query($con, $sql);
    ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Tipo</th>
                <th>Detalhes</th>
                <th style="text-align: center;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    // Descobre o tipo baseado em qual coluna veio preenchida do banco
                    if ($row['Pais_Origem'] != null) {
                        $tipo = "Cliente";
                        $detalhes = "País: " . htmlspecialchars($row['Pais_Origem']);
                        $badge = "background-color:#4CAF50; padding:2px 8px; border-radius:4px; color:white; font-size:10px;";
                    } elseif ($row['Cargo'] != null) {
                        $tipo = "Desenvolvedor";
                        $detalhes = htmlspecialchars($row['Cargo']) . " (" . htmlspecialchars($row['Area']) . ")";
                        $badge = "background-color:#2196F3; padding:2px 8px; border-radius:4px; color:white; font-size:10px;";
                    } else {
                        $tipo = "Genérico"; 
                        $detalhes = "-";
                        $badge = "background-color:#666; padding:2px 8px; border-radius:4px; color:white; font-size:10px;";
                    }

                    echo "<tr>";
                    echo "<td>#" . $row['Id_Usuario'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['nome']) . "<br><span style='font-size:11px; color:#777'>" . htmlspecialchars($row['email']) . "</span></td>";
                    echo "<td><span style='$badge'>$tipo</span></td>";
                    echo "<td>" . $detalhes . "</td>";
                    echo "<td style='text-align: center;'>";
                    echo "<a href='form_usuario.php?id=" . $row['Id_Usuario'] . "' class='btn-action btn-edit'>Editar</a>";
                    echo "<a href='excluir.php?id=" . $row['Id_Usuario'] . "' class='btn-action btn-delete' onclick='return confirm(\"Tem certeza que deseja excluir este usuário?\")'>Excluir</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center; padding: 30px;'>Nenhum usuário encontrado.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <a href="form_usuario.php" class="btn-create">Adicionar Novo Usuário</a>

</body>
</html>
