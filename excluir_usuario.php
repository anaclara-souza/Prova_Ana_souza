<?php 
session_start();
require_once 'conexao.php';

//VERIFICA SE O USUARIO TEM PERMISSAO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script> alert('Acesso negado'); window.location.href='principal.php';</script>";
    exit();
}

$usuario = null;

$sql ="SELECT * FROM usuario ORDER BY nome ASC ";
$stmt = $pdo->prepare($sql);
$stmt-> execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $id_usuario = $_GET['id'];

    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario,PDO::PARAM_INT);

    if($stmt->execute()){
        echo "<script> alert('Usuario excluído com sucesso!'); window.location.href='excluir_usuario.php';</script>";
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
    <h2>Excluir Usuário</h2>

    <?php if (!empty($usuarios)):?>
        <table class="tabela-usuarios">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?=htmlspecialchars($usuario['id_usuario'])?></td>
                    <td><?=htmlspecialchars($usuario['nome'])?></td>
                    <td><?=htmlspecialchars($usuario['email'])?></td>
                    <td><?=htmlspecialchars($usuario['id_perfil'])?></td>
                    <td>
                        <a href="excluir_usuario.php?id=<?=htmlspecialchars($usuario['id_usuario'])?>" 
                           class="btn-excluir" 
                           onclick="return confirm('Tem certeza que deseja excluir esse usuário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum usuário encontrado</p>
    <?php endif; ?>

    <a href="principal.php" class="btn-voltar">Voltar</a>
</body>
</html>


    <p>Ana Clara De Souza - Estudante - Técnico - Desenvolvimento de Sistemas</p>