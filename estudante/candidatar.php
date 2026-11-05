<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
session_start();
include_once '../config/conexao.php';


if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estudante') {
    header("Location: ../../login.php");
    exit;
}
if (isset($_POST['btn-candidatar'])) {

    $vaga_id = (int) $_POST['vaga_id'];
    $estudante_id = (int) $_SESSION['id'];

    $sql_Estudante = "SELECT id FROM estudantes WHERE usuario_id = ?";
    $stmt = $conexao->prepare($sql_Estudante);
    $stmt->bind_param("i", $estudante_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $dados =  $resultado->fetch_assoc();

    $sql = "SELECT * FROM candidaturas WHERE vaga_id = ? AND estudante_id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $vaga_id, $dados['id']);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION["mensagem"] = "Você já se candidatou";
        header("Location: Dashboard_Estudante.php");
        exit;
    }
    $sql = "INSERT INTO candidaturas(vaga_id, estudante_id) VALUES (?, ?)";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("ii", $vaga_id,$dados['id']);

    if ($stmt->execute()) {
        header("Location: Dashboard_Estudante.php");
        exit;
    } else {
        echo "ERROOOOO!";
    }
}

