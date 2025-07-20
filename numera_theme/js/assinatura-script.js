// Espera o documento estar completamente carregado
document.addEventListener('DOMContentLoaded', function () {
    // Obtém os dados passados pelo PHP
    const data = assinaturaData;

    // Preenche os campos do formulário com os dados
    document.getElementById('post_id').value = data.post_id;
    document.getElementById('nome_completo').value = data.nome_completo;
    document.getElementById('data_nascimento').value = data.data_nascimento;

    // Seção de Consoantes (Impressão)
    const consoantesResult = document.getElementById('consoantes-result');
    data.letras_nome.forEach(letra => {
        const div = document.createElement('div');
        div.className = 'flex flex-col items-center w-8';
        if (/[a-z0-9]/i.test(letra)) {
            // Se a letra for alfanumérica, exibe o valor da consoante
            div.innerHTML = `
                <div class="bg-green-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                    ${data.consoantes[letra] || ' '}
                </div>
            `;
        } else {
            // Caso contrário, exibe um espaço vazio
            div.innerHTML = '<div class="w-8 h-8"></div>';
        }
        consoantesResult.appendChild(div);
    });

    // Seção de Letras do nome
    const letrasResult = document.getElementById('letras-result');
    data.letras_nome.forEach(letra => {
        const div = document.createElement('div');
        div.className = 'flex flex-col items-center w-8';
        div.innerHTML = `<div class="text-gray-900 font-medium">${letra}</div>`;
        letrasResult.appendChild(div);
    });

    // Seção de Vogais (Motivação)
    const vogaisResult = document.getElementById('vogais-result');
    data.letras_nome.forEach(letra => {
        const div = document.createElement('div');
        div.className = 'flex flex-col items-center w-8';
        if (/[a-z0-9]/i.test(letra)) {
            div.innerHTML = `
                <div class="bg-blue-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                    ${data.vogais[letra] || ' '}
                </div>
            `;
        } else {
            div.innerHTML = '<div class="w-8 h-8"></div>';
        }
        vogaisResult.appendChild(div);
    });

    // Seção de Expressão (Alfabeto)
    const allVlResult = document.getElementById('all-vl-result');
    data.letras_nome.forEach(letra => {
        const div = document.createElement('div');
        div.className = 'flex flex-col items-center w-8';
        if (/[a-z0-9]/i.test(letra)) {
            div.innerHTML = `
                <div class="bg-purple-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                    ${data.alfabeto[letra] || ' '}
                </div>
            `;
        } else {
            div.innerHTML = '<div class="w-8 h-8"></div>';
        }
        allVlResult.appendChild(div);
    });

    // Seção de Somatórias das partes
    const somatoriasPartesResult = document.getElementById('somatorias-partes-result');
    const posicoesPartes = [];
    data.partes_nome_com_dados.forEach(parteDados => {
        const parteNome = parteDados.parte.toLowerCase();
        let posicaoInicial = -1;
        for (let i = 0; i <= data.letras_nome.length - parteNome.length; i++) {
            if (data.letras_nome.slice(i, i + parteNome.length).join('') === parteNome) {
                posicaoInicial = i;
                break;
            }
        }
        if (posicaoInicial !== -1) {
            posicoesPartes.push({
                posicao: posicaoInicial,
                motivacao: parteDados.motivacao,
                expressao: parteDados.expressao
            });
        }
    });

    let indiceParte = 0;
    for (let i = 0; i < data.letras_nome.length; i++) {
        const div = document.createElement('div');
        div.className = 'flex flex-col items-center w-8';
        if (indiceParte < posicoesPartes.length && i === posicoesPartes[indiceParte].posicao) {
            div.innerHTML = `
                <div class="bg-yellow-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                    ${posicoesPartes[indiceParte].motivacao}
                </div>
            `;
            somatoriasPartesResult.appendChild(div);

            const div2 = document.createElement('div');
            div2.className = 'flex flex-col items-center w-8';
            div2.innerHTML = `
                <div class="bg-red-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                    ${posicoesPartes[indiceParte].expressao}
                </div>
            `;
            somatoriasPartesResult.appendChild(div2);
            i++;
            indiceParte++;
        } else {
            div.innerHTML = '<div class="w-8 h-8"></div>';
            somatoriasPartesResult.appendChild(div);
        }
    }

    // Preenche os resultados dos cálculos
    document.getElementById('resultado-motivacao').textContent = data.numero_motivacao;
    document.getElementById('resultado-impressao').textContent = data.numero_impressao;
    document.getElementById('resultado-expressao').textContent = data.numero_expressao;
    document.getElementById('resultado-arcano').textContent = data.arcano;

    // Preenche a seção de Harmonia Conjugal
    document.getElementById('vibra-com').textContent = data.vibra_com;
    document.getElementById('atrai').textContent = data.atrai;
    document.getElementById('e-oposto').textContent = data.e_oposto;
    document.getElementById('e-passivo').textContent = data.e_passivo_em_relacao_a;

    // Preenche a seção de Números Harmônicos
    const numerosHarmonicosResult = document.getElementById('resultado-numeros-harmonicos');
    data.numeros_harmonicos.forEach(num => {
        const span = document.createElement('span');
        span.className = 'bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium';
        span.textContent = num;
        numerosHarmonicosResult.appendChild(span);
    });

    // Lógica para abrir e fechar modais
    document.querySelectorAll('a[data-modal]').forEach(openModalButton => {
        const modalId = openModalButton.getAttribute('data-modal');
        const modal = document.getElementById(modalId);
        const closeModalButton = modal.querySelector('.closeModal');

        openModalButton.addEventListener('click', function (event) {
            event.preventDefault();
            modal.style.display = 'flex';
        });

        closeModalButton.addEventListener('click', function () {
            modal.style.display = 'none';
        });

        window.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
});