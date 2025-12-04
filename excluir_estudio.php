<?php
include("config.php");


mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "DELETE FROM Estudio WHERE Id_Estudio = $id";
        mysqli_query($con, $sql);
        
        
        header("location: lista_estudios.php");
        exit; 

    } catch (mysqli_sql_exception $e) {
        // O código 1451 é o erro específico de chave estrangeira (Foreign Key Constraint)
        if ($e->getCode() == 1451) {
            echo "
            <div style='font-family: Arial; max-width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; background: #f8d7da; color: #721c24;'>
                <h2>⚠️ Não foi possível excluir!</h2>
                <p>Este estúdio possui <strong>Produtos (Jogos)</strong> cadastrados no sistema.</p>
                <p>Para manter a segurança dos dados, você precisa excluir os produtos deste estúdio antes de excluir a empresa.</p>
                <br>
                <a href='lista_estudios.php' style='text-decoration: none; font-weight: bold; color: #721c24;'>← Voltar para a lista</a>
            </div>
            ";
        } else {
            // Se for outro erro qualquer, mostra a mensagem técnica
            echo "Erro ao excluir: " . $e->getMessage();
        }
    }
} else {
    header("location: lista_estudios.php");
}
?>
