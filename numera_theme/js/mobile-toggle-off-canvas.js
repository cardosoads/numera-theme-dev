document.addEventListener('DOMContentLoaded', function () {
	if (window.innerWidth <= 1024) {
		document
			.getElementById('menu-toggle')
			.addEventListener('click', function () {
				document
					.getElementById('offcanvas-backdrop')
					.classList.remove('hidden');
				document
					.getElementById('offcanvas-menu')
					.classList.remove('-translate-x-full');
			});

		document
			.getElementById('close-menu')
			.addEventListener('click', function () {
				document
					.getElementById('offcanvas-menu')
					.classList.add('-translate-x-full');
				document
					.getElementById('offcanvas-backdrop')
					.classList.add('hidden');
			});

		document
			.getElementById('offcanvas-backdrop')
			.addEventListener('click', function () {
				document
					.getElementById('offcanvas-menu')
					.classList.add('-translate-x-full');
				document
					.getElementById('offcanvas-backdrop')
					.classList.add('hidden');
			});
	}

	// JavaScript to handle the popup modal for creating maps
	document
		.getElementById('create-map-button')
		.addEventListener('click', function () {
			document
				.getElementById('create-map-modal')
				.classList.remove('hidden');
		});
	document
		.getElementById('close-map-modal')
		.addEventListener('click', function () {
			document.getElementById('create-map-modal').classList.add('hidden');
		});

	document
		.getElementById('create-assinatura-button')
		.addEventListener('click', function () {
			document
				.getElementById('create-assinatura-modal')
				.classList.remove('hidden');
		});

		document
			.getElementById('close-assinatura-modal')
			.addEventListener('click', function () {
				document.getElementById('create-assinatura-modal').classList.add('hidden');
			});

	// JavaScript to handle the popup modal for creating placa e telefone
	document
		.getElementById('create-placa-button')
		.addEventListener('click', function () {
			document
				.getElementById('create-placa-modal')
				.classList.remove('hidden');
		});

	document
		.getElementById('close-placa-modal')
		.addEventListener('click', function () {
			document
				.getElementById('create-placa-modal')
				.classList.add('hidden');
		});

	// JavaScript to handle the popup modal for creating endereços
	document
		.getElementById('create-endereco-button')
		.addEventListener('click', function () {
			document
				.getElementById('create-endereco-modal')
				.classList.remove('hidden');
		});

	document
		.getElementById('close-endereco-modal')
		.addEventListener('click', function () {
			document
				.getElementById('create-endereco-modal')
				.classList.add('hidden');
		});

	// JavaScript to handle the popup modal for creating empresas
	document
		.getElementById('create-empresa-button')
		.addEventListener('click', function () {
			document
				.getElementById('create-empresa-modal')
				.classList.remove('hidden');
		});

	document
		.getElementById('close-empresa-modal')
		.addEventListener('click', function () {
			document
				.getElementById('create-empresa-modal')
				.classList.add('hidden');
		});
});
