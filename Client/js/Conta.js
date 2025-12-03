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

const inputs = document.querySelectorAll('#formConta .botaooculto input');
const barra = document.getElementById('barra-confirmacao');

function verificarAlteracoes() {
    let temAlteracao = false;

    inputs.forEach(input => {
        if (input.value.trim() !== "") {
            temAlteracao = true;
        }

        if (temAlteracao) {
            barra.classList.add('visivel');
        }else {
            barra.classList.remove('visivel');
        }
    })
}

inputs.forEach(input => {
    input.addEventListener('input', verificarAlteracoes);
})