<?php
error_reporting(E_ALL);
ini_set('display_erros', 1);
session_start();
include_once '../../config/conexao.php';


if (!isset($_SESSION['email']) || $_SESSION['tipo'] != 'admin') {
    header("Location: ../../login.php");

    exit;
}
if (isset($_GET['usuario_id'])) {

    $id = (int) $_GET['usuario_id'];
    $email =  $_SESSION['user_email'];
    $sql = "DELETE FROM usuarios WHERE id = ? ";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['mensagem'] = "Apagado com sucesso!";
        header('Location: ../Dashboard_Admin.php');

        exit;
    } else {
        echo "Erro ao apagar" . mysqli_error($conexao);
        header('Location: ../Dashboard_Admin.php');
        exit;
    }
} else {
    echo "ID não rebido";
}
