<?php 
session_start();
require_once 'conexao.php';

//VERIFICA SE O FORNECEDOR TEM PERMISSAO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script> alert('Acesso negado'); window.location.href='principal.php';</script>";
    exit();
}

$fornecedor = null;

$sql ="SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC ";
$stmt = $pdo->prepare($sql);
$stmt-> execute();
$fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_fornecedor = $_GET['id'];

    $sql = "DELETE FROM fornecedor WHERE id_fornecedor = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_fornecedor,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script> alert('Fornecedor excluído com sucesso!'); window.location.href='excluir_fornecedor.php';</script>";
    } else{
        echo "<script> alert('Erro ao excluir usuário');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="PT-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Usuário</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include_once 'menu_dropdowm.php';?>
    <h2>Excluir Fornecedor</h2>

    <?php if (!empty($fornecedores)):?>
        <table class="tabela-fornecedor">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Contato</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($fornecedores as $fornecedor): ?>
                <tr>
                    <td><?=htmlspecialchars($fornecedor['id_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['nome_fornecedor'])?></td>
                    <td><?=htmlspecialchars($fornecedor['endereco'])?></td>
                    <td><?=htmlspecialchars($fornecedor['telefone'])?></td>
                    <td><?=htmlspecialchars($fornecedor['email'])?></td>
                    <td><?=htmlspecialchars($fornecedor['contato'])?></td>
                    <td>
                        <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>" 
                           class="btn-excluir" 
                           onclick="return confirm('Tem certeza que deseja excluir esse Fornecedor?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum fornecedor encontrado</p>
    <?php endif; ?>

    <a href="principal.php" class="btn-voltar">Voltar</a>
    <p>Ana Clara De Souza - Estudante - Técnico - Desenvolvimento de Sistemas</p>
</body>
</html>
