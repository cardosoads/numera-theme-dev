<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the `#content` element and all content thereafter.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package numera_theme
 */

?>

	</div><!-- #content -->

	<?php get_template_part( 'template-parts/layout/footer', 'content' ); ?>

</div><!-- #page -->
<script>
    document.querySelectorAll('.closeModal').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            modal.classList.add('hidden');
        });
    });
</script>
<style>
    #offcanvas-menu{
        z-index: 9999!important;
    }
    .modal {
        z-index: 9999;
    }
    .modal-backdrop {
        z-index: 9998;
    }
    .modal-content {
        max-height: 80vh!important;
        overflow-y: scroll;
    }
    .closeModal{
        right: 20px!important;
    }
    @media (max-width: 1199px) {
        .grid {
            grid-template-columns: 1fr; /* Muda para uma única coluna */
        }
        .gap-8 {
            gap: 2rem; /* Reduz o espaçamento para 2rem */
        }
        .text-2xl {
            font-size: 1.5rem; /* Reduz o tamanho do texto */
        }
        .p-6 {
            padding: 1rem; /* Reduz o padding */
        }
        .md\:grid-cols-2 {
            grid-template-columns: 1fr; /* Sobrescreve a configuração de duas colunas em telas médias */
        }
        .sm\:grid-cols-2 {
            grid-template-columns: 1fr; /* Garante uma coluna em telas pequenas */
        }
        .lg\:grid-cols-3 {
            grid-template-columns: 1fr; /* Ajusta para uma coluna em layouts com 3 colunas */
        }
        .lg\:grid-cols-2 {
            grid-template-columns: 1fr; /* Ajusta para uma coluna em layouts com 2 colunas */
        }
        .lg\:grid-cols-4 {
            grid-template-columns: 1fr; /* Ajusta para uma coluna em layouts com 4 colunas */
        }
    }
</style>
<?php wp_footer(); ?>

</body>
</html>
