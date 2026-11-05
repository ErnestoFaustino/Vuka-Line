<?php
session_start();
include_once '../config/conexao.php';

if (isset($_POST['btn-entrar'])) {

    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    if (empty($email) || empty($senha)) {

        $_SESSION['mensagem'] = "Preencha os campos!";
        header('location: ../Login.php');
        exit;
    } else {

        $sql = "SELECT * FROM usuarios WHERE email = ?";

        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $resultado = $stmt->get_result();


        if ($resultado->num_rows > 0) {

            $dados = $resultado->fetch_assoc();

            if (password_verify($senha, $dados['senha'])) {

                $_SESSION['id'] = $dados['id'];
                $_SESSION['tipo'] = $dados['tipo'];
                $_SESSION['nome'] = $dados['nome'];
                $_SESSION['email'] = $dados['email'];

                if (trim(strtolower($dados['tipo'])) == 'estudante') {

                    header('location: ../estudante/Dashboard_Estudante.php');
                    exit;
                } elseif (trim(strtolower($dados['tipo'])) == 'empresa') {

                    header('location: ../empresa/Dashboard_Empresa.php');
                    exit;
                } else {

                    header('location: ../admin/Dashboard_Admin.php');
                    exit;
                }
            } else {

                $_SESSION['mensagem'] = "Usuário ou senha incorreta!";
                header('location: ../Login.php');
                exit;
            }
        } else {

            $_SESSION['mensagem'] = "Usuário ou senha incorreta!";
            header('location: ../Login.php');
            exit;
        }
    }
}
