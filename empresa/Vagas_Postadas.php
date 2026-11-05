<?php
session_start();
include_once '../config/conexao.php'; 

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: ../Login.php");
    exit;
}

$empresa_id = $_SESSION['empresa_id'];

// Buscar as vagas publicadas por esta empresa
$sql_vagas = "SELECT * FROM vagas WHERE empresa_id = ? ORDER BY id DESC";
$stmt = $conexao->prepare($sql_vagas);
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$resultado_vagas = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Vagas - Vuka Line</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/Vagas_Postadas.css">
</head>
<body>
    <header class="cabecalho cabecalho-interno">
        <div class="container-cabecalho">
            <div class="logotipo">
                <img src="../assets/img/IMG-20260513-WA0032.jpg" alt="Vuka Line Logo">
                <span>Vuka Line</span>
            </div>

            <nav class="menu-navegacao">
                <ul>
                    <li><a href="Dashboard_Empresa.php">Painel</a></li>
                    <li><a href="Vagas_Postadas.php" style="color: var(--brand-600); font-weight: 600;">Vagas Postadas</a></li>
                </ul>
            </nav>

            <div class="botoes-acesso">
                <a href="../logout.php" class="botao-dashboard botao-remover" style="padding: 8px 16px;">Sair</a>
            </div>
        </div>
    </header>

    <main class="container page-content">
        <div class="page-header">
            <div>
                <h1>Minhas Vagas</h1>
                <p>Gerencie todas as oportunidades de estágio publicadas pela sua empresa.</p>
            </div>
            <a href="Dashboard_Empresa.php#publicar" class="btn btn-primary">Publicar Nova Vaga</a>
        </div>

        <?php
        if (isset($_SESSION['mensagem'])) {
            echo '<div class="alert alert-info" style="margin-bottom: 24px;">' . $_SESSION['mensagem'] . '</div>';
            unset($_SESSION['mensagem']);
        }
        ?>

        <div class="lista-vagas">
            <?php 
            if ($resultado_vagas->num_rows > 0) {
                while ($vaga = $resultado_vagas->fetch_assoc()) { 
                    
                    // Buscar número de candidaturas para esta vaga
                    $sql_cand = "SELECT COUNT(*) as total FROM candidaturas WHERE vaga_id = ?";
                    $stmt_cand = $conexao->prepare($sql_cand);
                    $stmt_cand->bind_param("i", $vaga['id']);
                    $stmt_cand->execute();
                    $cand_result = $stmt_cand->get_result()->fetch_assoc();
                    $total_candidaturas = $cand_result['total'];
            ?>
                <div class="card card-vaga-detalhe">
                    <div class="vaga-info-principal">
                        <h2><?= $vaga['titulo'] ?></h2>
                        <div class="vaga-badges">
                            <span class="badge badge-success">Ativa</span>
                            <span class="badge badge-info"><?= $vaga['modalidade'] ?></span>
                        </div>
                    </div>
                    
                    <div class="vaga-corpo">
                        <div class="vaga-detalhes-grid">
                            <div class="detalhe-item">
                                <span class="detalhe-label">Localização</span>
                                <span class="detalhe-valor"><?= $vaga['localizacao'] ?></span>
                            </div>
                            <div class="detalhe-item">
                                <span class="detalhe-label">Remuneração</span>
                                <span class="detalhe-valor"><?= $vaga['salario'] ?></span>
                            </div>
                            <div class="detalhe-item">
                                <span class="detalhe-label">Candidaturas</span>
                                <span class="detalhe-valor"><?= $total_candidaturas ?> inscritos</span>
                            </div>
                        </div>
                        
                        <div class="vaga-descricao-box">
                            <span class="detalhe-label">Descrição da Vaga</span>
                            <p><?= nl2br($vaga['descricao']) ?></p>
                        </div>
                    </div>
                    
                    <div class="vaga-acoes">
                        <a href="src/apagar_vagas.php?vaga_id=<?= $vaga['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja encerrar esta vaga? Esta ação não pode ser desfeita e afetará os candidatos inscritos.')">Encerrar Vaga</a>
                    </div>
                </div>
            <?php 
                }
            } else {
            ?>
                <div class="card" style="padding: 64px 24px; text-align: center;">
                    <div style="width: 64px; height: 64px; background: var(--gray-100); color: var(--gray-400); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                        <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 style="font-size: var(--text-lg); color: var(--gray-900); margin-bottom: 8px;">Nenhuma vaga publicada</h3>
                    <p style="color: var(--gray-500); margin-bottom: 24px;">Você ainda não publicou nenhuma oportunidade de estágio.</p>
                    <a href="Dashboard_Empresa.php#publicar" class="btn btn-primary">Criar Primeira Vaga</a>
                </div>
            <?php
            }
            ?>
        </div>
    </main>
</body>
</html>