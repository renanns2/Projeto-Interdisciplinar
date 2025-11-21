const registrar = document.getElementById("registrar");
const logar = document.getElementById("logar");
const container = document.getElementById("container")
const registroForm = document.querySelector(".formulario.registro");
const logarForm = document.querySelector(".formulario.login");

registrar.addEventListener("click", ativar);

function ativar() {
    container.classList.add('painel-direito-ativo');

    //Colocar timeout para mudar o zIndex, mudando apenas quando formulario e barralateral estão na mesma posição, no meio da pagina.
    setTimeout(() => {
        logarForm.style.zIndex = "1";
        registroForm.style.zIndex = "5";
    }, 300); 
}       

logar.addEventListener("click", desativar);

function desativar() {

    container.classList.remove('painel-direito-ativo');

    setTimeout(() => {
        logarForm.style.zIndex = "5";   
        registroForm.style.zIndex = "1";
    }, 300); 

}