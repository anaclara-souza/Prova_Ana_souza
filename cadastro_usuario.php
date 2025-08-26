<?php
    session_start();

    require_once 'conexao.php';

    // VERIFICA SE O USUARIO TEM PERMISSÃO
    if($_SESSION['perfil'] != 1){
        echo "Acesso negado!";
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $id_perfil = $_POST['id_perfil'];
        
        $query = "INSERT INTO usuario (nome, email, senha, id_perfil) VALUES (:nome, :email, :senha, :id_perfil)";

        $stmt = $pdo -> prepare($query);

        $stmt -> bindParam(":nome", $nome);
        $stmt -> bindParam(":email", $email);
        $stmt -> bindParam(":senha", $senha);
        $stmt -> bindParam(":id_perfil", $id_perfil);

        if ($stmt -> execute()) {
            echo "<script> alert('Usuário cadastrado com sucesso!'); </script>";
        } else {
            echo "<script> alert('Erro ao cadastrar o usuário!'); </script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Usuário</title>

    <link rel="stylesheet" href="styles.css">
</head>
<body>
        <?php include_once 'menu_dropdowm.php';?>
    <h2>Cadastro Usuário</h2>

    <form action="cadastro_usuario.php" method="POST" onsubmit="return validarUsuario()">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required maxlength="50">

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required minlength="6">

        <label for="id_perfil">Perfil:</label>
        <select name="id_perfil" id="id_perfil">
            <option value="1">Administrador</option>
            <option value="2">Secretária</option>
            <option value="3">Almoxarife</option>
            <option value="4">Cliente</option>
        </select>

        <button type="submit">Cadastrar</button>
        <button type="reset">Cancelar</button>
    </form>

<a href="principal.php" class="btn-voltar">Voltar</a>
<p>Ana Clara De Souza - Estudante - Técnico - Desenvolvimento de Sistemas</p>


<script>

    document.getElementById("nome").addEventListener("input", function () {
        this.value = this.value.replace(/[^a-zA-ZÀ-ÿ\s]/g, "");
    });


    function validarEmail(email) {
        let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regexEmail.test(email);
    }

    document.getElementById("senha").addEventListener("input", function () {
        let senha = this.value;
        let forca = "Fraca";

        if (senha.length >= 8 && /[A-Z]/.test(senha) && /[0-9]/.test(senha)) {
            forca = "Forte";
        } else if (senha.length >= 6) {
            forca = "Média";
        }

        this.setCustomValidity("");
        this.title = "Força da senha: " + forca;
    });

    function validarUsuario() {
        let nome = document.getElementById("nome").value.trim();
        let email = document.getElementById("email").value.trim();
        let senha = document.getElementById("senha").value;

        if (nome.length < 3) {
            alert("O nome deve ter pelo menos 3 caracteres.");
            return false;
        }

        if (!validarEmail(email)) {
            alert("Digite um e-mail válido.");
            return false;
        }

        if (senha.length < 6) {
            alert("A senha deve ter pelo menos 6 caracteres.");
            return false;
        }

        return true;
    }
</script>

</body>
</html>