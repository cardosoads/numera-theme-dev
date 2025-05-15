<?php
/* Template Name: Perfil do Usuário */

get_header();

// Verifica se o usuário está logado
if ( ! is_user_logged_in() ) {
    echo '<div class="container mx-auto mt-10 text-center text-red-600">';
    echo '<p>Você precisa estar logado para acessar essa página.</p>';
    echo '</div>';
    get_footer();
    exit;
}

$current_user = wp_get_current_user();
$password_message = null;

// Processa a troca de senha
if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password']) ) {
    if (
        ! isset($_POST['change_password_nonce']) ||
        ! wp_verify_nonce($_POST['change_password_nonce'], 'change_password_action')
    ) {
        $password_message = ['type' => 'error', 'text' => 'Falha na verificação de segurança.'];
    } else {
        $current_pass = $_POST['current_password'] ?? '';
        $new_pass     = $_POST['new_password'] ?? '';
        $confirm_pass = $_POST['confirm_password'] ?? '';

        if ( ! wp_check_password( $current_pass, $current_user->user_pass, $current_user->ID ) ) {
            $password_message = ['type' => 'error', 'text' => 'Senha atual incorreta.'];
        } elseif ( empty($new_pass) || empty($confirm_pass) ) {
            $password_message = ['type' => 'error', 'text' => 'Preencha todos os campos de senha.'];
        } elseif ( $new_pass !== $confirm_pass ) {
            $password_message = ['type' => 'error', 'text' => 'A nova senha e a confirmação não conferem.'];
        } else {
            wp_set_password( $new_pass, $current_user->ID );
            wp_logout();
            wp_redirect( home_url( '/login/?password_changed=1' ) );
            exit;
        }
    }
}

// Exibe a mensagem de sucesso após o upload da imagem
$upload_success = isset($_GET['upload_success']) && $_GET['upload_success'] == 1;
?>

<div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Perfil do Usuário</h2>

    <?php if ( $password_message ) : ?>
        <div class="mb-4 text-center <?php echo $password_message['type'] === 'error' ? 'text-red-600' : 'text-green-600'; ?>">
            <?php echo esc_html($password_message['text']); ?>
        </div>
    <?php elseif ( $upload_success ) : ?>
        <div class="mb-4 text-center text-green-600">
            Foto de perfil atualizada com sucesso.
        </div>
    <?php endif; ?>

    <div class="flex items-center space-x-6 mb-6">
        <?php
        $profile_picture = get_user_meta( $current_user->ID, 'profile_picture', true );
        $profile_picture_url = $profile_picture ? esc_url( $profile_picture ) : get_avatar_url( $current_user->ID, ['size' => '128'] );
        ?>
        <div class="relative group">
            <img src="<?php echo $profile_picture_url; ?>" alt="Foto de Perfil" class="w-32 h-32 rounded-full border border-gray-300 cursor-pointer">
            <button class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 text-white text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity duration-300" onclick="toggleModal('modal-profile-picture')">
                Trocar Imagem
            </button>
        </div>

        <div>
            <p class="text-lg"><strong>Nome:</strong> <?php echo esc_html( $current_user->display_name ); ?></p>
            <p class="text-lg"><strong>Email:</strong> <?php echo esc_html( $current_user->user_email ); ?></p>
        </div>
    </div>

    <!-- Formulário de troca de senha -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold mb-4">Alterar Senha</h3>
        <form method="post" class="max-w-md">
            <?php wp_nonce_field( 'change_password_action', 'change_password_nonce' ); ?>
            <div class="mb-4">
                <label for="current_password" class="block text-sm font-medium text-gray-700">Senha Atual</label>
                <input type="password" id="current_password" name="current_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="new_password" class="block text-sm font-medium text-gray-700">Nova Senha</label>
                <input type="password" id="new_password" name="new_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirmar Nova Senha</label>
                <input type="password" id="confirm_password" name="confirm_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none sm:text-sm">
            </div>
            <button type="submit" name="change_password" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-md">
                Atualizar Senha
            </button>
        </form>
    </div>
</div>

<!-- Modal de upload de imagem -->
<div id="modal-profile-picture" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-bold mb-4">Carregar Nova Foto de Perfil</h3>
        <form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="upload_profile_picture">
            <?php wp_nonce_field( 'upload_profile_picture', 'upload_profile_picture_nonce' ); ?>
            <div class="mb-4">
                <input type="file" name="profile_picture" accept="image/*" required class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="toggleModal('modal-profile-picture')" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal(id) {
        document.getElementById(id).classList.toggle('hidden');
    }
</script>

<?php get_footer(); ?>
