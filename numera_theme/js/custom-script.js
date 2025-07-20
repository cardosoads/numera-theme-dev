jQuery(document).ready(function ($) {
	document.getElementById('create-map-form').addEventListener('submit', function (e) {
		e.preventDefault();

		let data = new FormData(this); // Coleta todos os dados do formulário
		data.append('action', 'create_map');
		data.append('security', my_ajax_obj.nonce); // Adiciona o nonce
		data.append('type', 'mapas');

		$.ajax({
			url: my_ajax_obj.ajax_url,
			method: 'POST',
			data: data,
			contentType: false,
			processData: false,
			success: function (response) {
				console.log('Success response:', response);
				if (response.success) {
					console.log('Map created successfully');
					console.log(response);
					// Redireciona o usuário para a url estabelecida na resposta em numera-ajax-requests.php
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
