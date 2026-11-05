<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();
include_once '../config/conexao.php'; 

if(!isset($_SESSION['id']) || $_SESSION['tipo'] != 'estudante'){
    header("Location: ../Login.php");
    exit;
}

$sql =  "SELECT id, nome, curso, habilidades FROM estudantes WHERE usuario_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i",  $_SESSION['id']);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

$_SESSION['estudante_id'] = $dados['id'];

// Total de vagas disponíveis
$sql_vagas_total = "SELECT COUNT(*) AS total FROM vagas";
$stmt_vt = $conexao->prepare($sql_vagas_total);
$stmt_vt->execute();
$resultado_vt = $stmt_vt->get_result()->fetch_assoc();

// Estatísticas do estudante
$estudante_id = $dados['id'];
$sql_stats = "SELECT 
    (SELECT COUNT(*) FROM candidaturas WHERE estudante_id = ?) as total_cand,
    (SELECT COUNT(*) FROM candidaturas WHERE estudante_id = ? AND status_candidatura = 'aceite') as aceites,
    (SELECT COUNT(*) FROM candidaturas WHERE estudante_id = ? AND status_candidatura = 'rejeitado') as rejeitadas";
$stmt_stats = $conexao->prepare($sql_stats);
$stmt_stats->bind_param("iii", $estudante_id, $estudante_id, $estudante_id);
$stmt_stats->execute();
$stats = $stmt_stats->get_result()->fetch_assoc();

// Lista de candidaturas do estudante
$sql_minhas = "SELECT  c.status_candidatura, c.data_cadidatura, v.titulo, v.modalidade, e.nome as empresa_nome 
            FROM candidaturas c 
            JOIN vagas v ON c.vaga_id = v.id 
            JOIN empresas e ON v.empresa_id = e.id 
            WHERE c.estudante_id = ? ORDER BY c.data_cadidatura DESC";
$stmt_minhas = $conexao->prepare($sql_minhas);
$stmt_minhas->bind_param("i", $estudante_id);
$stmt_minhas->execute();
$minhas_candidaturas = $stmt_minhas->get_result();
?>
<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Painel - Vuka Line</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/Dashboard_Estudante.css">
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">Vuka Line</div>
        <nav>
            <ul>
                <li>
                    <a href="#dashboard" class="active">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="explorar_vags.php">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Explorar Vagas</span>
                    </a>
                </li>
                <li>
                    <a href="#candidaturas">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Candidaturas</span>
                    </a>
                </li>
                <li style="margin-top: auto;">
                    <a href="../logout.php" style="color: var(--danger);">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <main id="dashboard" class="main-content">
        <header class="header">
            <h1>Área do Estudante</h1>
            <div class="user-profile"><?php echo $dados['nome']; ?></div>
        </header>

        <section class="perfil-card card" style="padding: 24px; margin-bottom: 24px; display: flex; justify-content: space-between; align-items: center; border-left: 4px solid var(--brand-600);">
            <div>
                <h2 style="font-size: var(--text-lg); margin-bottom: 4px;">Bem-vindo, <?php echo $dados['nome']; ?>!</h2>
                <p style="color: var(--gray-500); font-size: var(--text-sm);">Curso: <?php echo $dados['curso']; ?> • Habilidades: <?php echo $dados['habilidades']; ?></p>
            </div>
            <div>
                <a href="explorar_vags.php" class="btn btn-primary">Encontrar Estágio</a>
            </div>
        </section>

        <section class="cards-grid">
            <div class="card" style="border-left-color: var(--brand-500);">
                <h3>Total Candidaturas</h3>
                <div class="value"><?php echo $stats['total_cand']; ?></div>
            </div>
            <div class="card" style="border-left-color: var(--success);">
                <h3>Vagas Aprovadas</h3>
                <div class="value"><?php echo $stats['aceites']; ?></div>
            </div>
            <div class="card" style="border-left-color: var(--gray-400);">
                <h3>Oportunidades no Sistema</h3>
                <div class="value"><?php echo $resultado_vt['total']; ?></div>
            </div>
        </section>

        <section id="candidaturas" class="section-container">
            <h2>Meu Histórico de Candidaturas</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Vaga</th>
                            <th>Empresa</th>
                            <th>Modalidade</th>
                            <th>Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($minhas_candidaturas->num_rows > 0) {
                            while ($cand = $minhas_candidaturas->fetch_assoc()) { 
                        ?>
                            <tr>
                                <td style="font-weight: 500; color: var(--gray-900);"><?= $cand['titulo'] ?></td>
                                <td><?= $cand['empresa_nome'] ?></td>
                                <td><?= $cand['modalidade'] ?></td>
                                <td><?= date('d/m/Y', strtotime($cand['data_cadidatura'])) ?></td>
                                <td>
                                    <?php if ($cand['status_candidatura'] == 'pendente') { ?>
                                        <span class="badge badge-warning">Em Análise</span>
                                    <?php } elseif ($cand['status_candidatura'] == 'aceite') { ?>
                                        <span class="badge badge-success">Aprovado</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger">Recusado</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php 
                            } 
                        } else {
                            echo '<tr><td colspan="5" style="text-align: center; padding: 24px; color: var(--gray-500);">Você ainda não se candidatou a nenhuma vaga.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>