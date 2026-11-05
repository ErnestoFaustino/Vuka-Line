<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include_once '../../config/conexao.php';


if (!isset($_SESSION['empresa_id']) ){
    header("Location: ../../login.php");

    exit;
}
if (isset($_GET['vaga_id'])) {

    $id = (int) $_GET['vaga_id'];
    $empresa_id =  (int) $_SESSION['empresa_id'];

    $sql = "DELETE FROM vagas WHERE id = ? AND empresa_id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $id, $empresa_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['mensagem'] = "Apagado com sucesso!";
        header('Location: ../Dashboard_Empresa.php');
        exit;

    } else {
        echo "Erro ao apagar" . mysqli_error($conexao);
        header('Location: ../Dashboard_Empresa.php');
        exit;
    }
} else {
    $_SESSION['mensagem'] = "ID não rebido";
}
