<?php
$servidor = "localhost";
$usuario = "root";
$senha = "passdev";
$db_name = "painel_estagio";


$conexao = new mysqli($servidor, $usuario, $senha, $db_name);

if ($conexao->connect_error) {
   die("Erro na conexão: ".$conexao->connect_error);
}
$conexao->set_charset("utf8");
