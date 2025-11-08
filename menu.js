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
    // 1. Lógica do Botão Hamburguer
    const hamburguerBtn = document.getElementById('botao-menu');

    hamburguerBtn.addEventListener('click', () => {
        const menuLogado = document.getElementById('menu-logado');
        const menuDeslogado = document.getElementById('menu-deslogado');

        if (menuLogado) {
            abrirMenu('menu-logado');
        } else if (menuDeslogado) {
            abrirMenu('menu-deslogado');
        }
    });
    
    // 2. Lógica do Efeito de Sombra nos Links (AGORA DENTRO DO DOMContentLoaded)
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
// FIM DO ARQUIVO home.js