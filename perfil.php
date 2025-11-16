<?php
session_start();

$estaLogado = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
$nomeUsuario = $estaLogado ? htmlspecialchars($_SESSION['nome_usuario']) : '';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="perfil.css">
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
                       <li><a href="conta.php">Conta</a></li>
                        <li><a href="editar.php">Editar Perfil</a></li>
                        <li><a href="minhas_publicacoes.php">Minhas Publicações</a></li>

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

        <div class="cabecalho-perfil">
            <div class="background-img"></div>

            <div class="info-perfil">
                <img src="img/user.png" alt="Foto de Perfil" class="profile-image">
                <h1 class="username"><?php echo $nomeUsuario; ?></h1>
            </div>
        </div>

        <section class="secoes-perfil">
            
            <h2 class="titulo-secao">Cursos salvos</h2>
            
            <div class="lista-cursos-salvos">
                
                <div class="curso-salvo-card">
                    <div class="curso-thumbnail"></div>
                    <p class="curso-texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sodales aliquam ultrices.</p>
                </div>
                
                <div class="curso-salvo-card">
                    <div class="curso-thumbnail"></div>
                    <p class="curso-texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sodales aliquam ultrices.</p>
                </div>
                
                <div class="curso-salvo-card">
                    <div class="curso-thumbnail"></div>
                    <p class="curso-texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sodales aliquam ultrices.</p>
                </div>
                <div class="curso-salvo-card">
                    <div class="curso-thumbnail"></div>
                    <p class="curso-texto">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sodales aliquam ultrices.</p>
                </div>
                
            </div>
            
            <button class="botao-carregar">Carregar mais</button>
            
        </section>
 </main>
 

 <script src="menu.js"></script>
 </body>
</html>