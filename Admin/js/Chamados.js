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

form = document.getElementById('form');
form.addEventListener("submit", (e) => {
    
})