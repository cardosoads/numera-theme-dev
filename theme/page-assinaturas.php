<?php
/* Template Name: Listagem de Assinaturas */

get_header();

$current_user_id = get_current_user_id();
$query = new WP_Query(array(
	'post_type' => array('assinatura'), // Incluindo os dois post types
	'author' => current_user_can('subscriber') ? $current_user_id : "",
	'posts_per_page' => -1, // Exibe todos os posts
));

$args = array(
	"type" => "Assinaturas",
	"current_user_id" => $current_user_id,
	"query" => $query
);


get_template_part("template-parts/content/content-auth", "", $args);

get_footer();
