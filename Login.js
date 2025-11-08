const registrar = document.getElementById("registrar");
const logar = document.getElementById("logar");
const container = document.getElementById("container-barralateral")

registrar.addEventListener("click", acionar());

function acionar() {
    container.classList.add('ativo');
}