<?php
include 'conexao.php'; 
session_start(); 

$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$nomeUsuario = $estaLogado ? htmlspecialchars($_SESSION['nome_usuario']) : ''; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID do curso inválido ou não fornecido.");
    header('Location: cursosgeral.php'); 
    exit();
}

$id_curso = $_GET['id'];

$select = "SELECT * FROM tb_curso WHERE id_curso = ?";
$prepare = $conexao->prepare($select);

if (!$prepare) {
    die("Erro na preparação da consulta: " . $conexao->error);
}

$prepare->bind_param('i', $id_curso); 
$prepare->execute();
$resultado = $prepare->get_result();

if ($resultado->num_rows === 0) {
    die("Curso não encontrado.");
}

$curso_data = $resultado->fetch_assoc();

$titulo = htmlspecialchars($curso_data['nm_curso']);
$descricao_curta = htmlspecialchars($curso_data['ds_curso']); // Usado no bloco logo abaixo da imagem
$descricao_detalhada = htmlspecialchars($curso_data['ds_curso']); // Geralmente seria um campo diferente, mas usaremos o mesmo aqui
$imagem_url = htmlspecialchars($curso_data['url_img']);
$nivel = htmlspecialchars($curso_data['nivel_curso']);
$area = htmlspecialchars($curso_data['area_curso']);
$preco = ($curso_data['vl_curso'] == 0.00) ? "Grátis" : 'R$ ' . number_format($curso_data['vl_curso'], 2, ',', '.');
$carga_horaria = htmlspecialchars($curso_data['ch_curso']);
$certificado = ($curso_data['certificado'] == 'S') ? 'Sim' : 'Não'; // Supondo 'S' ou 'N' no DB

$prepare->close();
$conexao->close();

?>

    <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - AdaCode</title>
    <link rel="stylesheet" href="cursoespecifico.css">
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
                    <h1 id="titulo">Cursos</h1>
                    <h2 id="descricao-titulo">Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                        Maecenas  sodales aliquam ultrices. Curabitur arcu turpis, fermentum id convallis  et, laoreet eget dolor.
                    </h2>
                </div>
            </div>
        </section>
    
   <div class="curso">
    <img class="imagem-curso" src="<?php echo $imagem_url; ?>" alt="Imagem do Curso">
    <div class="titulo-e-icone">
        <h3><?php echo $titulo; ?></h3>
        <div class="icones">
            <i class="fas fa-heart"></i>
            <i class="fas fa-share-alt"></i>
        </div>
    </div>
    <div class="bloco-descricao-curso">
        <p class="descricao-curso">
            <?php echo $descricao_curta; ?>
        </p>
    </div>
    <img class="youtube" src="img/logoyoutube.png" alt="Logo YouTube">
    <div class="descricao-detalhada">
        <h4>Descrição</h4>
        <p class="descricao-curso">
            <?php echo $descricao_detalhada; ?>
        </p>
        <div class="info-curso">
            <ul>
                <li><strong>Nível:</strong> <?php echo $nivel; ?></li>
                <li><strong>Área:</strong> <?php echo $area; ?></li>
                <li><strong>Preço (R$):</strong> <?php echo $preco; ?></li>
                <li><strong>Carga horária:</strong> <?php echo $carga_horaria; ?></li>
                <li><strong>Emite certificado?</strong> <?php echo $certificado; ?></li>
            </ul>
        </div>
    </div>
</div>



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