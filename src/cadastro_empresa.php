<?php
session_start();
include_once '../config/conexao.php';


if (isset($_POST['btn-cadastrar'])) {
    $nome = $conexao->escape_string($_POST['nome']);
    $email = $conexao->escape_string($_POST['email']);
    $senha =  $conexao->escape_string(password_hash($_POST['senha'], PASSWORD_DEFAULT));
    $descricao = $conexao->escape_string($_POST['descricao']);
    $tipo = $_SESSION['tipo'];

    if (empty($nome) || empty($email) || empty($senha) || empty($descricao)) {
        $_SESSION['mensagem'] = "Preencha os campos!";
        header('location: ../Cadastrar.php');
        exit;
    } else {

        $sql = "SELECT id FROM usuarios WHERE email = ? ";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $_SESSION['mensagem'] = "Este empresa já existe no banco de dados";
            header('location: ../Cadastrar.php');
            exit;
        } else {

            $sql = "INSERT INTO usuarios(email, senha, tipo) VALUES (?, ?, ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("sss", $email, $senha, $tipo);
            $stmt->execute();

            $usuario_id = $conexao->insert_id;
            $sql = "INSERT INTO empresas(usuario_id, nome, descricao) VALUES (?, ?, ?)";

            $stmt = $conexao->prepare($sql);
            $stmt->bind_param("iss", $usuario_id, $nome, $descricao);
            $stmt->execute();
            $_SESSION['mensagem'] = "Cadastrado com sucesso!";
            header('location: ../Login.php');
            exit;
        }
    }
}
