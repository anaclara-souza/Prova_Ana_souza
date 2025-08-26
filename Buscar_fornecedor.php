<?php
    session_start();
    require_once'conexao.php';

    if($_SESSION['perfil']!=1 && $_SESSION['perfil'] !=2){
        echo "<script> alert('Acesso negado!!');window.location.href='principal.php' </script>";
        exit();
    }

    $fornecedores = [];

    if ($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST['busca'])){
        $busca = trim($_POST['busca']);

        if(is_numeric($busca)){
            $sql="SELECT * FROM fornecedor WHERE id_fornecedor = :busca ORDER BY nome_fornecedor ASC";

            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(':busca',$busca,PDO::PARAM_INT);
        }else{
            $sql="SELECT * FROM fornecedor WHERE nome_fornecedor LIKE :busca_nome ORDER BY nome_fornecedor ASC";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(':busca_nome',"%$busca%",PDO::PARAM_STR);
        }
    } else{
        $sql="SELECT * FROM fornecedor ORDER BY nome_fornecedor ASC";
        $stmt=$pdo->prepare($sql);
    }

    $stmt->execute();
    $fornecedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar fornecedor</title>

    <link rel="stylesheet" href="styles.css">
</head>
<body>
        <?php include_once 'menu_dropdowm.php';?>
    <h2>Lista de fornecedor</h2>
    <form action="buscar_fornecedor.php" method="POST">
        <label for="busca">Digite o ID ou NOME(opcional):</label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>
 <?php if (!empty($fornecedores)):?>
    <table class="tabela-fornecedor" border="2">
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
                    <a href="alterar_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>" class="btn-alterar">Alterar</a>
                    <a href="excluir_fornecedor.php?id=<?=htmlspecialchars($fornecedor['id_fornecedor'])?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esse fornecedor?')">Excluir</a>
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