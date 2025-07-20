jQuery(document).ready(($) => {
    document
        .getElementById('edit-empresa-form')
        .addEventListener('submit', function (e) {
            e.preventDefault();

            let data = new FormData(this); // Coleta todos os dados do formulário
            data.append('action', 'save_empresa_meta');
            data.append('security', single_empresa_ajax_obj.nonce); // Adiciona o nonce

            // Verifique se o post_id está presente
            console.log('post_id:', data.get('post_id'));

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
                        // Exibe os dados salvos
                        console.log('Dados salvos:', response.data);
                        // Atualizar a interface com os novos valores
                        $('#razao_social').text(response.data.razao_social);
                        $('#nome_fantasia').text(response.data.nome_fantasia);
                        $('#data_abertura').text(response.data.data_abertura);
                        $('#data_alteracao').text(response.data.data_alteracao);
                    } else {
                        console.error('Error response:', response.data);
                        alert(response.data ? response.data : 'Erro ao salvar os dados.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Ocorreu um erro. Tente novamente.');
                },
            });
        });
});
