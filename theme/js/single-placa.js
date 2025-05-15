jQuery(document).ready(($) => {
    document
        .getElementById('edit-placa-form')
        .addEventListener('submit', function (e) {
            e.preventDefault();

            let data = new FormData(this); // Coleta todos os dados do formulário
            data.append('action', 'save_placa_meta');
            data.append('security', single_placa_ajax_obj.nonce); // Adiciona o nonce

            console.log(data);

            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                method: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log('Success response:', response);
                    if (response.success) {
                        alert('Alterações salvas com sucesso!');
                        console.log(data);
                        atualizarResultados(data, data.data_nascimento);
                    } else {
                        console.error('Error response:', response.data);
                        alert(response.data); // Show error message
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Ocorreu um erro. Please try again.');
                },
            });
        });

});



