<?php
session_start();
include_once '../config/conexao.php'; 

if(!isset($_SESSION['email']) || $_SESSION['tipo'] != 'admin'){
    header("Location: ../Login.php");
    exit;
}

$qtdEstudante= "SELECT COUNT(*) AS totalEstudante FROM estudantes";
$stmtEstudante = $conexao->prepare($qtdEstudante);
$stmtEstudante->execute();
$quantEstudante = $stmtEstudante->get_result()->fetch_assoc();

$qtdEmpresa= "SELECT COUNT(*) AS totalEmpresa FROM empresas";
$stmtEmpresa = $conexao->prepare($qtdEmpresa);
$stmtEmpresa->execute();
$quantEmpresa = $stmtEmpresa->get_result()->fetch_assoc();

$qtdvaga= "SELECT COUNT(*) AS totalvaga FROM vagas";
$stmtvaga = $conexao->prepare($qtdvaga);
$stmtvaga->execute();
$quantvaga = $stmtvaga->get_result()->fetch_assoc();

$sql_estudantes =  "SELECT estudantes.id, estudantes.nome, 
estudantes.curso, estudantes.escola, estudantes.usuario_id, usuarios.email, 
usuarios.criado_em FROM estudantes INNER JOIN usuarios ON estudantes.usuario_id = usuarios.id
ORDER BY estudantes.id DESC";
$stmt_est = $conexao->prepare($sql_estudantes);
$stmt_est->execute();
$resultado_estudantes = $stmt_est->get_result();

$sql_empresas = "SELECT empresas.id, empresas.usuario_id, empresas.nome, 
empresas.descricao, usuarios.email, 
usuarios.criado_em FROM empresas INNER JOIN usuarios ON empresas.usuario_id = usuarios.id
ORDER BY empresas.id DESC";
$stmt_emp = $conexao->prepare($sql_empresas);
$stmt_emp->execute();
$resultado_empresas = $stmt_emp->get_result();
?>
<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrador - Vuka Line</title>
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/Dashboard_Admin.css">
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
                    <a href="#estudantes">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        <span>Estudantes</span>
                    </a>
                </li>
                <li>
                    <a href="#empresas">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Empresas</span>
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
            <h1>Visão Geral do Sistema</h1>
            <div class="user-profile">Administrador Central</div>
        </header>

        <section class="cards-grid">
            <div class="card" style="border-left-color: var(--brand-500);">
                <h3>Total Estudantes</h3>
                <div class="value"><?php echo $quantEstudante['totalEstudante'];?></div>
            </div>
            <div class="card" style="border-left-color: var(--success);">
                <h3>Total Empresas</h3>
                <div class="value"><?php echo $quantEmpresa['totalEmpresa'];?></div>
            </div>
            <div class="card" style="border-left-color: var(--warning);">
                <h3>Vagas Ativas</h3>
                <div class="value"><?php echo $quantvaga['totalvaga'];?></div>
            </div>
        </section>

        <section id="estudantes" class="section-container">
            <h2>Gestão de Estudantes</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Curso</th>
                            <th>Instituição</th>
                            <th>Status</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($dados = $resultado_estudantes->fetch_assoc()) { ?>
                        <tr>
                            <td>#<?php echo $dados['id']; ?></td>
                            <td style="font-weight: 500; color: var(--gray-900);"><?php echo $dados['nome']; ?></td>
                            <td><?php echo $dados['email']; ?></td>
                            <td><?php echo $dados['curso']; ?></td>
                            <td><?php echo $dados['escola']; ?></td>
                            <td><span class="badge badge-info">Ativo</span></td>
                            <td><?= date('d/m/Y', strtotime($dados['criado_em']))?></td>
                            <td>
                                <div class="grupo-botoes">
                                    <a href="src/apagar_usuarios.php?usuario_id=<?php echo $dados['usuario_id']; ?>" class="botao-dashboard botao-remover" onclick="return confirm('Tem certeza que deseja remover este estudante?')">Excluir</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section id="empresas" class="section-container">
            <h2>Gestão de Empresas</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empresa</th>
                            <th>Email Corporativo</th>
                            <th>Descrição</th>
                            <th>Status</th>
                            <th>Data Cadastro</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($dados = $resultado_empresas->fetch_assoc()) { ?>
                        <tr>
                            <td>#<?php echo $dados['id']; ?></td>
                            <td style="font-weight: 500; color: var(--gray-900);"><?php echo $dados['nome']; ?></td>
                            <td><?php echo $dados['email']; ?></td>
                            <td><span style="display: inline-block; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?php echo $dados['descricao']; ?></span></td>
                            <td><span class="badge badge-success">Aprovada</span></td>
                            <td><?= date('d/m/Y', strtotime($dados['criado_em']))?></td>
                            <td>
                                <div class="grupo-botoes">
                                    <a href="src/apagar_empresas.php?usuario_id=<?php echo $dados['usuario_id']; ?>" class="botao-dashboard botao-remover" onclick="return confirm('Tem certeza que deseja remover esta empresa?')">Excluir</a>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
