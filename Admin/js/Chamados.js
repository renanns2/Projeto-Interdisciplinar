
//Abrir menu dropdown ao clicar em chamados
const chamados = document.querySelectorAll('.chamado');
chamados.forEach(chamado => {
    const dropdown = chamado.nextElementSibling;
    const imagem = chamado.querySelector('.mascara-imagem');

    chamado.addEventListener('click', (e) => {
        e.stopPropagation;
        dropdown.classList.toggle('ativo');
        imagem.classList.toggle('ativo');
    })
})

//Abrir menu de falar pq negou pedido
const btns_negar = document.querySelectorAll('.negar');
const overlay = document.getElementById('overlay');

//pra cada botao de negar
btns_negar.forEach(botao => {
    //pegar o menu
    const menu_negar = botao.nextElementSibling;
    // clicou no botao de negar abre o menu
    botao.addEventListener('click', (e) => {
        e.stopPropagation;
        menu_negar.classList.add('ativo');
        overlay.classList.add('ativo');

        //botao de negar dentro do menu 
        const negar_menu = menu_negar.querySelector('.negar_menu');
        negar_menu.addEventListener('click', (e) => {
            menu_negar.classList.remove('ativo');
        })

        //botao de cancelar dentro do menu
        const cancelar = menu_negar.querySelector('.cancelar_menu');
        cancelar.addEventListener('click', (e) => {
            menu_negar.classList.remove('ativo');
            overlay.classList.remove('ativo');
        })

    })
})



//Fechar menu de mensagens
const fechar = document.getElementById('fechar');
const caixa = document.getElementById('caixa_mensagem');
fechar.addEventListener('click', () => {
    caixa.classList.remove('ativo');
    overlay.classList.remove('ativo');
})