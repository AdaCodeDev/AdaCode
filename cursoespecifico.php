<?php
include 'conexao.php'; 
session_start(); 

// --- VALIDAÇÃO E CONFIGURAÇÃO INICIAL ---

$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$nomeUsuario = $estaLogado ? htmlspecialchars($_SESSION['nome_usuario']) : ''; 

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redireciona e encerra se o ID for inválido
    header('Location: cursosgeral.php'); 
    exit();
}

$id_curso = $_GET['id'];

// --- CONSULTA PRINCIPAL: CURSO e NÍVEL ---
$select = "
    SELECT 
        C.*,
        N.nm_nivel  -- Nome do Nível
    FROM 
        tb_curso C
    INNER JOIN 
        tb_nivel N ON C.fk_id_nivel = N.id_nivel
    WHERE 
        C.id_curso = ?
";
$prepare = $conexao->prepare($select);

if (!$prepare) {
    die("Erro na preparação da consulta do curso: " . $conexao->error);
}

$prepare->bind_param('i', $id_curso); 
$prepare->execute();
$resultado = $prepare->get_result();

if ($resultado->num_rows === 0) {
    die("Curso não encontrado.");
}

$curso_data = $resultado->fetch_assoc();
$prepare->close();


// --- CONSULTA SECUNDÁRIA: BUSCA DE MÚLTIPLAS ÁREAS ---

$select_areas = "
    SELECT 
        A.nm_area
    FROM 
        tb_curso_area CA
    INNER JOIN 
        tb_area A ON CA.fk_id_area = A.id_area
    WHERE 
        CA.fk_id_curso = ?
    ORDER BY 
        A.nm_area
";

$prepare_areas = $conexao->prepare($select_areas);

if (!$prepare_areas) {
    die("Erro na preparação da consulta de áreas: " . $conexao->error);
}

$prepare_areas->bind_param('i', $id_curso);
$prepare_areas->execute();
$resultado_areas = $prepare_areas->get_result();

$areas_array = [];
while ($area = $resultado_areas->fetch_assoc()) {
    $areas_array[] = htmlspecialchars($area['nm_area']);
}
$prepare_areas->close();

$area_string = implode(', ', $areas_array); 


$titulo = htmlspecialchars($curso_data['nm_curso']);
$descricao_curta = htmlspecialchars($curso_data['ds_curso']);
$descricao_detalhada = htmlspecialchars($curso_data['ds2_curso']); 
$imagem_url = 'img/' . htmlspecialchars($curso_data['url_img']); 
$url_curso_link = htmlspecialchars($curso_data['url_curso']); 
$nivel = htmlspecialchars($curso_data['nm_nivel']);
$area = $area_string;
$preco = ($curso_data['vl_curso'] == 0.00) ? "Grátis" : 'R$ ' . number_format($curso_data['vl_curso'], 2, ',', '.');
$carga_horaria = htmlspecialchars($curso_data['ch_curso']);
$certificado = (strtolower($curso_data['certificado']) == 'sim' || strtolower($curso_data['certificado']) == 's') ? 'Sim' : 'Não';


$conexao->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Curso: <?php echo $titulo; ?> - AdaCode</title>
    <link rel="stylesheet" href="cursoespecifico.css">
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
                    <h1 id="titulo">Detalhes do Curso</h1>
                    <h2 id="descricao-titulo">Confira todas as informações sobre o curso selecionado.
                    </h2>
                </div>
            </div>
        </section>
    
    <div class="curso">
        <?php if (!empty($url_curso_link)): ?>
            <a href="<?php echo $url_curso_link; ?>" target="_blank" rel="noopener noreferrer">
        <?php endif; ?>
        
        <img class="imagem-curso" src="<?php echo $imagem_url; ?>" alt="Imagem do Curso: <?php echo $titulo; ?>" 
             style="cursor: <?php echo !empty($url_curso_link) ? 'pointer' : 'default'; ?>;">
        
        <?php if (!empty($url_curso_link)): ?>
            </a>
        <?php endif; ?>
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
            <h4>Descrição Detalhada</h4>
            <p class="descricao-curso">
                <?php echo $descricao_detalhada; ?>
            </p>
            <div class="info-curso">
                <ul>
                    <li><strong>Nível:</strong> <?php echo $nivel; ?></li>
                    <li><strong>Área(s):</strong> <?php echo $area; ?></li>
                    <li><strong>Preço (R$):</strong> <?php echo $preco; ?></li>
                    <li><strong>Carga horária:</strong> <?php echo $carga_horaria; ?></li>
                    <li><strong>Emite certificado?</strong> <?php echo $certificado; ?></li>
                </ul>
            </div>
            
            <?php if (!empty($url_curso_link)): ?>
            <div class="link-acao">
                <a href="<?php echo $url_curso_link; ?>" target="_blank" rel="noopener noreferrer" class="botao-ir-curso">
                    Acessar o Curso <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
            <?php endif; ?>

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