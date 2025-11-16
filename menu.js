function abrirMenu(menuId) {
    const menu = document.getElementById(menuId);
    if (menu) {
        
        document.querySelectorAll('.menu-lateral').forEach(m => {
            m.classList.remove('active');
        });

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

    hamburguerBtn.addEventListener('click', () => {
        const menuLogado = document.getElementById('menu-logado');
        const menuDeslogado = document.getElementById('menu-deslogado');

        if (menuLogado) {
            abrirMenu('menu-logado');
        } else if (menuDeslogado) {
            abrirMenu('menu-deslogado');
        }
    });
    
    const menuLinks = document.querySelectorAll('.menu-lateral nav ul li a');

    menuLinks.forEach(link => {
        link.addEventListener('click', function() {
            menuLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});
