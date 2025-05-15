function openArcano(evt, arcanoName) {
	// Ocultar todos os arcano
	var arcanoContainer = document.getElementsByClassName('arcano-container');
	for (var i = 0; i < arcanoContainer.length; i++) {
		arcanoContainer[i].style.display = 'none'; // Oculta todos os arcanos
	}

	// Remover classe "active" de todos os botões
	var tabLinks = document.getElementsByClassName('tab-link');
	for (var i = 0; i < tabLinks.length; i++) {
		tabLinks[i].classList.remove('active'); // Remove a classe 'active'
	}

	// Mostrar o arcano selecionado
	document.getElementById(arcanoName).style.display = 'block'; // Mostra o arcano selecionado

	// Adicionar a classe "active" ao botão clicado
	evt.currentTarget.classList.add('active'); // Adiciona a classe 'active' ao botão clicado
}

document.addEventListener('DOMContentLoaded', function () {
	// Script para as abas
	const tabs = document.querySelectorAll('[data-tab]');
	const tabContents = document.querySelectorAll('[data-tab-content]');

	tabs.forEach((tab) => {
		tab.addEventListener('click', function () {
			const target = this.getAttribute('data-tab');

			// Remove 'active' classes de todas as tabs
			tabs.forEach((t) =>
				t.classList.remove(
					'border-b-2',
					'border-blue-500',
					'text-blue-500'
				)
			);
			// Esconde todos os conteúdos de tabs
			tabContents.forEach((tc) => tc.classList.add('hidden'));

			// Adiciona 'active' na tab clicada
			this.classList.add(
				'border-b-2',
				'border-blue-500',
				'text-blue-500'
			);
			// Mostra o conteúdo correspondente
			document
				.querySelector(`[data-tab-content="${target}"]`)
				.classList.remove('hidden');
		});
	});

	// Script para salvar o formulário via AJAX
	// document
	// 	.getElementById('edit-map-form')
	// 	.addEventListener('submit', function (e) {
	// 		e.preventDefault();

	// 		// Coleta os dados do formulário
	// 		const nomeCompleto =
	// 			document.getElementById('edit-nome-completo').value;
	// 		const dataNascimento = document.getElementById(
	// 			'edit-data-nascimento'
	// 		).value;
	// 		const postId = document.querySelector('input[name=post-id]').value;

	// 		// Envia os dados via AJAX para salvar
	// 		fetch('/wp-admin/admin-ajax.php', {
	// 			method: 'POST',
	// 			headers: {
	// 				'Content-Type': 'application/x-www-form-urlencoded',
	// 			},
	// 			body: new URLSearchParams({
	// 				action: 'save_map_meta',
	// 				post_id: postId,
	// 				nome_completo: nomeCompleto,
	// 				data_nascimento: dataNascimento,
	// 			}),
	// 		})
	// 			.then((response) => response.json())
	// 			.then((data) => {
	// 				if (data.success) {
	// 					alert('Alterações salvas com sucesso!');
	// 					atualizarResultados(nomeCompleto, dataNascimento);
	// 				} else {
	// 					alert('Erro ao salvar as alterações 01.');
	// 				}
	// 			})
	// 			.catch((error) => {
	// 				console.error('Erro:', error);
	// 				alert('Erro ao salvar as alterações 02.');
	// 			});
	// 	});

	// Função para recalcular e atualizar os resultados
	// function atualizarResultados(nomeCompleto, dataNascimento) {
	// 	// Aqui você pode fazer uma nova chamada AJAX para recalcular os resultados
	// 	// e atualizar o DOM com os novos valores.
	// 	// Exemplo (isso seria substituído pela lógica de recalcular no PHP e atualizar o front):
	// 	document.getElementById('resultado-motivacao').textContent =
	// 		'Novo valor motivação';
	// 	document.getElementById('resultado-impressao').textContent =
	// 		'Novo valor impressão';
	// 	document.getElementById('resultado-expressao').textContent =
	// 		'Novo valor expressão';
	// 	document.getElementById('resultado-arcano').textContent =
	// 		'Novo valor arcano';
	// 	// Outros campos podem ser atualizados da mesma maneira.
	// }
});

// Função openPiramide deve estar fora do DOMContentLoaded
function openPiramide(evt, piramideName) {
	// Ocultar todas as pirâmides
	var i, tabLinks;

	piramideContainer = document.querySelectorAll('.piramide-container');
	piramideContainer.forEach((piramide) => {
		piramide.style.display = 'none';
	});

	// Remover classe "active" de todos os botões
	tabLinks = document.getElementsByClassName('tab-link');
	for (i = 0; i < tabLinks.length; i++) {
		tabLinks[i].className = tabLinks[i].className.replace(' active', '');
	}

	// Mostrar a pirâmide selecionada
	document.getElementById(piramideName).style.display = 'block';

	// Adicionar a classe "active" ao botão clicado
	evt.currentTarget.className += ' active';
}
