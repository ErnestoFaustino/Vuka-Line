<?php
session_start();
include_once '../config/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estudante') {
    header("Location: ../Login.php");
    exit;
}

$estudante_id = $_SESSION['estudante_id'];

// Buscar todas as vagas com os detalhes da empresa
$sql_vagas = "SELECT vagas.*, empresas.nome AS nome_empresa, empresas.descricao AS descricao_empresa 
              FROM vagas 
              INNER JOIN empresas ON vagas.empresa_id = empresas.id
              ORDER BY vagas.id DESC";
$resultado_vagas = $conexao->query($sql_vagas);
?>
<!DOCTYPE html>
<html lang="pt-ao">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorar Vagas - Vuka Line</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/explorar_vagas.css">
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
                    <li><a href="Dashboard_Estudante.php">Meu Painel</a></li>
                    <li><a href="explorar_vags.php" style="color: var(--brand-600); font-weight: 600;">Explorar Vagas</a></li>
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
                <h1>Explorar Oportunidades</h1>
                <p>Encontre o estágio ideal para alavancar a sua carreira em Angola.</p>
            </div>
            <a href="Dashboard_Estudante.php" class="btn btn-secondary">Voltar ao Painel</a>
        </div>

        <?php
        if (isset($_SESSION['mensagem'])) {
            echo '<div class="alert alert-info" style="margin-bottom: 24px;">' . $_SESSION['mensagem'] . '</div>';
            unset($_SESSION['mensagem']);
        }
        ?>

        <div class="grid-vagas">
            <?php 
            if ($resultado_vagas->num_rows > 0) {
                while ($vaga = $resultado_vagas->fetch_assoc()) { 
                    // Verifica se o estudante já se candidatou a esta vaga
                    $sql_verifica = "SELECT * FROM candidaturas WHERE estudante_id = ? AND vaga_id = ?";
                    $stmt_verifica = $conexao->prepare($sql_verifica);
                    $stmt_verifica->bind_param("ii", $estudante_id, $vaga['id']);
                    $stmt_verifica->execute();
                    $resultado_verifica = $stmt_verifica->get_result();
                    $ja_candidatou = $resultado_verifica->num_rows > 0;
            ?>
                <div class="card card-vaga">
                    <div class="card-vaga-header">
                        <div class="empresa-info">
                            <div class="empresa-avatar">
                                <?= substr($vaga['nome_empresa'], 0, 1) ?>
                            </div>
                            <div>
                                <h3><?= $vaga['titulo'] ?></h3>
                                <span><?= $vaga['nome_empresa'] ?></span>
                            </div>
                        </div>
                        <span class="badge badge-success">Nova</span>
                    </div>
                    
                    <div class="card-vaga-body">
                        <p class="vaga-descricao"><?= nl2br($vaga['descricao']) ?></p>
                        
                        <div class="vaga-detalhes">
                            <div class="detalhe-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <?= $vaga['localizacao'] ?>
                            </div>
                            <div class="detalhe-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <?= $vaga['modalidade'] ?>
                            </div>
                            <div class="detalhe-item">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <?= $vaga['salario'] ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-vaga-footer">
                        <?php if ($ja_candidatou) { ?>
                            <button class="btn btn-secondary" style="width: 100%; cursor: not-allowed;" disabled>
                                Candidatura Enviada
                            </button>
                        <?php } else { ?>
                            <form action="candidatar.php" method="POST" style="width: 100%;">
                                <input type="hidden" name="vaga_id" value="<?= $vaga['id'] ?>">
                                <input type="hidden" name="estudante_id" value="<?= $estudante_id ?>">
                                <button type="submit" name="btn-candidatar" class="btn btn-primary" style="width: 100%;">
                                    Candidatar-me
                                </button>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            <?php 
                }
            } else {
                echo '<div class="card" style="grid-column: 1 / -1; padding: 48px 24px; text-align: center;">';
                echo '<p style="color: var(--gray-500); font-size: var(--text-lg);">Nenhuma vaga de estágio disponível no momento.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>
</html>