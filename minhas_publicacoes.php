<?php
session_start(); 

include 'conexao.php'; 

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$id_usuario_logado = $_SESSION['user_id'];
$nomeUsuario = htmlspecialchars($_SESSION['nome_usuario'] ?? 'Usuário'); // Pega o nome para exibir
$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

$sql = "
    SELECT 
        p.id_publicacao, 
        p.titulo, 
        p.conteudo, 
        p.url_img, 
        u.username
    FROM 
        tb_publicacao p
    INNER JOIN 
        tb_user u 
        ON p.fk_id_usuario = u.id_user
    WHERE 
        p.fk_id_usuario = ? 
    ORDER BY 
        p.id_publicacao DESC
"; 

$prepare = $conexao->prepare($sql);

if (!$prepare) {
    die("Erro na preparação do SQL: " . $conexao->error);
}

$prepare->bind_param('i', $id_usuario_logado); 
$prepare->execute();
$result = $prepare->get_result();

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Publicações - AdaCode</title>
    <link rel="stylesheet" href="minhas_publicacoes.css"> <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
                    <h1 id="titulo">Minhas Publicações</h1>
                    <h2 id="descricao-titulo">Todas as suas publicações antigas em um só lugar e um espaço para criar novas</h2>
                </div>
            </div>
        </section>
        
        <section class="area-publicacoes">
            
            <a href="criar_publicacao.php" class="botao-nova-publicacao">
                <i class="fas fa-plus-circle"></i> Criar Nova Publicação
            </a>
            
            <?php 
            if ($result && $result->num_rows > 0):
                while($post = $result->fetch_assoc()):
                    $imagem_nome = !empty($post['url_img']) ? trim($post['url_img']) : ''; 
            ?>
            <div class="post-card">
                <div class="cabecalho-do-post">
                    <div class="lado-esquerdo-post">
                        <i class="bi bi-person-circle avatar-icone"></i> 
                        <p class="nome-usuario"><?php echo htmlspecialchars($post['username']); ?></p>
                    </div>

                    <div class="icones-do-post">
                        <a href="editar_publicacao.php?id=<?php echo $post['id_publicacao']; ?>" title="Editar"><i class="fas fa-edit"></i></a>
                        <a href="#" title="Excluir"><i class="fas fa-trash-alt"></i></a> 
                        <i class="fas fa-info-circle"></i>
                    </div>
                </div>

                <p class="titulo-post">
                    <strong><?php echo htmlspecialchars($post['titulo']); ?></strong>
                </p>

                <div class="post-conteudo">
                    <p>
                        <?php 
                            echo (htmlspecialchars($post['conteudo'])); 
                        ?>
                    </p>
                    
                    <?php if (!empty($imagem_nome)): ?>
                    <div class="midia-placeholder">
                        <img src="img/<?php echo $imagem_nome; ?>" alt="Imagem da publicação" class="bloco-midia-img">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php 
                endwhile;
            else:
            ?>
            <div class="post-card no-posts">
                <p>Você ainda não tem publicações. Clique em "Criar Nova Publicação" para começar!</p>
            </div>
            <?php
            endif;
            $prepare->close();
            $conexao->close();
            ?>
        </section>
    </main>
    
    <script src="menu.js"></script>
</body>
</html>