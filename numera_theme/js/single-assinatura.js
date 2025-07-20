// Manipula o DOM e interage com o backend
jQuery(document).ready(($) => {
    // Função para enviar os dados do formulário
    $('#edit-assinatura-form').on('submit', function (e) {
        e.preventDefault();
        const data = new FormData(this);
        data.append('action', 'save_assinatura_meta');
        data.append('security', single_assinatura_ajax_obj.nonce);

        $.ajax({
            url: '/wp-admin/admin-ajax.php',
            method: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: handleAjaxSuccess,
            error: handleAjaxError,
        });
    });

    function handleAjaxSuccess(response) {
        if (response.success) {
            console.log(response);
            alert('Cálculo realizado com sucesso!');
            atualizarResultados();
            location.reload(); // Recarrega a página
        } else {
            console.error('Error response:', response.data);
            alert(response.data);
        }
    }

    function handleAjaxError(xhr, status, error) {
        console.error('AJAX Error:', status, error);
        alert('An error occurred. Please try again.');
    }

    function atualizarResultados() {
        $('#resultado-motivacao').text('Novo valor motivação');
        $('#resultado-impressao').text('Novo valor impressão');
        $('#resultado-expressao').text('Novo valor expressão');
        $('#resultado-arcano').text('Novo valor arcano');
    }

    // Obter os dados do alfabeto, vogais e consoantes
    const vogais = JSON.parse($('#vogais').text());
    const consoantes = JSON.parse($('#consoantes').text());
    const alfabeto = JSON.parse($('#alfabeto').text());

    $('#nome_completo').on('input', function () {
        const name = this.value;

        const vogaisContainer = $('#vogais-result').empty();
        const letrasContainer = $('#letras-result').empty();
        const consoantesContainer = $('#consoantes-result').empty();
        const valoresResult = $('#all-vl-result').empty();

        for (let i = 0; i < name.length; i++) {
            const letra = name[i];
            const vogal = getVogais(letra);
            const consoante = getConsoantes(letra);
            const valor = getAlfabeto(letra);

            if (
                letra.trim() === '' ||
                letra.trim() === ' ' ||
                !isNaN(letra.trim())
            ) {
                vogaisContainer.append(`<div class="flex flex-col items-center w-8"><div class="item">${vogal}</div></div>`);
                consoantesContainer.append(`<div class="flex flex-col items-center w-8"><div class="item">${consoante}</div></div>`);
                valoresResult.append(`<div class="flex flex-col items-center w-8"><div class="item">${valor}</div></div>`);
                letrasContainer.append(`<div class="flex flex-col items-center w-8"><div class="item">${letra}</div></div>`);
            } else {
                vogaisContainer.append(`<div class="flex flex-col items-center w-8"><div class="bg-blue-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">${vogal}</div></div>`);
                consoantesContainer.append(`<div class="flex flex-col items-center w-8"><div class="bg-green-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">${consoante}</div></div>`);
                valoresResult.append(`<div class="flex flex-col items-center w-8"><div class="bg-purple-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">${valor}</div></div>`);
                letrasContainer.append(`<div class="flex flex-col items-center w-8"><div class="text-gray-700 font-medium rounded-lg w-8 h-8 flex items-center justify-center">${letra}</div></div>`);
            }
        }
    });

    function getVogais(letra) {
        return vogais[letra] || '';
    }

    function getConsoantes(letra) {
        return consoantes[letra] || '';
    }

    function getAlfabeto(letra) {
        return alfabeto[letra] || '';
    }

    // Função para calcular os arcanos
    function calcularArcanos(nomeCompleto, dataNascimento, alfabeto) {
        const numeros = [];
        const nomeArray = Array.from(nomeCompleto);

        nomeArray.forEach((letra) => {
            if (alfabeto[letra]) {
                numeros.push(alfabeto[letra]);
            }
        });

        const arcanos = [];
        for (let i = 0; i < numeros.length - 1; i++) {
            const arcano = numeros[i] * 10 + numeros[i + 1];
            arcanos.push(arcano);
        }

        const numArcanos = arcanos.length;
        if (numArcanos === 0) return [];

        const duracaoArcanoTotal = 90 / numArcanos;
        const anosPorArcano = Math.floor(duracaoArcanoTotal);
        const mesesDecimais = (duracaoArcanoTotal - anosPorArcano) * 12;
        const mesesPorArcano = Math.floor(mesesDecimais);
        const diasPorArcano = Math.round((mesesDecimais - mesesPorArcano) * 30);

        const inicioArcano = new Date(dataNascimento);
        const arcanosDetalhados = [];

        arcanos.forEach((arcano, index) => {
            const fimArcano = new Date(
                inicioArcano.getFullYear() + anosPorArcano,
                inicioArcano.getMonth() + mesesPorArcano,
                inicioArcano.getDate() + (index > 0 ? diasPorArcano - 1 : diasPorArcano)
            );

            arcanosDetalhados.push({
                arcano,
                inicio: inicioArcano.toLocaleDateString(),
                fim: fimArcano.toLocaleDateString(),
            });

            inicioArcano.setFullYear(fimArcano.getFullYear(), fimArcano.getMonth(), fimArcano.getDate() + 1);
        });

        return arcanosDetalhados;
    }

    // Modal functionality
    const openModalButton = $('#openModal');
    const closeModalButton = $('#closeModal');
    const modal = $('#myModal');

    openModalButton.on('click', function (event) {
        event.preventDefault();
        modal.show();
    });

    closeModalButton.on('click', function () {
        modal.hide();
    });

    $(window).on('click', function (event) {
        if ($(event.target).is(modal)) {
            modal.hide();
        }
    });
});
