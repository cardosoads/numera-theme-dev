<?php
/* Template Name: Listagem de Mapas e Placas */

get_header();
$current_user_id = get_current_user_id();
$args = array(
    "type" => "Placas de Veículos e Telefones",
    "current_user_id" => $current_user_id,
    "query" => new WP_Query(
        array(
            'post_type' => array('placas'), // Incluindo os dois post types
            'author' => current_user_can('subscriber') ? $current_user_id : "",
            'posts_per_page' => -1, // Exibe todos os posts
        )
    )
);

get_template_part("template-parts/content/content-auth", "", $args);


// Lógica para processar a exclusão de mapas ou placas
if (isset($_POST['delete_item'])) {
    $item_id = intval($_POST['item_id']);

    // Verifica o nonce para segurança
    if (wp_verify_nonce($_POST['delete_item_nonce'], 'delete_item_' . $item_id)) {
        // Exclui o post (mapa ou placa)
        wp_delete_post($item_id, true);

        // Redireciona para a página atual para atualizar a listagem
        wp_redirect(get_permalink());
        exit;
    } else {
        echo '<p class="error">Falha ao verificar a solicitação de exclusão. Tente novamente.</p>';
    }
}

get_footer();
