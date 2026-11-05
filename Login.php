<?php
    session_start();
    include_once 'config/conexao.php'; 
?>
<!DOCTYPE html>
<html lang="pt-ao">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Entrar - Vuka Line</title>
<link rel="stylesheet" href="assets/css/global.css">
<link rel="stylesheet" href="assets/css/Login.css">
</head>
<body>

<main class="tela-split">
    
    <div class="lado-visual">
        <div class="visual-content">
            <h2>Vuka Line</h2>
            <p>Conectando os melhores talentos angolanos às oportunidades certas no mercado de trabalho.</p>
        </div>
    </div>

    <div class="lado-formulario">
        <div class="caixa-login">
            
            <div class="logo-voltar">
                <a href="index.php">
                    <img src="assets/img/IMG-20260513-WA0032.jpg" alt="Vuka Line Logo" class="logo-img">
                </a>
                <h2>Bem-vindo de volta</h2>
                <p class="login-subtitle">Acesse sua conta para continuar</p>
            </div>
            
            <?php
            if(isset($_SESSION['mensagem'])){
                echo '<div class="alert alert-info">' . $_SESSION['mensagem'] . '</div>';
                unset($_SESSION['mensagem']);
            }
            ?>

            <div class="info-login">
                <form class="formulario-vuka" action="src/login.php" method="POST">
                    <input type="hidden" name="id">
                    
                    <div class="field form-group">
                        <label for="email_input">E-mail</label>
                        <input type="email" name="email" id="email_input" placeholder="seu@email.com" required>
                    </div>

                    <div class="field form-group">
                        <label for="senha_input">Senha</label>
                        <input type="password" name="senha" id="senha_input" placeholder="••••••••" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-block" name="btn-entrar">Entrar</button>
                    </div>
                    
                    <p class="link-cadastro">Ainda não tem uma conta? <a href="Cadastrar.php">Cadastre-se</a></p>
                </form>
            </div>
        </div>
    </div>
</main>

</body>
</html>
