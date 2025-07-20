jQuery(document).ready(function ($) {
	document
		.getElementById('create-assinatura-form')
		.addEventListener('submit', function (e) {
			e.preventDefault();

			let data = new FormData(this); // Coleta todos os dados do formulário
			data.append('action', 'create_assinatura');
			data.append('security', assinatura_ajax_obj.nonce); // Adiciona o nonce
			data.append('type', 'assinatura');

			$.ajax({
				url: assinatura_ajax_obj.ajax_url,
				method: 'POST',
				data: data,
				contentType: false,
				processData: false,
				success: function (response) {
					console.log(response);
					if (response.success) {
						console.log('Analise criada com sucesso');
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
