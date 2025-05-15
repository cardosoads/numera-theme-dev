jQuery(document).ready(($) => {
	$('#edit-map-form').on('submit', function (e) {
		e.preventDefault();
		const data = new FormData(this);
		data.append('action', 'save_map_meta');
		data.append('security', single_map_ajax_obj.nonce);

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
			alert('Alterações salvas com sucesso!');
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

	const sequenciasNegativas = [
		'111',
		'222',
		'333',
		'444',
		'555',
		'666',
		'777',
		'888',
		'999',
	];
	const sequenciasPositivas = [
		'116',
		'118',
		'119',
		'123',
		'168',
		'252',
		'272',
		'375',
		'518',
		'575',
		'637',
		'651',
		'665',
		'667',
		'725',
		'757',
		'922',
		'923',
		'924',
		'926',
	];

	function getSequencias() {
		updateSequencias('#piramideVida', '#listaVida');
		updateSequencias('#piramideTalento', '#listaTalento');
		updateSequencias('#piramideAscensao', '#listaAscensao');
		updateSequencias('#piramideOculta', '#listaOculta');
	}

	function updateSequencias(piramideId, listaId) {
		const piramide = $(`${piramideId} .sequecia`);
		const lista = $(`${listaId} ul`);
		lista.empty();

		const negativas = [];
		const positivas = [];

		piramide.each((_, span) => {
			const texto = $(span).text().trim();
			if (sequenciasNegativas.includes(texto)) {
				negativas.push(texto);
			} else if (sequenciasPositivas.includes(texto)) {
				positivas.push(texto);
			}
		});

		appendSequenciasToList(negativas, lista);
		appendSequenciasToList(positivas, lista);
	}

	function appendSequenciasToList(sequencias, lista) {
		let row = $('<div>').addClass('flex mb-2');
		let count = 0;

		sequencias.forEach((seq) => {
			const li = $('<li>').addClass('flex-1 text-center').text(seq);
			row.append(li);
			count++;

			if (count % 3 === 0) {
				lista.append(row);
				row = $('<div>').addClass('flex mb-2');
			}
		});

		if (count % 3 !== 0) {
			lista.append(row);
		}
	}

	getSequencias();

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

	// Modal functionality
	const openModalButton = $('#openModal');
	const closeModalButton = $('#closeModal');
	const modal = $('#myModal');

	openModalButton.on('click', function (event) {
		event.preventDefault();
		modal.show(); // Mostrar o modal
	});

	closeModalButton.on('click', function () {
		modal.hide(); // Esconder o modal
	});

	$(window).on('click', function (event) {
		if ($(event.target).is(modal)) {
			modal.hide(); // Esconder o modal se clicar fora do conteúdo
		}
	});

	function calculateMotivacao() {
		const motivacao = $('#motivacao').val();
		const resultado = $('#resultado-motivacao');
		resultado.text(motivacao);
	}

	function calculateImpressao() {
		const impressao = $('#impressao').val();
		const resultado = $('#resultado-impressao');
		resultado.text(impressao);
	}

	function calculateExpressao() {
		const expressao = $('#expressao').val();
		const resultado = $('#resultado-expressao');
		resultado.text(expressao);
	}

	function calculateArcano() {
		const arcano = $('#arcano').val();
		const resultado = $('#resultado-arcano');
		resultado.text(arcano);
	}

	$('#motivacao').on('input', calculateMotivacao);
	$('#impressao').on('input', calculateImpressao);
	$('#expressao').on('input', calculateExpressao);
	$('#arcano').on('input', calculateArcano);
});
