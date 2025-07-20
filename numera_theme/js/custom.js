document.addEventListener('DOMContentLoaded', function () {
    const capturarBtn = document.getElementById('capturar-btn'); // Botão para capturar
    const divParaCaptura = document.getElementById('div-captura'); // A div que será capturada

    if (capturarBtn) {
        capturarBtn.addEventListener('click', function () {
            html2canvas(divParaCaptura).then(function (canvas) {
                canvas.toBlob(function (blob) {
                    if (!navigator.clipboard) {
                        alert('Seu navegador não suporta a cópia direta para a área de transferência.');
                        return;
                    }

                    const item = new ClipboardItem({ 'image/png': blob });

                    navigator.clipboard.write([item]).then(() => {
                        alert('Piramide copiada! Agora você pode colar com CTRL + V no seu Mapa Word.');
                    }).catch(err => {
                        console.error('Erro ao copiar a imagem:', err);
                        alert('Não foi possível copiar a imagem. Verifique as permissões do navegador.');
                    });
                }, 'image/png');
            });
        });
    }
});


/*document.addEventListener('DOMContentLoaded', function () {
    const capturarBtn = document.getElementById('capturar-btn'); // Botão para capturar
    const divParaCaptura = document.getElementById('div-captura'); // Div que você quer capturar

    if (capturarBtn) {
        capturarBtn.addEventListener('click', function () {
            html2canvas(divParaCaptura).then(function(canvas) {
                // Aqui você pode fazer o que quiser com o canvas gerado
                const imgData = canvas.toDataURL('image/png');
                const a = document.createElement('a');
                a.href = imgData;
                a.download = 'imagem-capturada.png'; // Nome do arquivo
                a.click();
            });
        });
    }
});*/
document.addEventListener('DOMContentLoaded', function () {
    const capturarBtn = document.getElementById('capturar-btn-2'); // Botão para capturar
    const divParaCaptura = document.getElementById('div-captura-2'); // Div que você quer capturar

    if (capturarBtn) {
        capturarBtn.addEventListener('click', function () {
            html2canvas(divParaCaptura).then(function(canvas) {
                // Aqui você pode fazer o que quiser com o canvas gerado
                const imgData = canvas.toDataURL('image/png');
                const a = document.createElement('a');
                a.href = imgData;
                a.download = 'imagem-capturada.png'; // Nome do arquivo
                a.click();
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const capturarBtn = document.getElementById('capturar-btn-3'); // Botão para capturar
    const divParaCaptura = document.getElementById('div-captura-3'); // Div que você quer capturar

    if (capturarBtn) {
        capturarBtn.addEventListener('click', function () {
            html2canvas(divParaCaptura).then(function(canvas) {
                // Aqui você pode fazer o que quiser com o canvas gerado
                const imgData = canvas.toDataURL('image/png');
                const a = document.createElement('a');
                a.href = imgData;
                a.download = 'imagem-capturada.png'; // Nome do arquivo
                a.click();
            });
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const capturarBtn = document.getElementById('capturar-btn-4'); // Botão para capturar
    const divParaCaptura = document.getElementById('div-captura-4'); // Div que você quer capturar

    if (capturarBtn) {
        capturarBtn.addEventListener('click', function () {
            html2canvas(divParaCaptura).then(function(canvas) {
                // Aqui você pode fazer o que quiser com o canvas gerado
                const imgData = canvas.toDataURL('image/png');
                const a = document.createElement('a');
                a.href = imgData;
                a.download = 'imagem-capturada.png'; // Nome do arquivo
                a.click();
            });
        });
    }
});
