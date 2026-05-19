// servicos2

const inputFile = document.getElementById('arquivo');
const fileNameDisplay = document.getElementById('file-name');

inputFile.addEventListener('change', function () {
    if (this.files.length > 0) {
        fileNameDisplay.textContent = this.files[0].name;
    } else {
        fileNameDisplay.textContent = 'Nenhum arquivo selecionado';
    }
});
