<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package numera_theme
 */

$user_id = get_current_user_id();
$profile_picture = get_user_meta($user_id, 'profile_picture', true);
?>

<!-- ESCALA RESPONSIVA -->
<style>
    /* base para telas grandes */
    :root { font-size: 16px; }

    /* até +-1366px (13") fontes e espaçamentos 12.5% menores */
    @media (max-width: 1366px) {
        :root { font-size: 14px; }
    }

    /* de 1367px até 1600px (14–15") um meio termo */
    @media (min-width: 1367px) and (max-width: 1600px) {
        :root { font-size: 15px; }
    }

    /* Ensure buttons have consistent width based on the widest content */
    #offcanvas-menu .button-container {
        display: flex;
        flex-direction: column;
        width: fit-content;
        min-width: max-content;
        position: relative;
    }
    #offcanvas-menu button, #offcanvas-menu a.button {
        width: 100%;
        box-sizing: border-box;
    }

    /* Scroll indicator styles */
    .scroll-indicator {
        position: fixed;
        bottom: 80px; /* Adjusted to stay above the support button */
        left: 50%;
        transform: translateX(-50%);
        opacity: 0.7;
        transition: opacity 0.3s ease;
        display: none;
    }
    #offcanvas-menu.scrollable .scroll-indicator {
        display: block;
    }
    .scroll-indicator:hover {
        opacity: 1;
    }

    /* Icon styles for buttons */
    #offcanvas-menu .button-icon {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        stroke: #43265F;
        fill: none;
    }
</style>

<header id="masthead" class="bg-white text-black p-3 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="text-md font-bold">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img id="logo-superior"
                     src="<?php echo get_template_directory_uri(); ?>/images/logo.png"
                     alt="<?php bloginfo('name'); ?>"
                     class="h-10">
            </a>
        </div>

        <!-- User Profile and Menu Toggle -->
        <div class="flex gap-[15px] items-center">
            <div class="relative group">
                <div class="flex items-center p-1">
                    <div>
                        <h2 class="text-base font-semibold">Olá, <?php echo wp_get_current_user()->display_name; ?>!</h2>
                        <p class="text-gray-600 text-sm">Seja bem‑vindo(a)!</p>
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-lg
                    opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                    <a href="<?php echo wp_logout_url(home_url()); ?>"
                       class="block px-3 py-1 text-gray-700 hover:bg-gray-100 rounded-b-lg text-sm">
                        Logout
                    </a>
                </div>
            </div>
            <button id="menu-toggle"
                    aria-controls="primary-menu"
                    aria-expanded="false"
                    class="focus:outline-none lg:hidden">
                <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Sidebar Menu (Fixo no Desktop, Off-Canvas no Mobile) -->
<div id="offcanvas-backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 hidden lg:hidden"></div>
<div id="offcanvas-menu"
     class="fixed lg:relative inset-y-0 left-0 flex flex-col justify-between h-full shadow-lg
            transform -translate-x-full transition-transform duration-300 ease-in-out z-50"
     style="background-color:#43265F!important; min-width: 200px; width: fit-content;">
    <div class="flex flex-col h-full">
        <button id="close-menu" class="text-black p-4 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="flex justify-center mt-4 mb-4">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img class="w-40" src="<?php echo get_template_directory_uri() . '/images/logo.png' ?>" alt="">
            </a>
        </div>
        <div class="flex-1 overflow-y-auto p-4 button-container" style="scrollbar-width: none; -ms-overflow-style: none;">
            <style>
                #offcanvas-menu::-webkit-scrollbar { display: none; }
            </style>
            <section>
                <h3 class="w-full text-white text-xl font-bold mb-4">Criar</h3>
                <button id="create-map-button"
                        class="bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md
                       hover:bg-botao-rosa focus:outline-none flex items-center whitespace-nowrap">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18M9 3v18M15 3v18" />
                    </svg>
                    Mapa Completo
                </button>
                <button id="create-assinatura-button"
                        class="bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md
                       hover:bg-botao-rosa focus:outline-none mt-4 flex items-center whitespace-nowrap">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    Análise de Assinatura
                </button>
                <button id="create-placa-button"
                        class="bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md
                       hover:bg-botao-rosa focus:outline-none mt-4 flex items-center whitespace-nowrap">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7V5h16v2M4 19v-2h16v2M12 12H4v3h8v-3zm8 0h-4v3h4v-3z" />
                    </svg>
                    An. Placa e Telefone
                </button>
                <button id="create-endereco-button"
                        class="bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md
                       hover:bg-botao-rosa focus:outline-none mt-4 flex items-center whitespace-nowrap">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    Análise de Endereço
                </button>
                <button id="create-empresa-button"
                        class="bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md
                       hover:bg-botao-rosa focus:outline-none mt-4 flex items-center whitespace-nowrap">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3h18v18H3zM7 7h2v2H7zm0 4h2v2H7zm0 4h2v2H7zm8-8h2v2h-2zm0 4h2v2h-2zm0 4h2v2h-2z" />
                    </svg>
                    Análises Empresariais
                </button>
            </section>
            <section class="mt-4">
                <h3 class="w-full text-white text-xl font-bold">Consultar</h3>
                <a href="/" class="mt-4 inline-block bg-botao-lilas text-cor-numera text-sm
                          py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none
                          flex items-center whitespace-nowrap button">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3v18h18M9 3v18M15 3v18" />
                    </svg>
                    Mapas
                </a>
                <a href="/assinaturas" class="mt-4 inline-block bg-botao-lilas text-cor-numera text-sm
                                     py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none
                                     flex items-center whitespace-nowrap button">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                    </svg>
                    Análises de Assinatura
                </a>
                <a href="/placas" class="mt-4 inline-block bg-botao-lilas text-cor-numera text-sm
                               py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none
                               flex items-center whitespace-nowrap button">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 7V5h16v2M4 19v-2h16v2M12 12H4v3h8v-3zm8 0h-4v3h4v-3z" />
                    </svg>
                    An. Placa e Telefone
                </a>
                <a href="/enderecos" class="mt-4 inline-block bg-botao-lilas text-cor-numera text-sm
                                  py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none
                                  flex items-center whitespace-nowrap button">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                        <circle cx="12" cy="10" r="3" />
                    </svg>
                    Análises de Endereços
                </a>
                <a href="/empresas" class="mt-4 inline-block bg-botao-lilas text-cor-numera text-sm
                                 py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none
                                 flex items-center whitespace-nowrap button">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 3h18v18H3zM7 7h2v2H7zm0 4h2v2H7zm0 4h2v2H7zm8-8h2v2h-2zm0 4h2v2h-2zm0 4h2v2h-2z" />
                    </svg>
                    Análises Empresariais
                </a>
            </section>
        </div>
        <div class="scroll-indicator">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="white" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
        <div class="p-4">
            <div class="text-center bg-white rounded shadow-md text-2xl">
                <a class="text-sm py-2 px-4 text-cor-numera inline-flex items-center justify-center whitespace-nowrap button"
                   href="https://lojaterapiasdeluz.com.br/comunidadenumera/"
                   target="_blank"
                   rel="noopener">
                    <svg class="button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    Suporte
                    <img src="<?php echo get_stylesheet_directory_uri() . '/images/whatsapp.png'; ?>"
                         alt="WhatsApp"
                         class="w-4 h-4 ml-1">
                </a>
            </div>
        </div>
    </div>

    <style>
        .link-footer { color: #43265F; }
        .link-kdevs  { color: #a8a8a8; }
    </style>
</div>

<!-- Main Content Area -->
<div id="content" class="main-content">
    <!-- Seu conteúdo principal vai aqui -->
</div>

<!-- Popup Modals -->
<?php get_template_part('template-parts/modals/criar-mapa-modal'); ?>
<?php get_template_part('template-parts/modals/criar-assinatura-modal'); ?>
<?php get_template_part('template-parts/modals/criar-placa-telefone-modal'); ?>
<?php get_template_part('template-parts/modals/criar-endereco-modal'); ?>
<?php get_template_part('template-parts/modals/criar-empresa-modal'); ?>

<!-- JavaScript to toggle scrollable class -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.querySelector('#offcanvas-menu .button-container');
        const offcanvasMenu = document.querySelector('#offcanvas-menu');
        function checkScrollable() {
            const isScrollable = container.scrollHeight > container.clientHeight;
            const atBottom = container.scrollTop + container.clientHeight >= container.scrollHeight - 1; // Small buffer
            if (isScrollable && !atBottom) {
                offcanvasMenu.classList.add('scrollable');
            } else {
                offcanvasMenu.classList.remove('scrollable');
            }
        }
        checkScrollable();
        container.addEventListener('scroll', checkScrollable);
        window.addEventListener('resize', checkScrollable);
    });
</script>

<style>
    @media (min-width: 1025px) {
        #logo-superior { display: none; }
        #offcanvas-menu {
            transform: translateX(0);
            position: fixed;
            width: fit-content;
            min-width: 200px;
            left: 0; top: 0; bottom: 0;
            background-color: #43265F;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 50;
        }
        #masthead {
            position: fixed;
            width: calc(100% - 200px);
            margin-left: 200px;
            padding-left: 1rem;
            height: 70px;
            top: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            z-index: 9999;
        }
        #content, .main-content {
            margin-left: 200px;
            margin-top: 70px;
        }
        #menu-toggle, #offcanvas-backdrop, #close-menu { display: none; }
        #colophon {
            position: fixed;
            width: calc(100% - 200px);
            bottom: 0;
            left: 200px;
            background-color: #ededed;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            padding: 0 1rem;
            z-index: 50;
        }
    }
</style>