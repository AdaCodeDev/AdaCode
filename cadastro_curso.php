<?php
session_start();

require_once 'conexao.php'; 
$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$nomeUsuario = $estaLogado ? htmlspecialchars($_SESSION['nome_usuario']) : '';

// 1. Buscar Níveis padronizados
$niveis = [];
try {
    $niveis = buscarDadosPadronizados($conexao, 'tb_nivel');
} catch (Exception $e) {
    echo "Erro ao carregar níveis: " . $e->getMessage();
}

// 2. Buscar Áreas padronizadas
$areas = [];
try {
    $areas = buscarDadosPadronizados($conexao, 'tb_area');
} catch (Exception $e) {
    echo "Erro ao carregar áreas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Curso - AdaCode</title>
    <link rel="stylesheet" href="minhas_publicacoes.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <div class="screen-container">

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

            <div class="foto-ada">
                <img src="img/AdaCortada.png" alt="Foto Ada Lovelace">
            </div>

            <div class="forms">
                <h1 class="titulo-pagina">Cadastro de Curso</h1>

                <form class="course-form" action="insert_curso.php" method="post" enctype="multipart/form-data">

                    <input type="text" name="titulo" placeholder="Título" required>

                    <textarea class="descricao" name="descricao" placeholder="Descrição Resumida" rows="4" required></textarea>
                    <textarea class="descricao" name="descricao2" placeholder="Descrição Completa" rows="4" required></textarea>


                    <input type="text" name="plataforma" placeholder="Plataforma">

                    <select name="nivel" required class="custom-select">
                        <option value="" disabled selected>Nível do Curso (Selecione um)</option>
                        <?php foreach ($niveis as $nivel): ?>
                            <option value="<?php echo $nivel['id_nivel']; ?>"><?php echo htmlspecialchars($nivel['nm_nivel']); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="area-selection-container">
                        <p class="selection-title">Áreas de Tecnologia</p>
                        <div class="area-options-wrapper">
                            <?php foreach ($areas as $area): ?>
                                <input type="checkbox" id="area_<?php echo $area['id_area']; ?>" name="areas[]" value="<?php echo $area['id_area']; ?>" class="area-checkbox">
                                <label for="area_<?php echo $area['id_area']; ?>" class="area-label">
                                    <span class="custom-checkbox-ball"></span>
                                    <?php echo htmlspecialchars($area['nm_area']); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <input type="number" name="preco" placeholder="Preço(R$)" step="0.01">
                    <input type="text" name="cargaHoraria" placeholder="Carga horária">

                    <input type="text" name="certificado" placeholder="Emite certificado? (Sim/Não)">
                    <input type="text" name='url' placeholder="Insira a url do curso">

                    <div class="upload-area">
                        <label for="capa_upload">Upload de Imagem de capa</label>
                        <input type="file" id="capa_upload" name="urlimg" accept="image/*" style="display:none;">
                    </div>

                    <button type="submit" class="submit-button">Cadastrar</button>

                </form>
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

    </div>

    <script src="menu.js"></script>
</body>

</html>