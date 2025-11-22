/* -------- DÚVIDAS FREQUENTES -------- */

const perguntas = document.querySelectorAll('.duvida');

perguntas.forEach(item => {
    const botao = item.querySelector('.pergunta');

    botao.addEventListener('click', () => {
        item.classList.toggle('ativa');
    });
});
