<?php
/**
 * The template for displaying archive pages for Mapas
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package numera_theme
 */

get_header(); ?>

<div class="container mx-auto p-4">
	<div class="flex justify-between items-center gap-4">
		<h1 class="text-2xl text-right font-bold">
			<?php post_type_archive_title(); ?>
		</h1>
		<!-- Campo de busca -->
		<form id="search-map-form" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex w-full justify-between items-center">
			<input type="hidden" name="post_type" value="mapas">
			<input type="text" id="search-map" name="s" placeholder="Buscar Mapas..." class="px-6 py-4 border rounded-l-lg focus:outline-none w-full">
			<span class="dashicons dashicons-search absolute left-16"></span>
		</form>
	</div>
	<div id="mapas-list">
		<?php if ( have_posts() ) : ?>
			<table class="min-w-full bg-white shadow-md rounded-lg">
				<thead>
				<tr>
					<th class="py-3 px-6 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Título</th>
					<th class="py-3 px-6 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Ações</th>
				</tr>
				</thead>
				<tbody id="mapas-table-body">
				<?php while ( have_posts() ) : the_post(); ?>
					<tr class="border-b">
						<td class="py-3 px-6 text-left"><?php the_title(); ?></td>
						<td class="py-3 px-6 text-center">
							<div class="flex justify-center space-x-4">
								<!-- Botão Editar -->
								<a href="<?php echo esc_url(get_permalink(get_the_ID())); ?>" class="text-gray-600 hover:text-gray-800">
									<span class="dashicons dashicons-edit"></span>
								</a>

								<!-- Botão Baixar -->
								<a href="" class="text-gray-600 hover:text-gray-800">
									<span class="dashicons dashicons-download"></span>
								</a>

								<!-- Botão Excluir -->
								<form method="post" action="" onsubmit="return confirm('Tem certeza que deseja excluir este mapa?');" class="inline">
									<?php wp_nonce_field('delete_mapa_' . get_the_ID(), 'delete_mapa_nonce'); ?>
									<input type="hidden" name="mapa_id" value="<?php echo get_the_ID(); ?>">
									<button type="submit" name="delete_mapa" class="text-gray-600 hover:text-gray-800">
										<span class="dashicons dashicons-trash"></span>
									</button>
								</form>
							</div>
						</td>
					</tr>
				<?php endwhile; ?>
				</tbody>
			</table>

			<div class="pagination mt-8">
				<?php
				// Paginação
				the_posts_pagination(array(
					'mid_size'  => 2,
					'prev_text' => __('&laquo; Anterior', 'numera_theme'),
					'next_text' => __('Próximo &raquo;', 'numera_theme'),
				));
				?>
			</div>

		<?php else : ?>

			<p><?php _e( 'Nenhum mapa encontrado.', 'numera_theme' ); ?></p>

		<?php endif; ?>
	</div><!-- #mapas-list -->
</div><!-- .container -->

<?php
// Lógica para processar a exclusão do mapa
if (isset($_POST['delete_mapa'])) {
	$mapa_id = intval($_POST['mapa_id']);

	// Verifica o nonce para segurança
	if (wp_verify_nonce($_POST['delete_mapa_nonce'], 'delete_mapa_' . $mapa_id)) {
		// Exclui o post (mapa)
		wp_delete_post($mapa_id, true);

		// Redireciona para a página de arquivos de mapas para atualizar a listagem
		wp_redirect(get_post_type_archive_link('mapas'));
		exit;
	} else {
		// Se o nonce não for verificado, exibe uma mensagem de erro (opcional)
		echo '<p class="error">Falha ao verificar a solicitação de exclusão. Tente novamente.</p>';
	}
}

get_footer();
?>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const searchInput = document.getElementById('search-map');
		const mapsList = document.getElementById('mapas-list');

		searchInput.addEventListener('input', function() {
			const searchTerm = searchInput.value;

			// Faz a requisição AJAX para buscar os mapas
			fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=search_mapas&s=' + searchTerm)
				.then(response => response.text())
				.then(data => {
					mapsList.innerHTML = data;
				})
				.catch(error => console.error('Erro ao buscar mapas:', error));
		});
	});
</script>
