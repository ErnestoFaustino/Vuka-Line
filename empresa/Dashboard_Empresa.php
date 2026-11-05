<?php
session_start();
include_once '../config/conexao.php';

if (!isset($_SESSION['id']) || $_SESSION['tipo'] != 'empresa') {
    header("Location: ../Login.php");
    exit;
}

$sql =  "SELECT id, nome FROM empresas WHERE usuario_id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i",  $_SESSION['id']);
$stmt->execute();
$resultado = $stmt->get_result();
$dados = $resultado->fetch_assoc();

$_SESSION['empresa_id'] = $dados['id'];
$empresa_id = $dados['id'];
$usuario_id = $_SESSION['id'];

// BUSCAR CANDIDATOS DAS VAGAS DA EMPRESA
$sql_candidatos = "SELECT candidaturas.id, candidaturas.status_candidatura, vagas.titulo, vagas.modalidade, 
estudantes.nome, estudantes.escola, estudantes.curso FROM candidaturas
INNER JOIN vagas ON candidaturas.vaga_id = vagas.id INNER JOIN estudantes
ON candidaturas.estudante_id = estudantes.id WHERE vagas.empresa_id = ? AND candidaturas.visivel_empresa = 1 ORDER BY candidaturas.id DESC";

$stmt_cand = $conexao->prepare($sql_candidatos);
$stmt_cand->bind_param("i", $empresa_id);
$stmt_cand->execute();
$resultado_candidatos = $stmt_cand->get_result();

// BUSCAR VAGAS DA EMPRESA
$sql_vagas =  "SELECT * FROM vagas WHERE empresa_id = ? ORDER BY id DESC LIMIT 5";
$stmt_vagas = $conexao->prepare($sql_vagas);
$stmt_vagas->bind_param("i", $empresa_id);
$stmt_vagas->execute();
$resultado_vagas = $stmt_vagas->get_result();
?>

<!DOCTYPE html>
<html lang="pt-ao">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel da Empresa - Vuka Line</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/Dashboard_Empresa.css">
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
                    <a href="#publicar">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Publicar Vaga</span>
                    </a>
                </li>
                <li>
                    <a href="Vagas_Postadas.php">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>Vagas Postadas</span>
                    </a>
                </li>
                <li>
                    <a href="#candidatos">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <span>Candidatos</span>
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
            <h1>Painel da Empresa</h1>
            <div class="user-profile"><?php echo $dados['nome']; ?></div>
        </header>

        <?php
        if (isset($_SESSION['mensagem'])) {
            echo '<div style="margin-bottom: 24px; padding: 12px 16px; background: var(--success-bg); color: var(--success-text); border-radius: var(--radius-md); border: 1px solid #a7f3d0;">' . $_SESSION['mensagem'] . '</div>';
            unset($_SESSION['mensagem']);
        }
        ?>

        <section id="publicar" class="section-container">
            <h2>Publicar Nova Vaga de Estágio</h2>
            <form action="src/publicar_vagas.php" method="POST" class="formulario-empresa">
                <div class="field form-group">
                    <label>Título da Oportunidade</label>
                    <input type="text" name="titulo" placeholder="Ex: Estagiário de Contabilidade ou Programador Júnior" required>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
                    <div class="field form-group">
                        <label>Modalidade</label>
                        <select name="modalidade" required>
                            <option value="" disabled selected>Selecione...</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Híbrido">Híbrido</option>
                            <option value="Remoto">Remoto</option>
                        </select>
                    </div>
                    <div class="field form-group">
                        <label>Localização</label>
                        <input type="text" name="localizacao" placeholder="Ex: Luanda, Talatona" required>
                    </div>
                    <div class="field form-group">
                        <label>Remuneração / Subsídio</label>
                        <input type="text" name="salario" placeholder="Ex: 50.000 KZ ou Não Remunerado" required>
                    </div>
                </div>
                <div class="field form-group">
                    <label>Descrição da Vaga e Requisitos</label>
                    <textarea rows="4" name="descricao" placeholder="Detalhe as responsabilidades, requisitos técnicos e comportamentais da vaga..." required></textarea>
                </div>
                <div style="margin-top: 16px;">
                    <button type="submit" name="publicar-vagas" class="btn btn-primary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 8px; display: inline-block; vertical-align: middle;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Publicar Vaga
                    </button>
                </div>
            </form>
        </section>

        <section id="candidatos" class="section-container">
            <h2>Gestão de Candidaturas</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Vaga Referente</th>
                            <th>Modalidade</th>
                            <th>Candidato</th>
                            <th>Formação</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($resultado_candidatos->num_rows > 0) {
                            while ($cand = $resultado_candidatos->fetch_assoc()) { 
                        ?>
                            <tr>
                                <td style="font-weight: 500; color: var(--gray-900);"><?= $cand['titulo'] ?></td>
                                <td><?= $cand['modalidade'] ?></td>
                                <td><?= $cand['nome'] ?></td>
                                <td><?= $cand['escola'] ?> - <?= $cand['curso'] ?></td>
                                <td>
                                    <?php if ($cand['status_candidatura'] == 'pendente') { ?>
                                        <span class="badge badge-warning">Em Revisão</span>
                                    <?php } elseif ($cand['status_candidatura'] == 'aceite') { ?>
                                        <span class="badge badge-success">Aprovado</span>
                                    <?php } else { ?>
                                        <span class="badge badge-danger">Rejeitado</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if ($cand['status_candidatura'] == 'pendente') { ?>
                                    <div class="grupo-botoes">
                                        <a href="src/aceitar_candidato.php?id=<?= $cand['id'] ?>" class="botao-dashboard botao-aceitar">Aceitar</a>
                                        <a href="src/rejeitar_candidato.php?id=<?= $cand['id'] ?>" class="botao-dashboard botao-remover">Recusar</a>
                                    </div>
                                    <?php } else { ?>
                                        <span style="color: var(--gray-400); font-size: var(--text-xs);">Ação concluída</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php 
                            } 
                        } else {
                            echo '<tr><td colspan="6" style="text-align: center; padding: 24px; color: var(--gray-500);">Nenhum candidato no momento.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="section-container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                <h2 style="margin: 0;">Vagas Recentes</h2>
                <a href="Vagas_Postadas.php" class="btn btn-secondary" style="font-size: var(--text-xs); padding: 6px 12px;">Ver Todas</a>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Modalidade</th>
                            <th>Localização</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($resultado_vagas->num_rows > 0) {
                            while ($vaga = $resultado_vagas->fetch_assoc()) { 
                        ?>
                            <tr>
                                <td style="font-weight: 500; color: var(--gray-900);"><?php echo $vaga['titulo'] ?></td>
                                <td><?php echo $vaga['modalidade'] ?></td>
                                <td><?php echo $vaga['localizacao'] ?></td>
                                <td><span class="badge badge-success">Ativa</span></td>
                                <td>
                                    <div class="grupo-botoes">
                                        <a href="src/apagar_vagas.php?vaga_id=<?php echo $vaga['id']; ?>" class="botao-dashboard botao-remover" /*onclick="return confirm('Tem certeza que deseja fechar esta vaga?')"*/>Fechar Vaga</a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            } 
                        } else {
                            echo '<tr><td colspan="5" style="text-align: center; padding: 24px; color: var(--gray-500);">Você ainda não publicou nenhuma vaga.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>