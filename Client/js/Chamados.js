const anexo = document.getElementById('anexo');
const img = document.getElementById('preview');
const div_img = document.getElementById('img');

anexo.addEventListener('change', mostrarPreview);

function mostrarPreview() {

    if (anexo.files.length > 0) {
        const tipo = anexo.files[0].type
        const formato = ["image/jpeg", "image/png", "image/jpg"]
        if (!formato.includes(tipo)) {
            alert('Esse formato não é permitido!');
            return;
        }
        div_img.classList.add('ativo');

        img.classList.add('ativo');
        img.src = URL.createObjectURL(anexo.files[0])
    
    }
}

const form = document.getElementById('form');

// Fazendo o formulario ser aplicado na msema pagina, com o mesmo scroll, sem recarregar
//Assim que o formulario for enviado
form.addEventListener("submit", function(e) {
    e.preventDefault(); // Prevenindo de recarregar a pagina e ação padrão
    
    const dados = new FormData(form); // Pegando os dados do formulario
    console.log("FormData criado: ", [...dados.entries()]); // Colocando em uma array pra ficar + facil de ver

    // Vai enviar uma informação do formulario pro servidor, esperando  uma resposta.
    // Essa resposta vai vir em um formato RESPONSE
    fetch("Reparar_computador.php", {
        method: "POST",
        body: dados
    })
    //pegando a resposta que veio e transformando em JSON(mesmo que a gnt transforme no PHP, um objeto json nunca vai navegar pelo http);
    // sempre que digitar um .then depois do fetch ele vai estar se referenciando a resposta, entao podemos colocar qualquer nome aqui.
    .then(function (res){
        return res.json();
    })
    // a resposta depois da função json() sempre vai ser os dados.
    .then(resposta => {
        console.log("Resposta do PHP:", resposta);
        mostrarMensagem(resposta);
    })
    // a função .catch ela pega erros que aconteceram nos then anteriores.
    .catch(err => {
        console.error("Erro no AJAX", err);
    });
})

// função que será executada após a resposta ter sido recebida com sucesso
function mostrarMensagem(resposta) {
    //pegando os valores
    const overlay = document.getElementById("overlay");
    const caixa = document.getElementById("caixa_mensagem");

    //Adicionando class view (visualizar)
    overlay.classList.add('view');
    caixa.classList.add('view');

    //Definindo titulo e texto da div
    //Pegando o status da posição 0.
    let status = resposta[0].status;
    let titulo = "";
    
    if (status === 'sucesso') {
        titulo = "Sucesso!";
    }else {
        titulo = "Erro!";
    }

    let html = `
        <h1>${titulo}</h1>
    `;

    resposta.forEach(m => {
        html += `<p>${m.mensagem}</p>`;
    });

    html += `<button onclick="location.href='Chamados.php'">Ir para Chamados</button>`

    caixa.innerHTML = html;
}