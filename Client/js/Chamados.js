document.querySelectorAll('.chamado').forEach(chamado => {
    chamado.addEventListener('click', () => {
        const detalhes = chamado.querySelector('.detalhes');
        detalhes.classList.toggle('expandido');
    });
});
