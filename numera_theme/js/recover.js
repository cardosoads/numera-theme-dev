jQuery(document).ready(function ($) {
    $('#recover-form').on('submit', function (e) {
        e.preventDefault();

        const email = $('#email').val();

        $.ajax({
            url: MyAjax.url, // URL definida no wp_localize_script
            type: 'POST',
            data: {
                action: 'custom_lostpassword',
                email: email,
            },
            success: function (response) {
                if (response.success) {
                    alert(response.data); // Mensagem de sucesso
                } else {
                    alert(response.data); // Mensagem de erro
                }
            },
            error: function () {
                alert('Erro ao processar a solicitação.');
            },
        });
    });
});