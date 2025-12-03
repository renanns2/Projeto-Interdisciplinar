const btns = document.querySelectorAll('.info');

btns.forEach(botao => {
    botao.addEventListener('click', () => {
        const divOculta = botao.nextElementSibling;

        //Mostra elemento oculto
        if(divOculta && divOculta.classList.contains('botaooculto')) {
            divOculta.classList.toggle('ativado');
        }

        //Altera imagem
        const icone = botao.querySelector('i.fa-angle-right');
        if (icone) {
            icone.classList.toggle('rotacionado');
        }
    })
})