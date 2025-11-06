
function abrirMenu(menuId) {
    const menu = document.getElementById(menuId);
    if (menu) {
        // Fecha todos os menus
        document.querySelectorAll('.menu-lateral').forEach(m => {
            m.classList.remove('active');
        });
        // Abre o menu desejado
        menu.classList.add('active');
    }
}

function fecharMenu(menuId) {
    const menu = document.getElementById(menuId);
    if (menu) {
        menu.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const hamburguerBtn = document.getElementById('botao-menu');

    // O PHP vai decidir se o usuário está logado ou não
    let estaLogado = false; // por padrão deslogado, PHP pode alterar

    hamburguerBtn.addEventListener('click', () => {
        if (estaLogado) {
            abrirMenu('menu-logado');
        } else {
            abrirMenu('menu-deslogado');
        }
    });

    // Botão Entrar (deslogado)
    const btnEntrar = document.querySelector('#menu-deslogado .botao-entrar');
    btnEntrar.addEventListener('click', () => {
        alert('Redirecionando para a tela de Login...');
        fecharMenu('menu-deslogado');
    });

    // Botão Sair (logado)
    const btnSair = document.querySelector('#menu-logado .botao-entrar');
    btnSair.addEventListener('click', () => {
        alert('Saindo...');
        fecharMenu('menu-logado');
    });

    // Efeito de sombra nos links
    const menuLinks = document.querySelectorAll('.menu-lateral nav ul li a');

    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Remove efeito de todos
            menuLinks.forEach(l => l.classList.remove('active'));
            // Aplica só no clicado
            this.classList.add('active');
        });
    });
});
