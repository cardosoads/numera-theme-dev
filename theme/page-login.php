<?php

/* Template Name: Login Page */

// Custom redirect after login
define('CUSTOM_LOGIN_TEMPLATE_LOADED', true);
function custom_login_redirect($redirect_to, $request, $user) {
    if (isset($user->roles) && is_array($user->roles)) {
        if (in_array('administrator', $user->roles)) {
            return admin_url();
        }
        return site_url('/dashboard');
    }
    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

// Handle failed login without redirecting to wp-login.php
function custom_login_failed_redirect($username) {
    $referrer = wp_get_referer();
    if ($referrer && !strstr($referrer, 'wp-login.php')) {
        wp_redirect(add_query_arg('login', 'failed', $referrer));
        exit;
    }
}
add_action('wp_login_failed', 'custom_login_failed_redirect');


?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <style>
        .modal-backdrop { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 40; }
        .modal { display: none; position: fixed; inset: 0; overflow-y: auto; z-index: 50; }
    </style>
</head>
<body <?php body_class(); ?>>

<div class="min-h-screen flex">
    <div class="w-full md:w-1/2 bg-[#F8DDE1] flex flex-col justify-center items-center p-8">
        <h2 class="text-2xl font-bold mb-6">Login</h2>
        <form id="login-form" method="post" action="<?php echo esc_url(wp_login_url()); ?>" class="w-full max-w-md">
            <div class="mb-4">
                <label for="user_login" class="block text-sm font-medium text-gray-700">Usuário ou E-mail</label>
                <input type="text" name="log" id="user_login" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-6">
                <label for="user_pass" class="block text-sm font-medium text-gray-700">Senha</label>
                <input type="password" name="pwd" id="user_pass" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <input type="hidden" name="redirect_to" value="<?php echo esc_url(site_url('/')); ?>">
                <input type="submit" name="wp-submit" value="Login" class="w-full bg-[#42275C] text-white py-2 px-4 rounded-md hover:bg-[#633A8A] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            </div>
        </form>
        <div class="w-full max-w-md text-center">
            <button id="open-recover" class="text-sm text-indigo-600 hover:underline focus:outline-none">Esqueceu a senha?</button>
        </div>
        <?php if (isset($_GET['login']) && $_GET['login'] == 'failed'): ?>
            <p class="mt-4 text-red-500">Erro: Nome de usuário ou senha incorretos.</p>
        <?php endif; ?>
    </div>
    <div class="flex bg-[#E2CBEA] bg-contain md:w-1/2 justify-center items-center">
        <img class="w-[400px] h-auto" src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>" alt="Logo">
    </div>
</div>

<!-- Modal backdrop -->
<div id="modal-backdrop"
     style="
       display: none!important;
       position: fixed;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       background: rgba(0,0,0,0.5);
       z-index: 40;
     ">
</div>

<!-- Modal container -->
<div id="recover-modal"
     style="
       display: none!important;
       position: fixed;
       top: 0;
       left: 0;
       width: 100%;
       height: 100%;
       z-index: 50;
     ">

  <!-- Conteúdo centralizado -->
  <div style="
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        max-width: 24rem;
        width: calc(100% - 2rem);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
      ">
    <!-- Botão fechar -->
    <button id="modal-close-btn"
            aria-label="Fechar modal"
            style="
              position: absolute;
              top: 0.75rem;
              right: 0.75rem;
              background: transparent;
              border: none;
              font-size: 1.5rem;
              line-height: 1;
              cursor: pointer;
              color: #6B7280;
            ">
      &times;
    </button>

    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1rem;">
      Recuperar Senha
    </h3>
    <p style="font-size: 0.875rem; margin-bottom: 1rem;">
      Digite seu e-mail para receber o link de recuperação:
    </p>
    <input type="email"
           id="recover-email"
           placeholder="seu@email.com"
           style="
             width: 100%;
             padding: 0.5rem 0.75rem;
             border: 1px solid #D1D5DB;
             border-radius: 0.375rem;
             margin-bottom: 1rem;
             outline: none;
           ">

    <div id="recover-msg" style="font-size: 0.875rem; margin-bottom: 1rem;"></div>

    <div id="recover-actions" style="display: flex; justify-content: flex-end; gap: 0.5rem;">
      <button id="close-recover"
              style="
                padding: 0.5rem 1rem;
                border: 1px solid #D1D5DB;
                border-radius: 0.375rem;
                background: transparent;
                cursor: pointer;
              ">
        Cancelar
      </button>
      <button id="submit-recover"
              style="
                padding: 0.5rem 1rem;
                background: #42275C;
                color: #fff;
                border: none;
                border-radius: 0.375rem;
                cursor: pointer;
              ">
        Enviar
      </button>
    </div>
  </div>
</div>

<script>
    const openBtn = document.getElementById('open-recover');
const closeBtns = [document.getElementById('modal-close-btn'), document.getElementById('close-recover')];
const backdrop = document.getElementById('modal-backdrop');
const modal = document.getElementById('recover-modal');

openBtn.addEventListener('click', e => {
  e.preventDefault();
  backdrop.style.display = 'block';
  modal.style.display = 'flex';
});

closeBtns.forEach(btn =>
  btn.addEventListener('click', () => {
    backdrop.style.display = 'none';
    modal.style.display = 'none';
    document.getElementById('recover-msg').textContent = '';
  })
);
</script>


<?php wp_footer(); ?>
</body>
</html>