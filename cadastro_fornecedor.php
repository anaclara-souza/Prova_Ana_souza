<?php
    session_start();

    require_once 'conexao.php';

    // VERIFICA SE O fornecedor TEM PERMISSÃO
    if($_SESSION['perfil'] != 1){
        echo "Acesso negado!";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $nome_fornecedor = $_POST['nome_fornecedor'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $contato = $_POST['contato'];
        


        
        $query = "INSERT INTO fornecedor ( nome_fornecedor, endereco, telefone, email, contato) VALUES ( :nome_fornecedor, :endereco, :telefone, :email, :contato)";

        $stmt = $pdo -> prepare($query);


        $stmt -> bindParam(":nome_fornecedor", $nome_fornecedor);
        $stmt -> bindParam(":endereco", $endereco);
        $stmt -> bindParam(":telefone", $telefone);
        $stmt -> bindParam(":email", $email);
        $stmt -> bindParam(":contato", $contato);


        if ($stmt -> execute()) {
            echo "<script> alert('Fornecedor cadastrado com sucesso!'); </script>";
        } else {
            echo "<script> alert('Erro ao cadastrar o fornecedor!'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro fornecedor</title>

    <link rel="stylesheet" href="styles.css">
</head>
<body>
        <?php include_once 'menu_dropdowm.php';?>
    <h2>Cadastro fornecedor</h2>

    <form action="cadastro_fornecedor.php" method="POST" onsubmit="return validarFornecedor()">
        <label for="nome_fornecedor">Nome:</label>
        <input type="text" name="nome_fornecedor" id="nome_fornecedor" required maxlength="50">

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" id="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" id="telefone" required maxlength="50">

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <label for="contato">Contato:</label>
        <input type="text" name="contato" id="contato" required maxlength="50">


        <button type="submit">Cadastrar</button>
        <button type="reset">Cancelar</button>
    </form>

<a href="principal.php" class="btn-voltar">Voltar</a>
<p>Ana Clara De Souza - Estudante - Técnico - Desenvolvimento de Sistemas</p>


<script>

    document.getElementById("nome_fornecedor").addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, "");
    });


    function validarEmail(email) {
        let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regexEmail.test(email);
    }


    function validarFornecedor() {
        let nome_fornecedor = document.getElementById("nome_fornecedor").value.trim();
        let email = document.getElementById("email").value.trim();

        if (nome_fornecedor.length < 3) {
            alert("O nome deve ter pelo menos 3 caracteres.");
            return false;
        }

        if (!validarEmail(email)) {
            alert("Digite um e-mail válido.");
            return false;
        }

        return true;
    }
</script>

</body>
</html>