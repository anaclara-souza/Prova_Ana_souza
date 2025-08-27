<?php 
session_start();
require_once 'conexao.php';


if ($_SESSION['perfil'] != 1) {
    echo "<script> alert('Acesso negado'); window.location.href='principal.php';</script>";
    exit();
}
if ($_SERVER["REQUEST_METHOD"] =="POST"){
    $id_fornecedor = $_POST['id_fornecedor'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];




    if($nova_senha){
        $sql = "UPDATE fornecedor SET nome = :nome, email = :email, senha = :senha WHERE id_fornecedor = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha',$nova_senha);
    }else{
            $sql = "UPDATE fornecedor SET nome = :nome, email = :email, WHERE id_fornecedor = :id";
            $stmt = $pdo->prepare($sql);
    }
    $stmt->bindParam(':nome',$nome);
    $stmt->bindParam(':endereco',$email);
    $stmt->bindParam(':telefone',$nome);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':contato',$nome);
    
    $stmt->bindParam(':id',$id_fornecedor);

    if($stmt->execute()){
        echo "<script> alert('Fornecedor atualizado com sucesso!'); window.location.href='buscar_fornecedor.php';</script>";
    }else{
        echo "<script> alert(' Erro ao Atualizar o fornecedor'); window.location.href='alterar_fornecedor.php?id=$fornecedor';</script>";
    }
}
?>