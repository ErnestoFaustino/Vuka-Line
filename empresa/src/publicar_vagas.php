<?php
session_start();
include_once '../../config/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
     header("Location: ../../login.php");
} else {
     $id = $_SESSION['id'];
     $sql = "SELECT id FROM empresas WHERE usuario_id = ?";
     $stmt = $conexao->prepare($sql);
     $stmt->bind_param("i", $id);
     $stmt->execute();

     $resultado = $stmt->get_result();
     $dados = $resultado->fetch_assoc();

     $_SESSION['empresa_id'] = $dados['id'];

     if (isset($_POST['publicar-vagas'])) {

          $titulo = $_POST['titulo'];
          $descricao = $_POST['descricao'];
          $localizacao = $_POST['localizacao'];
          $salario = $_POST['salario'];
          $modalidade = $_POST['modalidade'];
         
         if(is_numeric($salario)){
             
            	 $sql = "INSERT INTO vagas(empresa_id, titulo, descricao, localizacao, salario, modalidade)
                  VALUES(?, ?, ?, ?, ?, ?)";
                  $stmt = $conexao->prepare($sql);
                  $stmt->bind_param("isssss", $_SESSION['empresa_id'], $titulo, $descricao, $localizacao, $salario, $modalidade);


                  if ($stmt->execute()) {

                       $_SESSION["mensagem"] = "Vaga publicada";
                       header('Location: ../Vagas_Postadas.php');
                       exit;
                  } else {
                       $_SESSION["mensagem"] = "Erro ao publicar";
                       header('Location: ../Vagas_Postadas.php');
                       exit;
                  } 
         }else{
                   $_SESSION["mensagem"] = "Digite um valor real";
                   header('Location: ../Vagas_Postadas.php');

         }


         
     }
}
