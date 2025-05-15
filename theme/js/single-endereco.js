jQuery(document).ready(($) => {
    document
        .getElementById('edit-endereco-form')
        .addEventListener('submit', function (e) {
            e.preventDefault();

            let data = new FormData(this); // Coleta todos os dados do formulário
            data.append('action', 'save_endereco_meta');
            data.append('security', single_endereco_ajax_obj.nonce); // Adiciona o nonce

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
                        // Exibe os dados salvos
                        console.log('Dados salvos:', response.data);
                        // Você pode atualizar a interface aqui com os dados salvos
                        // Exemplo: atualizar um elemento na página com os novos valores
                        $('#cep-display').text(response.data.cep);
                        $('#endereco-display').text(response.data.endereco);
                        $('#numero-display').text(response.data.numero);
                        $('#complemento-display').text(response.data.complemento);
                    } else {
                        console.error('Error response:', response.data);
                        alert(response.data); // Mostra mensagem de erro
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('Ocorreu um erro. Please try again.');
                },
            });
        });

});



