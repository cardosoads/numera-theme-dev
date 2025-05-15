jQuery(document).ready(function ($) {
	document
		.getElementById('create-empresa-form')
		.addEventListener('submit', function (e) {
			e.preventDefault();

			let data = new FormData(this); // Coleta todos os dados do formulário
			data.append('action', 'create_empresa');
			data.append('security', empresa_ajax_obj.nonce); // Adiciona o nonce
			data.append('type', 'empresarial');

			$.ajax({
				url: empresa_ajax_obj.ajax_url,
				method: 'POST',
				data: data,
				contentType: false,
				processData: false,
				success: function (response) {
					console.log('Success response:', response);
					if (response.success) {
						console.log('Empresa criada com sucesso');
						window.location.href = response.data.redirect_url;
					} else {
						console.error('Error response:', response.data);
						alert(response.data); // Show error message
					}
				},
				error: function (xhr, status, error) {
					console.error('AJAX Error:', status, error);
					alert('An error occurred. Please try again.');
				},
			});
		});
});
