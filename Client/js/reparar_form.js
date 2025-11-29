const anexo = document.getElementById('anexo');
const img = document.getElementById('preview');

anexo.addEventListener('change', mostrarPreview);

function mostrarPreview() {

    if (anexo.files.length > 0) {
        const tipo = anexo.files[0].type
        const formato = ["image/jpeg", "image/png", "image/jpg"]
        if (!formato.includes(tipo)) {
            alert('Esse formato não é permitido!');
            return;
        }

        img.classList.add('ativo');
        img.src = URL.createObjectURL(anexo.files[0])
    
    }
}