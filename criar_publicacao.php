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
    <title>Nova Publicação - AdaCode</title>
    <link rel="stylesheet" href="criar_publicacao.css">
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
        <section class="publicacao-container">
            <h2>Criar Publicação</h2>

            <form action="insert_publicacao.php" method="POST" class="formulario-publicacao">

                <input type="text" id="titulo" name="titulo" placeholder="Título" required>

                <textarea type="text" rows="7" id="texto" name="conteudo" placeholder="Digite o conteúdo da sua publicação" required></textarea>

                <div class="upload-area">
                        <label for="capa_upload">Upload de Imagem</label>
                        <input type="file" id="capa_upload" name="urlimg" accept="image/*" style="display:none;">
                    </div>

                <button type="submit" class="botao-publicar">Enviar</button>
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