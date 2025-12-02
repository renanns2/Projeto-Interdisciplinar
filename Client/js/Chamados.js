// espera o DOM carregar para garantir que os .chamado existam
document.addEventListener('DOMContentLoaded', () => {

    // pega todos os elementos com a classe .chamado
    const chamados = document.querySelectorAll('.chamado');
    chamados.forEach((chamado, index) => {
    chamado.addEventListener('click', (e) => {
        const detalhes = chamado.querySelector('.detalhes');

        detalhes.classList.toggle('expandido');


        chamado.classList.toggle('expandido');
    });
  });

  const status = document.getElementById('status');
  const tipo = document.getElementById('tipo');
  const data = document.getElementById('data');

  status.addEventListener("click", ativar);
  tipo.addEventListener("click", ativar);
  data.addEventListener("click", ativar);

  function ativar(e) {
    const ordenar_menu = e.currentTarget.querySelector('.ordenar-menu');
    ordenar_menu.classList.toggle('ativado');
  }

});

