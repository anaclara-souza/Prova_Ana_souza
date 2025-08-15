<?php
session_start();

require_once 'conexao.php';

//GARANTE QUE O USUARIO ESTEJA LOGADO
if (!isset($_SESSION['usuario'])) {
    header("Location:login.php");
    exit();
}

//OBTENDO O NOME DO PERFIL DO USUARIO LOGADO
$id_perfil = $_SESSION['perfil'];
$sqlPerfil = "SELECT nome_perfil FROM perfil WHERE id_perfil = :id_perfil";
$stmtPerfil = $pdo->prepare($sqlPerfil);
$stmtPerfil->bindParam(':id_perfil', $id_perfil);
$stmtPerfil->execute();
$perfil = $stmtPerfil->fetch(PDO::FETCH_ASSOC);
$nome_perfil = $perfil['nome_perfil'];

//DEFINIÇAO DAS PERMISSOES POR PERFIL



$permissoes = [
    1 => [
        "Cadastrar" => ["cadastro_usuario.php", "cadastro_perfil.php", "cadastro_cliente.php", "cadastro_fornecedor.php", "cadastro_produto.php", "cadastro_funcionario"],
        "Buscar" => ["Buscar_usuario.php", "Buscar_perfil.php", "Buscar_cliente.php", "Buscar_fornecedor.php", "Buscar_produto.php", "Buscar_funcionario"],
        "Alterar" => ["Alterar_usuario.php", "Alterar_perfil.php", "Alterar_cliente.php", "Alterar_fornecedor.php", "Alterar_produto.php", "Alterar_funcionario"],
        "Excluir" => ["Excluir_usuario.php", "Excluir_perfil.php", "Excluir_cliente.php", "Excluir_fornecedor.php", "Excluir_produto.php", "Excluir_funcionario"]
    ],



    2 => [
        "Cadastrar" => ["cadastro_cliente.php"],
        "Buscar" => ["Buscar_cliente.php", "Buscar_fornecedor.php", "Buscar_produto.php"],
        "Alterar" => ["Alterar_cliente.php", "Alterar_fornecedor.php"]
    ],



    3 => [
        "Cadastrar" => ["cadastro_fornecedor.php", "cadastro_produto.php"],
        "Buscar" => ["Buscar_cliente.php", "Buscar_fornecedor.php", "Buscar_produto.php"],
        "Alterar" => ["Alterar_fornecedor.php", "Alterar_produto.php"],
        "Excluir" => ["Excluir_produto.php"]
    ],



    4 => [
        "Cadastrar" => ["cadastro_cliente.php"],
        "Buscar" => ["Buscar_produto.php"],
        "Alterar" => ["Alterar_cliente.php"]
    ],
];


//OBTENDO AS OPÇOES DISPONIVEIS PARA O PERFIL LOGADO
$opcoes_menu = $permissoes[$id_perfil];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Pincipal</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="saudacao">
            <h2>Bem vindo, <?php echo $_SESSION["usuario"]; ?> ! Perfil: <?php echo $nome_perfil; ?></h2>
        </div>

        <div class="logout">
            <form action="logout.php" method="POST">
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <nav>
        <ul class="menu">
            <?php foreach ($opcoes_menu as $categoria => $arquivos): ?>
                <li class="dropdown">
                    <a href="#"><?= $categoria ?></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($arquivos as $arquivo): ?>
                            <li>
                                <a href="<?= $arquivo ?>"><?= ucfirst(str_replace("_", " ", basename($arquivo, ".php"))) ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
</body>

</html>