<?php
session_start();

$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$nomeUsuario = $estaLogado ? htmlspecialchars($_SESSION['nome_usuario']) : '';
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - AdaCode</title>
    <link rel="stylesheet" href="feedback.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<header class="navbar">
        <div class="lado-esquerdo">
            <a href="home.php"><img src="img/logotopo.png" alt="AdaCode Logo"></a>
        </div>
        <div class="lado-direito">
            <button id="botao-menu" class="menu-botao">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <?php if ($estaLogado): ?>
        <aside id="menu-logado" class="menu-lateral">
            <div class="conteudo-menu">
                <button class="close-btn" onclick="fecharMenu('menu-logado')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="perfil">
                    <a href="perfil.php"><i class="bi bi-person-circle"></i></a>
                    <span><?php echo $nomeUsuario; ?></span>
                </div>
                <nav>
                    <ul>
                        <li><a href="home.php">Início</a></li>
                        <li><a href="forum.php">Fórum</a></li>
                        <li><a href="cursosgeral.php">Cursos</a></li>
                        <li><a href="eventos.php">Eventos</a></li>
                    </ul>
                </nav>
                <button class="botao-entrar" onclick="window.location.href='logout.php'">Sair</button>
            </div>
        </aside>

    <?php else: ?>

        <aside id="menu-deslogado" class="menu-lateral">
            <div class="conteudo-menu">
                <button class="close-btn" onclick="fecharMenu('menu-deslogado')"><i class="fas fa-times"></i></button>
                <nav>
                    <ul>
                        <li><a href="home.php">Início</a></li>
                        <li><a href="forum.php">Fórum</a></li>
                        <li><a href="cursosgeral.php">Cursos</a></li>
                        <li><a href="eventos.php">Eventos</a></li>
                        <li><a href="cadastro.html" class="cadastrar">Cadastrar</a></li>
                    </ul>
                </nav>
                <button class="botao-entrar" onclick="window.location.href='login.html'">Entrar</button>
            </div>
        </aside>
    <?php endif; ?>
    

    <main class="conteudo-principal">
        <section class="feedback-container">
            <h2>Feedback</h2>
            
            <form action="insert_feedback.php" method="POST" class="formulario-feedback">
                
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
                
                <input type="email" id="email" name="email" placeholder="E-mail" required>
                
                <textarea id="feedback" name="feedback" placeholder="Feedback" rows="8" required></textarea>
                
                 <button type="submit" class="botao-enviar-feedback">Enviar</button>
            </form>
        </section>
    </main>

    <footer class="rodape">
        <ul>
            <li><i class="fas fa-envelope"></i> E-mail</li>
            <a href="https://www.instagram.com/projeto.adacode?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
                <li><i class="bi bi-instagram"></i></i> Instagram</li>
            </a>
            <li><i class="fab fa-linkedin"></i> LinkedIn</li>
            <li><i class="bi bi-chat-left"></i></i> Feedback</li>
            <li><i class="bi bi-exclamation-circle"></i></i> Dúvidas Frequentes</li>
        </ul>
    </footer>

    <script src="menu.js"></script>

</body>
</html>