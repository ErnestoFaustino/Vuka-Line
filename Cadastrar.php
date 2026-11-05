<?php
    session_start();
    include_once 'config/conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-ao">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Vuka Line</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/Cadastro.css">
</head>
<body>

    <main class="tela-cadastro">
        <div class="container-pequeno">
            
            <div class="logo-voltar">
                <a href="index.php">
                    <img src="assets/img/IMG-20260513-WA0032.jpg" alt="Vuka Line Logo" class="logo-img">
                </a>
            </div>

            <div class="caixa-cadastro">
                <div class="cabecalho-form">
                    <h2>Criar nova conta</h2>
                    <p class="subtitle">Junte-se à Vuka Line e comece a sua jornada.</p>
                </div>

                <?php
                if(isset($_SESSION['mensagem'])){
                    echo '<div class="alert alert-info">' . $_SESSION['mensagem'] . '</div>';
                    unset($_SESSION['mensagem']);
                }
                ?>

                <input type="radio" name="tipo-cadastro" id="cadastro-estudante" class="controle-cadastro" checked>
                <input type="radio" name="tipo-cadastro" id="cadastro-empresa" class="controle-cadastro">

                <div class="alternador-perfil">
                    <label for="cadastro-estudante" class="aba-botao aba-estudante">Sou Estudante</label>
                    <label for="cadastro-empresa" class="aba-botao aba-empresa">Sou Empresa</label>
                </div>

                <!-- Cadastro Estudante -->
                <section class="form-container form-estudante">
                    <form class="formulario-vuka" action="src/cadastro_estudante.php" method="POST">
                        <input type="hidden" name="id">
                        
                        <div class="field form-group">
                            <label>Nome Completo</label>
                            <input type="text" name="nome" placeholder="Seu nome completo" required>
                        </div>
                        
                        <div class="field form-group">
                            <label>E-mail</label>
                            <input type="email" name="email" placeholder="seu@email.com" required>
                        </div>
                        
                        <div class="field form-group">
                            <label>Habilidades (separadas por vírgula)</label>
                            <input type="text" name="habilidades" placeholder="Ex: PHP, JavaScript, Design" required>
                        </div>
                        
                        <div class="linha-dupla">
                            <div class="field form-group">
                                <label>Curso</label>
                                <select name="tipo_curso" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option>Técnico Informática</option>
                                    <option>Contabilidade</option>
                                    <option>Gestão Empresarial</option>
                                </select>
                            </div>
                            <div class="field form-group">
                                <label>Instituição de Ensino</label>
                                <select name="tipo_escola" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <option>IPIL</option>
                                    <option>Elsa Mina</option>
                                    <option>IMEL</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="field form-group">
                            <label>Senha</label>
                            <input type="password" name="senha" placeholder="Mínimo de 8 caracteres" required minlength="8">
                        </div>
            
                        <div class="termos">
                            <input type="checkbox" id="aceito-est" required>
                            <label for="aceito-est">Li e aceito os Termos de Uso e Política de Privacidade</label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-block" name="btn-cadastrar">Criar Conta Estudante</button>
                        </div>
                    </form>
                </section>

                <!-- Cadastro Empresa -->
                <section class="form-container form-empresa">
                    <form class="formulario-vuka" action="src/cadastro_empresa.php" method="POST">
                        <?php $_SESSION['tipo'] = "empresa" ?>
                        
                        <div class="field form-group">
                            <label>Nome da Empresa</label>
                            <input type="text" name="nome" placeholder="Nome oficial da empresa" required>
                        </div>
                        
                        <div class="field form-group">
                            <label>E-mail Corporativo</label>
                            <input type="email" name="email" placeholder="rh@empresa.co.ao" required>
                        </div>
                        
                        <div class="field form-group">
                            <label>Descrição Curta</label>
                            <textarea rows="3" name="descricao" placeholder="Sobre a empresa, área de atuação..."></textarea>
                        </div>
                        
                        <div class="field form-group">
                            <label>Senha</label>
                            <input type="password" name="senha" placeholder="Mínimo de 8 caracteres" required minlength="8">
                        </div>
                        
                        <div class="termos">
                            <input type="checkbox" id="aceito-emp" required>
                            <label for="aceito-emp">Aceitamos os Termos de Parceria e Condições</label>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-block" name="btn-cadastrar">Cadastrar Empresa</button>
                        </div>
                    </form>
                </section>

                <p class="link-login">Já tem uma conta? <a href="Login.php">Fazer login</a></p>
            </div>
        </div>
    </main>

</body>
</html>
