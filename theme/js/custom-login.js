jQuery(function ($) {
    // Abre o modal
    $('#open-recover').on('click', function (e) {
        e.preventDefault();
        $('#modal-backdrop, #recover-modal').show();
        $('#recover-msg').empty();
    });

    // Fecha com o botão ‘X’ ou com ‘Cancelar’
    $('#modal-close-btn, #close-recover').on('click', function () {
        $('#modal-backdrop, #recover-modal').hide();
        $('#recover-msg').empty();
    });

    // Envia AJAX
    $('#submit-recover').on('click', function (e) {
        e.preventDefault();
        var email = $('#recover-email').val().trim();
        if (!email) {
            return $('#recover-msg').text('Informe um e-mail.').css('color', 'red');
        }

        // Desabilita botões enquanto envia
        $('#submit-recover, #close-recover').prop('disabled', true);

        $.ajax({
            url: CustomLogin.ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'custom_lostpassword',
                email: email,
                _ajax_nonce: CustomLogin.nonce
            },
            success: function (res) {
                $('#recover-msg')
                    .text(res.data)
                    .css('color', res.success ? 'green' : 'red');

                // Remove os botões de ação
                $('#recover-actions').remove();
            },
            error: function (xhr, status, err) {
                console.error('AJAX Error:', status, err);
                $('#recover-msg').text('Erro no servidor.').css('color', 'red');
                // Reabilita se der erro
                $('#submit-recover, #close-recover').prop('disabled', false);
            }
        });
    });
});
  