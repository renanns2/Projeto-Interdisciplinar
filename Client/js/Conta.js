const btns = document.querySelectorAll('.info');
let img_ativa = false;

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

        if (temAlteracao || img_ativa) {
            barra.classList.add('visivel');
        }else {
            barra.classList.remove('visivel');
        }
    })
}

inputs.forEach(input => {
    input.addEventListener('input', verificarAlteracoes);
})

// Preview e mandar imagem
const texto = document.getElementById('abrirUpload');
const input = document.getElementById('inputImagem');
const foto_perfil = document.getElementById('img_perfil');

texto.addEventListener('click', ()=> {
    input.click();
})

input.addEventListener('change', previewImg)

function previewImg () {
    if (input.files.length > 0) {
    const tipo = input.files[0].type
    const formato = ["image/jpeg", "image/png", "image/jpg"]
    if (!formato.includes(tipo)) {
        alert('Esse formato não é permitido!');
        return;
    }

    foto_perfil.src = URL.createObjectURL(input.files[0])
    img_ativa = true;
    verificarAlteracoes();
}
}


//botao redefinir
const redefinir = document.getElementById('redefinir');
redefinir.addEventListener('click', () => {
    const imagemPadrao = "uploads/SemFoto.jpg";
    foto_perfil.src = imagemPadrao;
    img_ativa = true;
    verificarAlteracoes();
    inputFile.value = "";
    verificarAlteracoes();
})

// botao cancelar
const cancelar = document.getElementById('cancelarAlteracao');
const imagem_ori = foto_perfil.src;
cancelar.addEventListener('click', () => {
    foto_perfil.src = imagem_ori;
    img_ativa = false;

    inputs.forEach(input => {
        input.value = "";
    })
    temAlteracao = false;
    verificarAlteracoes();

    //fechar menus abertos
    document.querySelectorAll('.botaooculto.ativado').forEach(div => {
        div.classList.remove('ativado');
    })

    document.querySelectorAll('.info i.rotacionado').forEach(icone => {
        icone.classList.remove('rotacionado');
    })

})