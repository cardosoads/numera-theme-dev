<?php

/**
 * numera_theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package numera_theme
 */

if (! defined('NUMERA_THEME_VERSION')) {
	/*
     * Set the theme’s version number.
     *
     * This is used primarily for cache busting. If you use `npm run bundle`
     * to create your production build, the value below will be replaced in the
     * generated zip file with a timestamp, converted to base 36.
     */
	define('NUMERA_THEME_VERSION', '0.1.0');
}

if (! defined('NUMERA_THEME_TYPOGRAPHY_CLASSES')) {
	/*
     * Set Tailwind Typography classes for the front end, block editor and
     * classic editor using the constant below.
     *
     * For the front end, these classes are added by the `numera_theme_content_class`
     * function. You will see that function used everywhere an `entry-content`
     * or `page-content` class has been added to a wrapper element.
     *
     * For the block editor, these classes are converted to a JavaScript array
     * and then used by the `./javascript/block-editor.js` file, which adds
     * them to the appropriate elements in the block editor (and adds them
     * again when they’re removed.)
     *
     * For the classic editor (and anything using TinyMCE, like Advanced Custom
     * Fields), these classes are added to TinyMCE’s body class when it
     * initializes.
     */
	define(
		'NUMERA_THEME_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if (! function_exists('numera_theme_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function numera_theme_setup()
	{
		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on numera_theme, use a find and replace
         * to change 'numera_theme' to the name of your theme in all the template files.
         */
		load_theme_textdomain('numera_theme', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
		add_theme_support('title-tag');

		/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __('Primary', 'numera_theme'),
				'menu-2' => __('Footer Menu', 'numera_theme'),
			)
		);

		/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Enqueue editor styles.
		add_editor_style('style-editor.css');
		add_editor_style('style-editor-extra.css');

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		// Remove support for block templates.
		remove_theme_support('block-templates');
	}
endif;
add_action('after_setup_theme', 'numera_theme_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function numera_theme_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Footer', 'numera_theme'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your footer.', 'numera_theme'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'numera_theme_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function numera_theme_scripts()
{
	wp_enqueue_style('numera_theme-style', get_stylesheet_uri(), array(), NUMERA_THEME_VERSION);
	wp_enqueue_script('numera_theme-script', get_template_directory_uri() . '/js/script.min.js', array(), NUMERA_THEME_VERSION, true);

	wp_enqueue_script('mobile-toggle-off-canvas', get_theme_file_uri() . '/js/mobile-toggle-off-canvas.js', 10);

    

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'numera_theme_scripts');

/**
 * Enqueue the block editor script.
 */
function numera_theme_enqueue_block_editor_script()
{
	if (is_admin()) {
		wp_enqueue_script(
			'numera_theme-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			NUMERA_THEME_VERSION,
			true
		);
		wp_add_inline_script('numera_theme-editor', "tailwindTypographyClasses = '" . esc_attr(NUMERA_THEME_TYPOGRAPHY_CLASSES) . "'.split(' ');", 'before');
	}
}
add_action('enqueue_block_assets', 'numera_theme_enqueue_block_editor_script');

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function numera_theme_tinymce_add_class($settings)
{
	$settings['body_class'] = NUMERA_THEME_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter('tiny_mce_before_init', 'numera_theme_tinymce_add_class');

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

//--------------------------------------------------------------------------------------------------------------

function enqueue_dashicons()
{
	wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'enqueue_dashicons');

function enqueue_scripts()
{
	wp_enqueue_script('my-custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-placas', get_template_directory_uri() . '/js/ajax-placas.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-enderecos', get_template_directory_uri() . '/js/ajax-enderecos.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-empresas', get_template_directory_uri() . '/js/ajax-empresas.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-assinatura', get_template_directory_uri() . '/js/ajax-assinaturas.js', array('jquery'), null, true);
	wp_enqueue_script('ajax-single-posts', get_template_directory_uri() . '/js/ajax-single-posts.js', array('jquery'), null, true);

	if (is_home()) {
		wp_enqueue_script("template-map-search", get_theme_file_uri() . "/js/template-map-search.js");
	}

	if (is_single()) {
		wp_enqueue_style('single', get_theme_file_uri() . '/css/single.css');
	}

	if (is_singular('mapas')) {
		wp_enqueue_script("single-map", get_theme_file_uri() . "/js/single-mapa.js");
	}

	if (is_singular('placas')) {
		wp_enqueue_script("single-placa", get_theme_file_uri() . "/js/single-placa.js");
	}

	if (is_singular('enderecos')) {
		wp_enqueue_script("single-endereco", get_theme_file_uri() . "/js/single-endereco.js");
	}

	if (is_singular('empresarial')) {
		wp_enqueue_script("single-empresa", get_theme_file_uri() . "/js/single-empresarial.js");
	}

    if (is_singular('assinatura')) {
        wp_enqueue_script("single-assinatura", get_theme_file_uri() . "/js/single-assinatura.js");
    }
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');


require get_template_directory() . '/inc/Numerologia.php';

// Função para restringir o acesso a membros logados
function restrict_access_to_members()
{
	if (!is_user_logged_in() && !is_page('login')) {
		wp_redirect(site_url('/login/'));
		exit();
	}
}
add_action('template_redirect', 'restrict_access_to_members');

// Registro de posts customizados
require get_template_directory() . '/inc/custom-posts.php';

// Controla as requisições AJAX do tema
include get_theme_file_path() . "/inc/numera-ajax-requests.php";

require_once get_template_directory() . '/../vendor/autoload.php';
//require_once get_template_directory() . '/vendor/autoload.php';

include_once get_theme_file_path() . "/inc/handle-map-download.php";
include_once get_theme_file_path() . "/inc/handle-placa-download.php";
include_once get_theme_file_path() . "/inc/handle-endereco-download.php";
include_once get_theme_file_path() . "/inc/handle-empresarial-download.php";

// Função para bloquear o acesso ao admin para assinantes e redirecioná-los
function block_wp_admin_access()
{
	if (current_user_can('subscriber') && (is_admin() || strpos($_SERVER['PHP_SELF'], 'wp-login.php') !== false)) {
		if (defined('DOING_AJAX') && DOING_AJAX) {
			return; // Skip redirection for AJAX requests
		}

		if (is_user_logged_in() && strpos($_SERVER['REQUEST_URI'], 'wp-login.php?action=logout') !== false) {
			error_log("Logout process started.");
			return;
		}

		wp_redirect(home_url());
		exit;
	}
}
add_action('init', 'block_wp_admin_access');


// Função para remover a barra de administração para usuários não administradores
function remover_admin_bar_para_usuarios()
{
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}
add_action('init', 'remover_admin_bar_para_usuarios');

function enqueue_font_awesome() {
    // Enfileira o script do Font Awesome
    wp_enqueue_script(
        'font-awesome', // Handle do script
        'https://kit.fontawesome.com/a076d05399.js', // URL do script
        array(), // Dependências (nenhuma neste caso)
        null, // Versão (null para não versionar)
        false // Carregar no header (true para footer, false para header)
    );
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

/**
 * Registra a role "blocked_user" sem nenhuma capacidade de leitura.
 */
function register_blocked_user_role() {
    add_role(
        'blocked_user',             // slug da role
        'Blocked User',             // nome exibido
        []                          // array vazio: sem capacidades
    );
}
add_action( 'init', 'register_blocked_user_role' );

/**
 * Filtra a autenticação de usuário para bloquear logins de usuários com a role "blocked_user".
 *
 * @param WP_User|WP_Error $user     Objeto WP_User ou WP_Error de autenticações anteriores.
 * @param string           $password Senha fornecida no formulário de login.
 * @return WP_User|WP_Error          Retorna o usuário original ou um erro para bloquear o login.
 */
function block_user_role_login( $user, $password ) {
    // Se já houver erro anterior, mantém o erro
    if ( is_wp_error( $user ) ) {
        return $user;
    }

    // Verifica se o usuário possui a role "blocked_user"
    if ( in_array( 'blocked_user', (array) $user->roles, true ) ) {
        // Retorna erro personalizado; isso impede o login
        return new WP_Error(
            'blocked_user',
            __( 'Seu acesso está bloqueado. Entre em contato com o administrador.', 'seu-text-domain' )
        );
    }

    // Caso contrário, permite o login normalmente
    return $user;
}
add_filter( 'wp_authenticate_user', 'block_user_role_login', 10, 2 );

function redirect_after_failed_login( $username ) {
    $referrer = wp_get_referer();
    if ( ! empty( $referrer ) && ! str_contains( $referrer, 'wp-login.php' ) ) {
        // Redireciona para uma página customizada
        wp_redirect( home_url( '/acesso-bloqueado/' ) );
        exit;
    }
}
add_action( 'wp_login_failed', 'redirect_after_failed_login' );


function custom_acf_options_page_tabs()
{
?>
	<style>
		/* Estilo básico das abas */
		.acf-tab-nav {
			margin-bottom: 20px;
			display: flex;
			list-style: none;
		}

		.acf-tab-nav li {
			margin-right: 10px;
		}

		.acf-tab-nav li a {
			padding: 10px 15px;
			background: #f1f1f1;
			border: 1px solid #ccc;
			text-decoration: none;
			color: #0073aa;
		}

		.acf-tab-nav li a.active {
			background: #0073aa;
			color: #fff;
		}

		/* Esconde todas as seções por padrão */
		.acf-field-group {
			display: none;
		}

		/* Mostra a primeira seção ao carregar */
		.acf-field-group.active {
			display: block;
		}
	</style>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			// Cria a barra de navegação com abas
			var $groups = $('.acf-field-group');
			var $nav = $('<ul class="acf-tab-nav"></ul>');

			// Cria a navegação para cada grupo de campos
			$groups.each(function(index) {
				var groupTitle = $(this).find('h2').text(); // Captura o título do grupo de campos
				var groupId = 'acf-group-' + index;

				// Adiciona uma classe de identificador ao grupo
				$(this).attr('id', groupId);

				// Cria a aba e associa ao grupo
				var $tab = $('<li><a href="#" data-group="#' + groupId + '">' + groupTitle + '</a></li>');
				$nav.append($tab);
			});

			// Insere a navegação antes dos grupos
			$nav.insertBefore($groups.first());

			// Função de clique para alternar entre abas
			$nav.find('a').on('click', function(e) {
				e.preventDefault();

				// Remove a classe 'active' de todas as abas e grupos
				$nav.find('a').removeClass('active');
				$groups.removeClass('active');

				// Ativa a aba e o grupo selecionados
				$(this).addClass('active');
				$($(this).data('group')).addClass('active');
			});

			// Ativa a primeira aba e grupo ao carregar a página
			$nav.find('a').first().addClass('active');
			$groups.first().addClass('active');
		});
	</script>
<?php
}
add_action('admin_footer', 'custom_acf_options_page_tabs');

function adicionar_scripts_html2canvas() {
    wp_enqueue_script('html2canvas', 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js', array(), null, true);
    wp_enqueue_script('captura-script', get_template_directory_uri() . '/js/custom.js', array('jquery', 'html2canvas'), null, true);
}
add_action('wp_enqueue_scripts', 'adicionar_scripts_html2canvas');

function carregar_scripts_personalizados() {
    wp_enqueue_script('clipboard-script', get_template_directory_uri() . '/js/custom.js', array('html2canvas'), null, true);
}
add_action('wp_enqueue_scripts', 'carregar_scripts_personalizados');

function shortcode_areas_de_atuacao() {
    include_once __DIR__ . "/inc/NumerologiaDados.php";
    $dados = new NumerologiaDados();
    $areas = $dados->obterAreasDeAtuacao();
    $post_id = get_the_ID();

    // Recupera o valor salvo no meta do post
    $saved_area = get_post_meta($post_id, 'area_de_atuacao', true);

    ob_start();
    ?>
    <div class="w-full p-4 bg-white rounded-xl shadow-md border border-orange-300">
        <h2>Área de Atuação</h2>
        <div class="flex justify-between items-center w-full">
            <div class="w-1/2">
                <form id="save-area-form" method="post">
                    <input type="hidden" name="post_id" value="<?php echo esc_attr($post_id); ?>">
                    <input type="hidden" name="action" value="save_area">
                    <select id="areas" name="area_selecionada"
                            class="border border-purple-300 text-purple-700 bg-purple-50 rounded-full px-3 py-1 text-sm font-medium shadow-md w-full">
                        <option value="">Selecione...</option>
                        <?php foreach ($areas as $nome => $numeros) :
                            $option_value = implode(', ', $numeros);
                            $selected = ($saved_area === $option_value) ? 'selected' : '';
                            ?>
                            <option value="<?php echo esc_attr($option_value); ?>" <?php echo $selected; ?>>
                                <?php echo esc_html($nome); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
            <div class="w-1/2 p-3 bg-white border rounded-lg shadow text-lg font-semibold text-[#42265E] flex items-center justify-center ml-4" id="vibracoes">
                <?php echo $saved_area ? esc_html($saved_area) : 'Vibração'; ?>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("save-area-form");
            const select = document.getElementById("areas");
            const vibracoes = document.getElementById("vibracoes");

            // Função para enviar os dados via AJAX
            function saveArea() {
                const formData = new FormData(form);

                fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                    method: "POST",
                    credentials: "same-origin",
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            vibracoes.textContent = select.value ? select.value : "Vibração";
                            console.log("Área salva com sucesso!");
                        } else {
                            console.error("Erro ao salvar a área.");
                        }
                    })
                    .catch(error => {
                        console.error("Erro ao enviar os dados:", error);
                    });
            }

            // Dispara o salvamento no ato de selecionar
            select.addEventListener("change", function () {
                saveArea();
            });
        });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('areas_de_atuacao', 'shortcode_areas_de_atuacao');

function save_area_ajax_handler() {
    // Verifica se o post_id e a área foram enviados
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    $area = isset($_POST['area_selecionada']) ? sanitize_text_field($_POST['area_selecionada']) : '';

    if ($post_id && $area) {
        update_post_meta($post_id, 'area_de_atuacao', $area);
        wp_send_json_success();
    } else {
        wp_send_json_error();
    }
}
add_action('wp_ajax_save_area', 'save_area_ajax_handler');
add_action('wp_ajax_nopriv_save_area', 'save_area_ajax_handler');


// 1. Enfileirar e localizar script
function enqueue_custom_login_assets() {
    wp_enqueue_script(
        'custom-login-js',
        get_template_directory_uri() . '/js/custom-login.js',
        ['jquery'],
        null,
        true
    );
    wp_localize_script('custom-login-js', 'CustomLogin', [
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('custom_lostpassword_nonce'),
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_login_assets');

// 2. Definir o handler AJAX
function custom_lostpassword_ajax() {
    // 2.1. Validar nonce
    check_ajax_referer('custom_lostpassword_nonce', '_ajax_nonce');

    // 2.2. Validar e-mail
    if (empty($_POST['email']) || !is_email($_POST['email'])) {
        wp_send_json_error('Por favor, forneça um e-mail válido.');
    }

    // 2.3. Verificar usuário
    $email = sanitize_email($_POST['email']);
    $user  = get_user_by('email', $email);
    if (!$user) {
        wp_send_json_error('E-mail não cadastrado.');
    }

    // 2.4. Enviar link de recuperação
    $reset = retrieve_password($user->user_login);
    if (is_wp_error($reset)) {
        wp_send_json_error($reset->get_error_message());
    }

    // 2.5. Responder sucesso
    wp_send_json_success('Se as informações estiverem corretas, você receberá em breve um link de recuperação no seu e-mail.');
}

// 3. Registrar os hooks fora de qualquer template
add_action('wp_ajax_nopriv_custom_lostpassword', 'custom_lostpassword_ajax');
add_action('wp_ajax_custom_lostpassword',      'custom_lostpassword_ajax');
function bloquear_acesso_frontend_para_administradores() {
    // Só aplicar para usuários logados com papel 'administrator'
    if (
        is_user_logged_in() && 
        current_user_can('administrator') && 
        !is_admin() && 
        !wp_doing_ajax()
    ) {
        // Redireciona para o painel admin
        wp_redirect(admin_url());
        exit;
    }
}
add_action('template_redirect', 'bloquear_acesso_frontend_para_administradores');

// 1. Cria o papel "admin_system" com as capacidades de "administrator"
function criar_papel_admin_system() {
    if (!get_role('admin_system')) {
        add_role('admin_system', 'Administrador do Sistema', get_role('administrator')->capabilities);
    }

    // Garante que o papel tem as capacidades necessárias
    $role = get_role('admin_system');
    if ($role) {
        $role->add_cap('list_users');
        $role->add_cap('edit_users');
        $role->add_cap('create_users');
        $role->add_cap('delete_users');
        $role->add_cap('promote_users');
        $role->add_cap('remove_users');
    }
}
add_action('init', 'criar_papel_admin_system');


// 2. Redireciona do front-end para o painel
function bloquear_acesso_frontend_para_admin_system() {
    if (
        is_user_logged_in() &&
        current_user_can('admin_system') &&
        !is_admin() &&
        !wp_doing_ajax()
    ) {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('template_redirect', 'bloquear_acesso_frontend_para_admin_system');

// 3. Remove menus do admin para admin_system
function remover_menus_para_admin_system() {
    if (current_user_can('admin_system')) {
        remove_menu_page('edit.php');                   // Posts
        remove_menu_page('upload.php');                 // Mídia
        remove_menu_page('edit.php?post_type=page');    // Páginas
        remove_menu_page('edit-comments.php');          // Comentários
        remove_menu_page('themes.php');                 // Aparência
        remove_menu_page('plugins.php');                // Plugins
        remove_menu_page('simple_history_admin_menu_page');                  // Usuários
        remove_menu_page('tools.php');                  // Ferramentas
        remove_menu_page('options-general.php');        // Configurações
		remove_menu_page('wpstg_clone');      // WP Staging
        remove_menu_page('edit.php?post_type=acf-field-group'); // ACF
        remove_menu_page(menu_slug: 'integromat');      // Make (se for o slug correto)
        remove_menu_page(menu_slug: 'full-connection');      // Make (se for o slug correto)
		remove_menu_page('edit.php?post_type=mapas');
		remove_menu_page('edit.php?post_type=textos-do-site');
		remove_menu_page('edit.php?post_type=placas');
		remove_menu_page('edit.php?post_type=empresarial');
		remove_menu_page('edit.php?post_type=enderecos');
		remove_menu_page('edit.php?post_type=assinatura');
     // WP Rocket
    }
}
add_action('admin_menu', 'remover_menus_para_admin_system', 999);

// 4. Impede acessos diretos às páginas bloqueadas
function bloquear_acessos_diretos_para_admin_system() {
    if (
        current_user_can('admin_system') &&
        is_admin() &&
        !defined('DOING_AJAX')
    ) {
        $telas_bloqueadas = [
            'plugins.php',
            'themes.php',
            // 'users.php', era aqui porém eu ainda consigo editar o Admininstrador padrão
            'tools.php',
            'options-general.php',
            'edit.php',
            'upload.php',
            'edit-comments.php',
        ];

        $pagina_atual = basename($_SERVER['PHP_SELF']);
        if (in_array($pagina_atual, $telas_bloqueadas)) {
            wp_die('Você não tem permissão para acessar esta página.');
        }
    }
}
add_action('admin_init', 'bloquear_acessos_diretos_para_admin_system');
function restringir_acoes_em_administradores($allcaps, $caps, $args, $user) {
    // Verifica se está tentando editar algum usuário
    if (isset($args[2])) {
        $target_user = get_userdata($args[2]);

        // Se o usuário de destino for um administrador padrão
        if ($target_user && in_array('administrator', $target_user->roles)) {
            // E se quem está tentando editar é um admin_system
            if (in_array('admin_system', $user->roles)) {
                foreach (['edit_user', 'delete_user', 'remove_user', 'promote_user'] as $cap) {
                    if (in_array($cap, $caps)) {
                        $allcaps[$cap] = false;
                    }
                }
            }
        }
    }

    return $allcaps;
}
add_filter('user_has_cap', 'restringir_acoes_em_administradores', 10, 4);
function ocultar_administradores_na_lista($query) {
    if (!current_user_can('administrator') && is_admin() && $query->get('post_type') === '') {
        global $pagenow;
        if ($pagenow == 'users.php') {
            $meta_query = [
                [
                    'key'     => $query->get('meta_key'),
                    'value'   => 'administrator',
                    'compare' => 'NOT LIKE'
                ]
            ];
            $query->set('meta_query', $meta_query);
        }
    }
}
add_action('pre_get_users', 'ocultar_administradores_na_lista');
function bloquear_edicao_administrador_padrao() {
    if (
        is_admin() &&
        current_user_can('admin_system') &&
        isset($_GET['user_id'])
    ) {
        $user_id = intval($_GET['user_id']);
        $target_user = get_userdata($user_id);

        if ($target_user && in_array('administrator', $target_user->roles)) {
            wp_die('Você não tem permissão para editar este usuário.');
        }
    }
}
add_action('admin_init', 'bloquear_edicao_administrador_padrao');
function remover_menu_novo_admin_bar($wp_admin_bar) {
    if (current_user_can('admin_system')) {
        $wp_admin_bar->remove_node('new-content'); // Remove o menu "Novo"
        $wp_admin_bar->remove_node('comments'); // Remove o menu "Novo"
        $wp_admin_bar->remove_node('simple-history'); // Remove o menu "Novo"
    }
}
add_action('admin_bar_menu', 'remover_menu_novo_admin_bar', 999);

remove_action('admin_notices', 'fc-notice');
function esconder_notice_fc_com_js() {
    if (current_user_can('admin_system')) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            var aviso = document.getElementById('fc-notice');
            if (aviso) {
                aviso.style.display = 'none';
            }
        });
        </script>
        <?php
    }
}
add_action('admin_footer', 'esconder_notice_fc_com_js');

// functions.php

// 1) Função que processa a exclusão via AJAX
add_action('wp_ajax_delete_endereco_via_ajax', 'delete_endereco_via_ajax');
function delete_endereco_via_ajax() {
    // Verifica nonce
    if (
        empty($_POST['nonce']) ||
        !wp_verify_nonce($_POST['nonce'], 'delete_item_' . intval($_POST['item_id']))
    ) {
        wp_send_json_error(['message' => 'Falha ao validar segurança.']);
    }

    $post_id = intval($_POST['item_id']);
    // Tenta apagar o post (endereços)
    $deleted = wp_delete_post($post_id, true);

    if ($deleted) {
        wp_send_json_success(['message' => 'Item removido com sucesso.']);
    } else {
        wp_send_json_error(['message' => 'Não foi possível remover o item.']);
    }
}

// 2) Enfileirar o script JavaScript
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_script(
        'listagem-enderecos-ajax',
        get_stylesheet_directory_uri() . '/js/listagem-enderecos-ajax.js',
        ['jquery'],
        '1.0',
        true
    );
    // Passa a URL do AJAX e o nonce base
    wp_localize_script('listagem-enderecos-ajax', 'ListagemEnderecosAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        // O nonce vai ser gerado dinamicamente dentro de cada form, veja abaixo.
    ]);
});
