<?php
/* Template Name: Listagem de Objetos */
extract($args);
$args = NULL;
?>

<div class="container mx-auto p-4">
	<div class="flex justify-between items-center gap-4">
		<h1 class="text-2xl text-right font-bold"><?php echo esc_html("Listagem de $type") ?></h1>
		<!-- Campo de busca -->
		<form id="search-map-form" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="flex w-full justify-between items-center">
			<input type="hidden" name="post_type" value="enderecos">
			<input type="text" id="search-endereco" name="s" placeholder="<?php echo "Buscar " . strtolower($type) . "..." ?>" class="px-6 py-4 border rounded-l-lg focus:outline-none w-full">
			<span class="dashicons dashicons-search absolute left-16"></span>
		</form>
	</div>

	<div id="mapas-list" class="bg-white shadow-md rounded-lg my-6">
		<table class="min-w-full bg-white">
			<thead>
				<tr>
					<th class="py-3 px-6 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Título</th>
					<th class="py-3 px-6 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Tipo</th>
					<th class="py-3 px-6 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Ações</th>
				</tr>
			</thead>
			<tbody id="mapas-table-body">
				<?php
				// Query para buscar tanto os mapas quanto as placas do usuário logado
				if ($query->have_posts()) :
					while ($query->have_posts()) : $query->the_post(); ?>
						<tr class="border-b">
							<td class="py-3 px-6 text-left">
                                <a href="<?php the_permalink(); ?>" class="text-gray-600 hover:text-gray-800">
                                    <?php the_title(); ?></td>
                                </a>
							<td class="py-3 px-6 text-center"><?php echo $type ?></td>
							<td class="py-3 px-6 text-center">
								<div class="flex justify-center space-x-4">
									<!-- Botão Editar -->
									<a href="<?php the_permalink(); ?>" class="text-gray-600 hover:text-gray-800">
										<span class="dashicons dashicons-edit"></span>
									</a>

									<!-- Botão Excluir -->
									<form method="post" action="" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
										<?php wp_nonce_field('delete_item_' . get_the_ID(), 'delete_item_nonce'); ?>
										<input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
										<button type="submit" name="delete_item" class="text-gray-600 hover:text-gray-800">
											<span class="dashicons dashicons-trash"></span>
										</button>
									</form>
								</div>
							</td>
						</tr>
					<?php endwhile;
				else : ?>
					<tr>
						<td class="py-3 px-6 text-center" colspan="3"><?php echo esc_html("Nenhum " . strtolower($type) . " encontrado.") ?></td>
					</tr>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
			</tbody>
		</table>
		<?php get_template_part("content-pagination") ?>
	</div>
</div>

<?php
// Lógica para processar a exclusão de mapas ou placas

get_footer();
