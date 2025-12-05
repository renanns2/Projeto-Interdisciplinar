const chamados = document.querySelectorAll('.chamado');
chamados.forEach(chamado => {
    const dropdown = chamado.nextElementSibling;

    chamado.addEventListener('click', (e) => {
        e.stopPropagation;
        dropdown.classList.toggle('ativo');
    })
})