<?php
function enqueue_ajax_scripts()
{
    // Localize script para passar o nonce ao JavaScript
    wp_localize_script('my-custom-script', 'my_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('create_map_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_scripts');

// Função para criar um novo mapa via AJAX
function create_map_ajax_handler()
{
    // Verifique o nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'create_map_nonce')) {
        wp_send_json_error('Verificação de segurança falhou, por favor tente novamente.');
        wp_die();
    }

    // Verifique a permissão do usuário atual
    if (!current_user_can('edit_mapas')) {
        wp_send_json_error('Você não tem permissão para criar mapas.');
        wp_die();
    }

    // Obtenha os dados do formulário
    $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
    $name  = isset($_POST['name'])  ? sanitize_text_field($_POST['name'])  : '';
    $dob   = isset($_POST['dob'])   ? sanitize_text_field($_POST['dob'])   : '';

    // Verificações obrigatórias
    if (empty($title) || empty($name) || empty($dob)) {
        wp_send_json_error('Todos os campos obrigatórios devem ser preenchidos.');
        wp_die();
    }

    // Remover traços da data (formato yyyy-mm-dd para yyyymmdd)
    $dob = str_replace('-', '', $dob);

    // Verifique se já existe um mapa com o mesmo título
    // if (postExists($title, 'mapas')) {
    //     wp_send_json_error('Já existe um mapa com este título. Por favor, escolha um título diferente.');
    //     wp_die();
    // }

    // Criar o post do tipo 'mapas'
    $data = array(
        'post_title'  => $title,
        'post_type'   => 'mapas',
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
    );

    $map_id = wp_insert_post($data);

    if (is_wp_error($map_id) || $map_id === 0) {
        wp_send_json_error([
            'msg' => 'Erro ao criar o mapa.',
            'map_id' => $map_id
        ]);
        wp_die();
    }

    // Salvar metadados
    update_post_meta($map_id, 'mapas_details__mapas_nome_completo', $name);
    update_post_meta($map_id, 'mapas_details__mapas_data_nascimento', $dob);

    // Sucesso
    wp_send_json_success([
        'redirect_url' => get_permalink($map_id),
    ]);

    wp_die();
}
add_action('wp_ajax_create_map', 'create_map_ajax_handler', 1);

function enqueue_ajax_placas_scripts()
{
    // Localize script para passar o nonce ao JavaScript
    wp_localize_script('ajax-placas', 'placa_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('create_placas_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_placas_scripts');

// Função para criar uma nova placa via AJAX
function create_placa_ajax_handler()
{
    // Verifique o nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'create_placas_nonce')) {
        wp_send_json_error('Verificação de segurança falhou, por favor tente novamente.');
        wp_die();
    }

    // Verifique a permissão do usuário atual
    if (!current_user_can('edit_placas')) {
        wp_send_json_error('Você não tem permissão para criar placas.');
        wp_die();
    }

    // Obtenha e sanitize os dados
    $title           = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
    $dob             = isset($_POST['dob']) ? sanitize_text_field($_POST['dob']) : '';
    $numero_telefone = isset($_POST['numero_telefone']) ? sanitize_text_field($_POST['numero_telefone']) : '';
    $placa_veiculo   = isset($_POST['placa_veiculo']) ? sanitize_text_field($_POST['placa_veiculo']) : '';

    // Valide os campos obrigatórios
    if (empty($title) || empty($dob) || empty($numero_telefone) || empty($placa_veiculo)) {
        wp_send_json_error('Preencha todos os campos obrigatórios.');
        wp_die();
    }

    // Limpe a data de nascimento (remove traços, por exemplo)
    $dob = str_replace('-', '', $dob);

    // Verifique se já existe uma placa com o mesmo título
    // $existing_placa = postExists($title, 'placas');

    // if ($existing_placa) {
    //     wp_send_json_error('Já existe uma placa com este título. Por favor, escolha um título diferente.');
    //     wp_die();
    // }

    // Crie o post do tipo 'placas'
    $placa_id = wp_insert_post(array(
        'post_title'  => $title,
        'post_type'   => 'placas',
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
    ));

    if (is_wp_error($placa_id) || $placa_id === 0) {
        wp_send_json_error('Erro ao criar a placa.');
        wp_die();
    }

    // Adicione os metadados ao post criado
    update_post_meta($placa_id, 'placas_details__placas_data_nascimento', $dob);
    update_post_meta($placa_id, 'placas_details__placas_numero_telefone', $numero_telefone);
    update_post_meta($placa_id, 'placas_details__placas_placa_veiculo', $placa_veiculo);

    wp_send_json_success(array(
        'redirect_url' => get_permalink($placa_id),
    ));

    wp_die();
}
add_action('wp_ajax_create_placa', 'create_placa_ajax_handler');

// Localize script para passar o nonce ao JavaScript
function enqueue_endereco_ajax_scripts()
{
    wp_localize_script('ajax-enderecos', 'endereco_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('create_endereco_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_endereco_ajax_scripts');

// Função para criar um novo mapa via AJAX

function create_endereco_ajax_handler()
{
    // Verifique o nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'create_endereco_nonce')) {
        wp_send_json_error('Verificação de segurança falhou, por favor tente novamente.');
        wp_die();
    }

    // Verifique a permissão do usuário atual
    if (!current_user_can('edit_mapas')) {
        wp_send_json_error('Você não tem permissão para criar endereços.');
        wp_die();
    }

    // Obtenha e valide os dados
    $cep         = isset($_POST['cep']) ? sanitize_text_field($_POST['cep']) : '';
    $endereco    = isset($_POST['endereco']) ? sanitize_text_field($_POST['endereco']) : '';
    $numero      = isset($_POST['numero']) ? sanitize_text_field($_POST['numero']) : '';
    $complemento = isset($_POST['complemento']) ? sanitize_text_field($_POST['complemento']) : '';
    $type        = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';

    // Verificação de campos obrigatórios
    if (empty($cep) || empty($endereco) || empty($numero) || empty($type)) {
        wp_send_json_error('Preencha todos os campos obrigatórios.');
        wp_die();
    }

    // Crie o post do tipo 'endereco'
    $data = array(
        'post_title'  => $endereco,
        'post_type'   => $type,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
    );

    $novo_endereco = wp_insert_post($data);

    if (is_wp_error($novo_endereco) || $novo_endereco === 0) {
        wp_send_json_error(["msg" => 'Erro ao criar o endereço.', "endereco_id" => $novo_endereco]);
        wp_die();
    }

    // Adicione os metadados ao post criado
    update_post_meta($novo_endereco, 'cep', $cep);
    update_post_meta($novo_endereco, 'endereco', $endereco);
    update_post_meta($novo_endereco, 'numero', $numero);
    update_post_meta($novo_endereco, 'complemento', $complemento);

    wp_send_json_success(array(
        'redirect_url' => get_permalink($novo_endereco),
    ));

    wp_die();
}
add_action('wp_ajax_create_endereco', 'create_endereco_ajax_handler', 1);

function enqueue_empresa_ajax_scripts()
{
    wp_localize_script('ajax-empresas', 'empresa_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('create_empresa_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_empresa_ajax_scripts');

function create_empresa_ajax_handler()
{
    // Verifique o nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'create_empresa_nonce')) {
        wp_send_json_error('Verificação de segurança falhou, por favor tente novamente.');
        wp_die();
    }

    // Verifique a permissão do usuário atual
    if (!current_user_can('edit_mapas')) {
        wp_send_json_error('Você não tem permissão para criar mapas.');
        wp_die();
    }

    // Obtenha e valide os dados
    $razao_social   = isset($_POST['razao_social']) ? sanitize_text_field($_POST['razao_social']) : '';
    $nome_fantasia  = isset($_POST['nome_fantasia']) ? sanitize_text_field($_POST['nome_fantasia']) : '';
    $data_abertura  = isset($_POST['data_abertura']) ? sanitize_text_field($_POST['data_abertura']) : '';
    $data_alteracao = isset($_POST['data_alteracao']) ? sanitize_text_field($_POST['data_alteracao']) : '';
    $type           = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : '';

    // Verificação obrigatória dos campos
    if (empty($razao_social) || empty($nome_fantasia) || empty($type)) {
        wp_send_json_error('Preencha todos os campos obrigatórios.');
        wp_die();
    }

    // Crie o post do tipo 'empresa'
    $data = array(
        'post_title'  => $razao_social,
        'post_type'   => $type,
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
    );

    $nova_empresa = wp_insert_post($data);

    if (is_wp_error($nova_empresa) || $nova_empresa === 0) {
        wp_send_json_error([
            "msg" => 'Erro ao criar a empresa.',
            "empresa_id" => $nova_empresa
        ]);
        wp_die();
    }

    // Adicione os metadados
    update_post_meta($nova_empresa, 'razao_social', $razao_social);
    update_post_meta($nova_empresa, 'nome_fantasia', $nome_fantasia);
    update_post_meta($nova_empresa, 'data_abertura', $data_abertura);
    update_post_meta($nova_empresa, 'data_alteracao', $data_alteracao);

    wp_send_json_success([
        'redirect_url' => get_permalink($nova_empresa),
    ]);

    wp_die();
}
add_action('wp_ajax_create_empresa', 'create_empresa_ajax_handler', 1);

function enqueue_assinatura_ajax_scripts()
{
    wp_localize_script('ajax-assinatura', 'assinatura_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('create_assinatura_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_assinatura_ajax_scripts');

function create_assinatura_ajax_handler()
{
    // Verifique o nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'create_assinatura_nonce')) {
        wp_send_json_error('Verificação de segurança falhou, por favor tente novamente.');
        wp_die();
    }

    // Verifique a permissão do usuário atual
    if (!current_user_can('edit_assinatura')) {
        wp_send_json_error('Você não tem permissão para criar Análises.');
        wp_die();
    }

    // Obtenha os dados do formulário com validação
    $title = isset($_POST['title']) ? sanitize_text_field($_POST['title']) : '';
    $name  = isset($_POST['name'])  ? sanitize_text_field($_POST['name'])  : '';
    $dob   = isset($_POST['dob'])   ? sanitize_text_field($_POST['dob'])   : '';

    if (empty($title) || empty($name) || empty($dob)) {
        wp_send_json_error('Todos os campos obrigatórios devem ser preenchidos.');
        wp_die();
    }

    // Formatando a data
    $dob = str_replace('-', '', $dob);

    // Verifique se já existe um post com o mesmo título
    // $existing_assinatura = postExists($title, 'assinatura');

    // if ($existing_assinatura) {
    //     wp_send_json_error('Já existe uma análise com este título. Por favor, escolha um título diferente.');
    //     wp_die();
    // }

    // Crie o post do tipo 'assinatura'
    $data = array(
        'post_title'  => $title,
        'post_type'   => 'assinatura',
        'post_status' => 'publish',
        'post_author' => get_current_user_id(),
    );

    $assinatura_id = wp_insert_post($data);

    if (is_wp_error($assinatura_id) || $assinatura_id === 0) {
        wp_send_json_error([
            "msg" => 'Erro ao criar a análise.',
            "assinatura_id" => $assinatura_id
        ]);
        wp_die();
    }

    // Adicione os metadados ao post criado
    update_post_meta($assinatura_id, '_nome_completo', $name);
    update_post_meta($assinatura_id, '_data_nascimento', $dob);

    wp_send_json_success([
        'redirect_url' => get_permalink($assinatura_id),
    ]);

    wp_die();
}
add_action('wp_ajax_create_assinatura', 'create_assinatura_ajax_handler', 1);

// Funções de Salvamento
function save_assinatura_ajax_scripts()
{
    wp_localize_script('single-assinatura', 'single_assinatura_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('save_assinatura_nonce')
    ));
} // single_assinatura_ajax_obj
add_action('wp_enqueue_scripts', 'save_assinatura_ajax_scripts');

function save_map_ajax_scripts()
{
    wp_localize_script('single-map', 'single_map_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('save_map_nonce')
    ));
} // single_map_ajax_obj
add_action('wp_enqueue_scripts', 'save_map_ajax_scripts');

function save_placa_ajax_scripts()
{
    wp_localize_script('single-placa', 'single_placa_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('save_placa_nonce')
    ));
} // single_placa_ajax_obj
add_action('wp_enqueue_scripts', 'save_placa_ajax_scripts');

function save_endereco_ajax_scripts()
{
    wp_localize_script('single-endereco', 'single_endereco_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('save_endereco_nonce')
    ));
} // single_endereco_ajax_obj
add_action('wp_enqueue_scripts', 'save_endereco_ajax_scripts');

function save_empresa_ajax_scripts()
{
    wp_localize_script('single-empresa', 'single_empresa_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('save_empresa_nonce')
    ));
} // single_empresa_ajax_obj
add_action('wp_enqueue_scripts', 'save_empresa_ajax_scripts');

// Função para salvar os metadados dos mapas pelo form no front
function save_assinatura_meta()
{
    check_ajax_referer('save_assinatura_nonce', 'security');

    $post_id = intval($_POST['post_id']);
    $nome_completo = sanitize_text_field($_POST['nome_completo']);
    $data_nascimento = sanitize_text_field($_POST['data_nascimento']);
    $data_nascimento = str_replace('-','', $data_nascimento);

    // // Atualiza os campos personalizados
    update_post_meta($post_id, '_nome_completo', $nome_completo);
    update_post_meta($post_id, '_data_nascimento', $data_nascimento);

    wp_send_json_success(array('message' => 'Análise salva com sucesso!'));

    // wp_send_json_success($data_nascimento);

    wp_die();
} // Salvar Mapas
add_action('wp_ajax_save_assinatura_meta', 'save_assinatura_meta');


function salvar_meta_mapas()
{
    check_ajax_referer('save_map_nonce', 'security');

    $post_id = intval($_POST['post_id']);
    $nome_completo = sanitize_text_field($_POST['nome_completo']);
    $data_nascimento = sanitize_text_field($_POST['data_nascimento']);
    $data_nascimento = str_replace('-','', $data_nascimento);

    // // Atualiza os campos personalizados
    update_post_meta($post_id, 'mapas_details__mapas_nome_completo', $nome_completo);
    update_post_meta($post_id, 'mapas_details__mapas_data_nascimento', $data_nascimento);

    wp_send_json_success(array('message' => 'Mapa salvo com sucesso!'));

    // wp_send_json_success($data_nascimento);

    wp_die();
} // Salvar Mapas
add_action('wp_ajax_save_map_meta', 'salvar_meta_mapas');

function salvar_meta_placas()
{
    check_ajax_referer('save_placa_nonce', 'security');

    // Debug: verificar os dados recebidos
    error_log(print_r($_POST, true)); // Registra os dados recebidos para análise

    $post_id = intval($_POST['post_id']);
    $data_nascimento = sanitize_text_field($_POST['data_nascimento']);
    $numero_telefone = preg_replace('/\D/', '', sanitize_text_field($_POST['numero_telefone']));
    $placa_veiculo = sanitize_text_field($_POST['placa_veiculo']);

    // Atualiza os campos personalizados
    update_post_meta($post_id, 'placas_details__placas_data_nascimento', $data_nascimento);
    update_post_meta($post_id, 'placas_details__placas_numero_telefone', $numero_telefone);
    update_post_meta($post_id, 'placas_details__placas_placa_veiculo', $placa_veiculo);

    wp_send_json_success(array('message' => 'Placa salva com sucesso!'));

    wp_die();
} // Salvar Placas
add_action('wp_ajax_save_placa_meta', 'salvar_meta_placas');

function salvar_meta_enderecos() {
    check_ajax_referer('save_endereco_nonce', 'security');

    // Debug: verificar os dados recebidos
    error_log(print_r($_POST, true)); // Registra os dados recebidos para análise

    $post_id = intval($_POST['post_id']);
    $cep = sanitize_text_field($_POST['cep']);
    $endereco = sanitize_text_field($_POST['endereco']);
    $numero = sanitize_text_field($_POST['numero']);
    $complemento = sanitize_text_field($_POST['complemento']); // Correção aqui

    // Atualiza os campos personalizados
    update_post_meta($post_id, 'cep', $cep);
    update_post_meta($post_id, 'endereco', $endereco);
    update_post_meta($post_id, 'numero', $numero);
    update_post_meta($post_id, 'complemento', $complemento);

    // Prepare the response with saved data
    $response_data = array(
        'message' => 'Endereço salvo com sucesso!',
        'data' => array(
            'cep' => $cep,
            'endereco' => $endereco,
            'numero' => $numero,
            'complemento' => $complemento,
        ),
    );

    wp_send_json_success($response_data);

    wp_die();
} // Salvar Endereços
add_action('wp_ajax_save_endereco_meta', 'salvar_meta_enderecos');

function save_empresa_meta() {
    check_ajax_referer('save_empresa_nonce', 'security');

    $post_id = intval($_POST['post_id']);

    if ($post_id <= 0) {
        wp_send_json_error('ID do post inválido.');
        wp_die();
    }

    // Processar os outros campos
    $razao_social = sanitize_text_field($_POST['razao_social']);
    $nome_fantasia = sanitize_text_field($_POST['nome_fantasia']);
    $data_abertura = sanitize_text_field($_POST['data_abertura']);
    $data_alteracao = sanitize_text_field($_POST['data_alteracao']);

    // Atualiza os campos personalizados
    update_post_meta($post_id, 'razao_social', $razao_social);
    update_post_meta($post_id, 'nome_fantasia', $nome_fantasia);
    update_post_meta($post_id, 'data_abertura', $data_abertura);
    update_post_meta($post_id, 'data_alteracao', $data_alteracao);

    // Prepara a resposta
    wp_send_json_success(array(
        'message' => 'Dados empresariais salvos com sucesso!',
        'data' => array(
            'razao_social' => $razao_social,
            'nome_fantasia' => $nome_fantasia,
            'data_abertura' => $data_abertura,
            'data_alteracao' => $data_alteracao,
        ),
    ));

    wp_die();
}
add_action('wp_ajax_save_empresa_meta', 'save_empresa_meta');


// Pesquisar mapas
function search_mapas()
{
    // Verifica se o usuário está logado
    if (!is_user_logged_in()) {
        wp_send_json_error('Você precisa estar logado para ver seus mapas.');
        wp_die();
    }

    $current_user_id = get_current_user_id();
    $search_term = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

    // Query personalizada para buscar mapas criados pelo usuário logado
    $args = array(
        'post_type' => 'mapas',
        's' => $search_term,
        'author' => $current_user_id, // Filtra pelos mapas do usuário logado
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<table class="min-w-full bg-white shadow-md rounded-lg">';
        echo '<thead><tr><th class="py-3 px-6 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Título</th>';
        echo '<th class="py-3 px-6 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Ações</th></tr></thead>';
        echo '<tbody id="mapas-table-body">';
        while ($query->have_posts()) {
            $query->the_post();
            echo '<tr class="border-b">';
            echo '<td class="py-3 px-6 text-left">' . get_the_title() . '</td>';
            echo '<td class="py-3 px-6 text-center">
					<div class="flex justify-center space-x-4">
						<a href="' . esc_url(get_edit_post_link(get_the_ID())) . '" class="text-gray-600 hover:text-gray-800">
							<span class="dashicons dashicons-edit"></span>
						</a>
						<a href="' . esc_url(get_permalink(get_the_ID())) . '" class="text-gray-600 hover:text-gray-800">
							<span class="dashicons dashicons-download"></span>
						</a>
						<form method="post" action="" onsubmit="return confirm(\'Tem certeza que deseja excluir este mapa?\');" class="inline">
							' . wp_nonce_field('delete_mapa_' . get_the_ID(), 'delete_mapa_nonce', true, false) . '
							<input type="hidden" name="mapa_id" value="' . get_the_ID() . '">
							<button type="submit" name="delete_mapa" class="text-gray-600 hover:text-gray-800">
								<span class="dashicons dashicons-trash"></span>
							</button>
						</form>
					</div>
				</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>Nenhum mapa encontrado.</p>';
    }

    wp_die(); // Termina a execução do script
}
add_action('wp_ajax_search_mapas', 'search_mapas');
add_action('wp_ajax_nopriv_search_mapas', 'search_mapas');


/**
 * Busca um post ou página existente pelo título
 * @param String $title O título do post
 * @param String $postType O nome post type desejado
 * @return bool 
 */
function postExists(String $title, String $postType)
{
    $args = array(
        'post_type' => $postType,
        'title'     => $title,
        'post_status' => 'publish',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        return true;
    }

    return false;
}
