<?php
session_start();
include_once '../../config/conexao.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $sql = "UPDATE candidaturas
            SET status_candidatura = 'aceite'
            WHERE id = ?";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        header("Location: ../Dashboard_Empresa.php");
        exit;
    }

}
?>