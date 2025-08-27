<?php
session_start();
require_once 'conexao.php';

//VERIFICA SE O fornecedor TEM PERMISSAO DE ADM

if ($_SESSION['perfil'] != 1) {
    echo "<script> alert('Acesso negado'); window.location.href='principal.php';</script>";
    exit();
}

$fornecedor = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_fornecedor'])) {
        $busca = trim($_POST['busca_fornecedor']);

        if (is_numeric($busca)) {
            $sql = "SELECT * FROM fornecedor WHERE id_fornecedor = :busca";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM fornecedor WHERE nome LIKE :busca_nome";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome', "%$busca%", PDO::PARAM_STR);
        }
        $stmt->execute();
        $fornecedor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fornecedor) {
            echo "<script> alert('Fornecedor não encontrado');</script>";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar fornecedor</title>
    <link rel="stylesheet" href="styles.css">
    <script src="scripts.js"></script>
</head>

<body>
        <?php include_once 'menu_dropdowm.php';?>
    <h2>Alterar Usuários</h2>
    <form action="alterar_fornecedor.php" method="POST">
        <label for="busca_fornecedor">Digite o ID ou NOME do fornecedor:</label>
        <input type="text" id="busca_fornecedor" name="busca_fornecedor" required onkeyup="buscarSugestoes()">


        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($fornecedor):  ?>
        <form action="processa_alteracao_fornecedor.php" method="POST">
            <input type="hidden" name="id_fornecedor" value="<?= htmlspecialchars($fornecedor['id_fornecedor']) ?>">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($fornecedor['nome']) ?>" required>


            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($fornecedor['email']) ?>" required>


            <label for="id_perfil">Perfil:</label>
            <select name="id_perfil" id="id_perfil">
                <option value="1" <?= $fornecedor['id_perfil'] == 1 ? 'selected' : '' ?>>Adiministrador</option>
                <option value="2" <?= $fornecedor['id_perfil'] == 1 ? 'selected' : '' ?>>Secretaria</option>
                <option value="3" <?= $fornecedor['id_perfil'] == 1 ? 'selected' : '' ?>>Almoxarife</option>
                <option value="4" <?= $fornecedor['id_perfil'] == 1 ? 'selected' : '' ?>>Cliente</option>
            </select>
            <?php if ($_SESSION['perfil'] === 1): ?>
                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha">
            <?php endif; ?>

            <button type="submit">Alterar</button>
            <button type="reset">Cancelar</button>
        </form>
    <?php endif; ?>
            <a href="principal.php" class="btn-voltar">Voltar</a>
            
    <p>Ana Clara De Souza - Estudante - Técnico - Desenvolvimento de Sistemas</p>

</body>

</html>