<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos - Vuka Line</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/Contactos.css">
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
                    <li><a href="index.php">Início</a></li>
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

    <main class="pagina-contato">
        <section class="banner-contato">
            <div class="container">
                <h1>Entre em Contato</h1>
                <p>Tem alguma dúvida ou sugestão? Nossa equipa está pronta para ajudar.</p>
            </div>
        </section>

        <section class="secao-contato-form">
            <div class="container grade-contato">
                
                <div class="infos-suporte">
                    <div class="cartao-info">
                        <div class="icone-contato">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4>E-mail</h4>
                            <p>contato@vukaline.ao</p>
                            <p>suporte@vukaline.ao</p>
                        </div>
                    </div>
                    <div class="cartao-info">
                        <div class="icone-contato">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        </div>
                        <div>
                            <h4>Telefone</h4>
                            <p>+244 923 456 789</p>
                            <p>+244 222 123 456</p>
                        </div>
                    </div>
                    <div class="cartao-info">
                        <div class="icone-contato">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h4>Endereço</h4>
                            <p>Rua da Missão, 123</p>
                            <p>Luanda, Angola</p>
                        </div>
                    </div>
                </div>

                <div class="caixa-mensagem card">
                    <h3>Envie sua Mensagem</h3>
                    <form class="formulario-contato" action="#" method="POST" onsubmit="event.preventDefault(); alert('Mensagem enviada com sucesso!');">
                        <div class="linha-dupla">
                            <div class="field">
                                <label>Nome Completo</label>
                                <input type="text" placeholder="Seu nome" required>
                            </div>
                            <div class="field">
                                <label>E-mail</label>
                                <input type="email" placeholder="seu@email.com" required>
                            </div>
                        </div>
                        <div class="field" style="margin-top: 16px;">
                            <label>Assunto</label>
                            <input type="text" placeholder="Sobre o que quer falar?" required>
                        </div>
                        <div class="field" style="margin-top: 16px;">
                            <label>Mensagem</label>
                            <textarea placeholder="Escreva sua mensagem aqui..." rows="5" required></textarea>
                        </div>
                        <div style="margin-top: 24px;">
                            <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="secao-faq">
            <div class="container">
                <div class="cabecalho-secao">
                    <h2>Perguntas Frequentes</h2>
                    <p>Encontre respostas rápidas para as dúvidas mais comuns.</p>
                </div>

                <div class="lista-faq">
                    <div class="item-faq card">
                        <h4>Como me cadastro como estudante?</h4>
                        <p>Basta clicar em "Cadastrar" no menu superior, selecionar a opção "Sou Estudante" e preencher o formulário.</p>
                    </div>
                    <div class="item-faq card">
                        <h4>A minha empresa precisa ser aprovada?</h4>
                        <p>Sim. Todas as empresas passam por uma verificação simples para garantir a qualidade e veracidade das vagas publicadas.</p>
                    </div>
                    <div class="item-faq card">
                        <h4>O serviço é pago?</h4>
                        <p>A Vuka Line é 100% gratuita para estudantes. Para empresas, oferecemos planos diferenciados após um período de teste.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
                    <li><a href="index.php">Início</a></li>
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
