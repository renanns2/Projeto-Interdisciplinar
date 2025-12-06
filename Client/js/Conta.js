
//Codigo de abrir os botões ocultos (Menu Dropdown)
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

// Codigo pra abrir o menu de salvar modificações
const inputs = document.querySelectorAll('#formConta .botaooculto input');
const selects = document.querySelectorAll('#formConta .botaooculto select');
const barra = document.getElementById('barra-confirmacao');

inputs.forEach(input => {
    input.addEventListener('input', verificarAlteracoes);
})
selects.forEach(select => {
    select.addEventListener('change', verificarAlteracoes);
})

// Função de verificar as alterações e acionar a barra
function verificarAlteracoes() {
    let temAlteracao = false;

    // se input for diferente de nada
    inputs.forEach(input => {
        if (input.value.trim() !== "") {
            temAlteracao = true;
        }
    })

    // se select for diferente doq começou
    selects.forEach(select => {
        let valorAtual = select.dataset.original;
        if (select.value !== valorAtual) {
            temAlteracao = true;
        }
    })

    // se teve alteração ou a img ta ativa
    if (temAlteracao || img_ativa) {
        barra.classList.add('visivel');
    }else {
        barra.classList.remove('visivel');
    }
}

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
const redefinir_hidden = document.getElementById('redefinir_hidden');
redefinir.addEventListener('click', () => {
    const imagemPadrao = "../uploads/foto_perfil/SemFoto.jpg";
    foto_perfil.src = imagemPadrao;
    img_ativa = true;
    verificarAlteracoes();
    input.value = "";
    verificarAlteracoes();
    redefinir_hidden.value = 1;
})

// botao cancelar
const cancelar = document.getElementById('cancelarAlteracao');
const imagem_ori = foto_perfil.src;
cancelar.addEventListener('click', () => {
    foto_perfil.src = imagem_ori;
    img_ativa = false;

    selects.forEach(select => {
        select.value = select.dataset.original;
    });

    inputs.forEach(input => {
        input.value = "";
    })
    verificarAlteracoes();

    //fechar menus abertos
    document.querySelectorAll('.botaooculto.ativado').forEach(div => {
        div.classList.remove('ativado');
    })

    document.querySelectorAll('.info i.rotacionado').forEach(icone => {
        icone.classList.remove('rotacionado');
    })

})