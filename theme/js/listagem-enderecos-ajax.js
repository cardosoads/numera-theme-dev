(function($) {
    $(document).ready(function() {
        // Ao clicar no botão de excluir
        $('#mapas-table-body').on('click', '.delete-item-button', function(e) {
            e.preventDefault();

            if (!confirm('Tem certeza que deseja excluir este item?')) {
                return;
            }

            var button = $(this);
            var itemId = button.data('item-id');
            var nonce  = button.data('nonce');

            // Desabilita o botão enquanto processa
            button.prop('disabled', true);

            $.ajax({
                url: ListagemEnderecosAjax.ajax_url,
                method: 'POST',
                dataType: 'json',
                data: {
                    action: 'delete_endereco_via_ajax',
                    item_id: itemId,
                    nonce: nonce
                }
            })
            .done(function(response) {
                if (response.success) {
                    // Remove a linha da tabela
                    button.closest('tr').fadeOut(200, function() {
                        $(this).remove();
                    });
                } else {
                    alert('Erro ao excluir: ' + response.data.message);
                    button.prop('disabled', false);
                }
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                alert('Falha na requisição AJAX: ' + textStatus);
                button.prop('disabled', false);
            });
        });
    });
})(jQuery);
