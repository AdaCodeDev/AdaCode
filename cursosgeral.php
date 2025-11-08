<?php
session_start(); 

$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$nomeUsuario = $estaLogado ? htmlspecialchars($_SESSION['nome_usuario']) : ''; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - AdaCode</title>
    <link rel="stylesheet" href="cursosgeral.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
     <header class="navbar">
        <div class="lado-esquerdo">
            <img src="img/logotopo.png" alt="AdaCode Logo">
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
                <i class="bi bi-person-circle"></i>
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
                    <h2 id="titulo">Cursos</h2>
                    <h3 id="descricao-titulo">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Maecenas  sodales aliquam ultrices. Curabitur arcu turpis, fermentum id convallis  et, laoreet eget dolor.
                    </h3>
                </div>
            </div>
        </section>
        
        <section class="filtros">
        <button class="filtro-botao">
            Faixa de preço <i class="fas fa-chevron-down"></i>
        </button>
        <button class="filtro-botao">
            Dificuldade <i class="fas fa-chevron-down"></i>
        </button>
        <button class="filtro-botao filtro-principal">
            Filtro <i class="fas fa-filter"></i>
        </button>
        </section>

        <section class="listagem-cursos">
<?php
include 'conexao.php'; 

$select = "SELECT id_curso, nm_curso, ds_curso, url_img, vl_curso FROM tb_curso ORDER BY nm_curso ASC";
$resultado = $conexao->query($select);

if ($resultado && $resultado->num_rows > 0) {
    while ($curso = $resultado->fetch_assoc()) {
        
        $id_curso = $curso['id_curso'];
        $titulo_curso = htmlspecialchars($curso['nm_curso']);
        $descricao_curso = htmlspecialchars($curso['ds_curso']);
        $imagem_url = htmlspecialchars($curso['url_img']);
        $preco_formatado = 'R$ ' . number_format($curso['vl_curso'], 2, ',', '.'); 

        echo <<<HTML
<a href="cursoespecifico.php?id={$id_curso}" style="text-decoration: none; color: inherit;">
    <div class="card-curso">
        <div class="primeiro-curso">
            <img class="imagem-curso" src="{$imagem_url}" alt="Imagem do Curso: {$titulo_curso}">
            </div>
    </div>
</a>
                <h4 class="titulo-card">{$titulo_curso}</h4>
                <p class="preco-card">{$preco_formatado}</p>
                
                <p class="descricao-curso">
                    {$descricao_curso}
                </p>
                
                <div class="icones">
                    <i class="fas fa-heart"></i>
                    <i class="fas fa-share-alt"></i>
                </div>
            </div>
        </div>
HTML;
    }
} else {
    echo '<p style="text-align:center; margin-top: 20px;">Nenhum curso cadastrado no momento.</p>';
}

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