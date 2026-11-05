<?php 
session_start();
include_once 'config/conexao.php'; 

$qtdEstudante= "SELECT COUNT(*) AS totalEstudante FROM estudantes";
$stmtEstudante = $conexao->prepare($qtdEstudante);
$stmtEstudante->execute();
$result = $stmtEstudante->get_result();
$quantEstudante = $result->fetch_assoc();

$qtdEmpresa= "SELECT COUNT(*) AS totalEmpresa FROM empresas";
$stmtEmpresa = $conexao->prepare($qtdEmpresa);
$stmtEmpresa->execute();
$result = $stmtEmpresa->get_result();
$quantEmpresa = $result->fetch_assoc();

$qtdcandidatura= "SELECT COUNT(*) AS totalcandidatura FROM candidaturas";
$stmtcandidatura = $conexao->prepare($qtdcandidatura);
$stmtcandidatura->execute();
$result = $stmtcandidatura->get_result();
$quantcandidatura = $result->fetch_assoc();

$qtdvaga= "SELECT COUNT(*) AS totalvaga FROM vagas";
$stmtvaga = $conexao->prepare($qtdvaga);
$stmtvaga->execute();
$result = $stmtvaga->get_result();
$quantvaga = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vuka Line | Conectando Talentos a Oportunidades</title>
    <link rel="shortcut icon" href="assets/img/IMG-20260513-WA0032.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/Tela_Principal.css">
</head>
<body>

    <header class="cabecalho">
        <div class="container-cabecalho">
            <div class="logotipo">
                <img src="assets/img/IMG-20260513-WA0032.jpg" alt="Vuka Line Logo">
                <span>Vuka Line</span>
            </div>

            <nav class="menu-navegacao">
                <ul>
                    <li><a href="#inicio">Início</a></li>
                    <li><a href="Sobre_Empresa.php">Sobre</a></li>
                    <li><a href="Contactos.php">Contato</a></li>
                </ul>
            </nav>

            <div class="botoes-acesso">
                <a href="Login.php" class="botao-entrar">Entrar</a>
                <a href="Cadastrar.php" class="botao-cadastrar">Cadastrar</a>
            </div>
        </div>
    </header>

<section class="secao-hero" id="inicio">
    <div class="container container-hero">
        
        <div class="hero-conteudo">
            <h1>Encontre o <span>estágio ideal</span> para a sua carreira</h1>
            <p>Conectamos estudantes talentosos às melhores oportunidades de estágio em Angola. Comece a construir o seu futuro com a Vuka Line.</p>
            
            <div class="hero-botoes">
                <a href="estudante/Dashboard_Estudante.php" class="btn btn-primary">Explorar Vagas</a>
                <a href="Cadastrar.php" class="btn btn-secondary">Criar Conta</a>
            </div>
        </div>

        <div class="hero-estatisticas">
            <div class="cartao-status">
                <span class="numero"><?php echo $quantvaga['totalvaga'];?></span>
                <span class="rotulo">Vagas Abertas</span>
            </div>
            <div class="cartao-status">
                <span class="numero"><?php echo $quantEmpresa['totalEmpresa'];?></span>
                <span class="rotulo">Empresas Parceiras</span>
            </div>
            <div class="cartao-status">
                <span class="numero"><?php echo $quantEstudante['totalEstudante'];?></span>
                <span class="rotulo">Estudantes</span>
            </div>
            <div class="cartao-status">
                <span class="numero"><?php echo $quantcandidatura['totalcandidatura'];?></span>
                <span class="rotulo">Candidaturas</span>
            </div>
        </div>

    </div>
</section>

<section class="secao-passos">
    <div class="container">
        
        <div class="cabecalho-secao">
            <h2>Como Funciona</h2>
            <p>Um processo direto e transparente para conectar você ao mercado de trabalho.</p>
        </div>

        <div class="grade-passos">
            <div class="cartao-passo">
                <div class="icone-circulo">1</div>
                <h3>Crie seu Perfil</h3>
                <p>Cadastre-se gratuitamente, adicione suas habilidades e informações acadêmicas.</p>
            </div>

            <div class="cartao-passo">
                <div class="icone-circulo">2</div>
                <h3>Explore Vagas</h3>
                <p>Acesse oportunidades nas melhores empresas e filtre de acordo com o seu perfil.</p>
            </div>

            <div class="cartao-passo">
                <div class="icone-circulo">3</div>
                <h3>Candidate-se</h3>
                <p>Envie sua candidatura de forma simplificada e acompanhe o status em tempo real.</p>
            </div>
        </div>

    </div>
</section>

<section class="secao-chamada">
    <div class="container container-chamada">
        <h2>Pronto para começar a sua jornada?</h2>
        <p>Junte-se a milhares de estudantes que já encontraram oportunidades através da plataforma.</p>
        
        <div class="botoes-chamada">
            <a href="Cadastrar.php#cadastro-estudante" class="btn btn-primary">
                Sou Estudante
            </a>
            <a href="Cadastrar.php#cadastro-empresa" class="btn btn-secondary">
                Sou Empresa
            </a>
        </div>
    </div>
</section>

<footer class="rodape">
    <div class="container-rodape">
        
        <div class="coluna-rodape">
            <div class="logotipo-rodape">
                <span>Vuka Line</span>
            </div>
            <p class="descricao-empresa">
                Plataforma de recrutamento focada em conectar estudantes talentosos a oportunidades de estágio em Angola.
            </p>
        </div>

        <div class="coluna-rodape">
            <h4>Navegação</h4>
            <ul>
                <li><a href="#inicio">Início</a></li>
                <li><a href="Sobre_Empresa.php">Sobre Nós</a></li>
                <li><a href="Contactos.php">Contato</a></li>
            </ul>
        </div>

        <div class="coluna-rodape">
            <h4>Empresas</h4>
            <ul>
                <li><a href="Cadastrar.php#cadastro-empresa">Cadastrar Empresa</a></li>
                <li><a href="empresa/Dashboard_Empresa.php">Acesso ao Painel</a></li>
            </ul>
        </div>

        <div class="coluna-rodape">
            <h4>Estudantes</h4>
            <ul>
                <li><a href="Cadastrar.php">Criar Conta</a></li>
                <li><a href="estudante/Dashboard_Estudante.php">Área do Estudante</a></li>
            </ul>
        </div>

    </div>

    <div class="direitos-autorais">
        <p>&copy; <?php echo date('Y'); ?> Vuka Line. Todos os direitos reservados.</p>
    </div>
</footer>

</body>
</html>
