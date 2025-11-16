<?php
session_start();

// INCLUSÃO DA CONEXÃO
include 'conexao.php';
$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$nomeUsuario = $estaLogado ? htmlspecialchars($_SESSION['nome_usuario']) : '';

// LÓGICA DE BUSCA DOS POSTS
$sql = "SELECT p.titulo, p.conteudo, p.url_img, u.username 
        FROM tb_publicacao p
        INNER JOIN tb_user u ON p.fk_id_usuario = u.id_user
        ORDER BY p.id_publicacao DESC";

$result = $conexao->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fórum - AdaCode</title>
    <link rel="stylesheet" href="forum.css">
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
        <section class="introducao">
            <div class="imagem-principal">
                <img class="pinturadeitada" src="img/pinturadeitada.png" alt="Pintura">
                <div class="titulo-pagina">
                    <h1 id="titulo">Fórum</h1>
                    <h2 id="descricao-titulo">Um fórum para compartilhar suas experiências na Área de Tecnologia</h2>
                </div>
            </div>
        </section>

        <section class="conteudo-forum">
            <div class="bemvindo-busca">
                <p class="bemvindo">
                    <strong>
                        Bem-vindo de volta,
                        <?php echo $estaLogado ? $nomeUsuario . '!' : 'Visitante!'; ?>
                    </strong>
                </p>
                <?php if ($estaLogado): ?>
                    <a href="criar_publicacao.php" class="botao-nova-publicacao">
                        <i class="fas fa-plus"></i> Publicar
                    </a>
                <?php else: ?>
                    <a href="login.html" class="botao-nova-publicacao deslogado">
                        Login para Publicar
                    </a>
                <?php endif; ?>
            </div>

            <?php
            if ($result && $result->num_rows > 0):
                while ($post = $result->fetch_assoc()):
                    $midias = !empty($post['url_img']) ? explode(',', $post['url_img']) : [];
                    $temMidia = count($midias) > 0;
            ?>
                    <div class="post-card">
                        <div class="cabecalho-do-post">
                            <div class="lado-esquerdo-post">
                                <i class="bi bi-person-circle avatar-icone"></i>
                                <p class="nome-usuario"><?php echo htmlspecialchars($post['username']); ?></p>
                            </div>

                            <div class="icones-do-post">
                                <i class="fas fa-comment"></i>
                                <i class="fas fa-info-circle"></i>
                            </div>
                        </div>

                        <p class="titulo-post">
                            <strong><?php echo htmlspecialchars($post['titulo']); ?></strong>
                        </p>

                        <div class="post-conteudo">
                            <p>
                                <?php
                                echo nl2br(htmlspecialchars($post['conteudo']));
                                ?>
                            </p>

                            <?php if ($temMidia): ?>
                                <div class="midia-placeholder">
                                    <?php foreach ($midias as $midia): ?>
                                        <img src="img/uploads/<?php echo htmlspecialchars(trim($midia)); ?>" alt="Imagem da publicação" class="bloco-midia-img">
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php
                endwhile;
            else:
                ?>
                <div class="post-card">
                    <p style="text-align: center; color: #555;">Nenhuma publicação encontrada no momento.</p>
                </div>
            <?php
            endif;
            $conexao->close();
            ?>
        </section>
    </main>

    <footer class="rodape">
        <ul>
            <li><i class="fas fa-envelope"></i> E-mail</li>
            <li><i class="bi bi-instagram"></i></i> Instagram</li>
            <li><i class="fab fa-linkedin"></i> LinkedIn</li>
            <li><i class="bi bi-chat-left"></i></i> Feedback</li>
            <li><i class="bi bi-exclamation-circle"></i></i> Dúvidas Frequentes</li>
        </ul>
    </footer>

    <script src="menu.js"></script>
</body>

</html>