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