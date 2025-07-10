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

<header id="masthead" class="bg-white text-black p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo -->
        <div class="text-md font-bold">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img id="logo-superior" src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" class="h-10">
            </a>
        </div>

        <!-- User Profile and Menu Toggle -->
        <div class="flex gap-[20px] items-center">
            <div class="relative group">
                <div class="flex items-center space-x-4 p-2">
                    <?php
                    //                        if ($profile_picture) {
                    //                            echo '<img src="' . esc_url($profile_picture) . '" alt="Foto de Perfil" class="w-10 h-10 rounded-full cursor-pointer">';
                    //                        } else {
                    //                            echo '<img src="' . esc_url(get_template_directory_uri() . '/images/default-profile.png') . '" alt="Foto Padrão" class="w-10 h-10 rounded-full cursor-pointer">';
                    //                        }
                    ?>
                    <div>
                        <h2 class="text-lg font-semibold">Olá, <?php echo wp_get_current_user()->display_name; ?>!</h2>
                        <p class="text-gray-600">Seja bem-vindo(a)!</p>
                    </div>
                </div>

                <!-- Dropdown Menu -->
                <div class="absolute right-0 mt-2 w-full bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 ease-in-out">
                    <!--					<a href="--><?php //echo esc_url(home_url('/perfil')); ?><!--" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-t-lg">Meu Perfil</a>-->
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-b-lg">Logout</a>
                </div>
            </div>
            <button id="menu-toggle" aria-controls="primary-menu" aria-expanded="false" class="focus:outline-none lg:hidden">
                <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Sidebar Menu (Fixo no Desktop, Off-Canvas no Mobile) -->
<div id="offcanvas-backdrop" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-40 hidden lg:hidden"></div>
<div id="offcanvas-menu" class="fixed lg:relative inset-y-0 left-0 w-64 flex flex-col justify-between  h-full shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out z-50" style="background-color:#43265F!important">    <div>
        <button id="close-menu" class="text-black p-4 focus:outline-none lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="flex justify-center mt-4 mb-4">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <img class="w-40" src="<?php echo get_template_directory_uri() . '/images/logo.png' ?>" alt="">
            </a>
        </div>
        <div class="p-4">
            <section>
                <h3 class="w-full text-white text-xl font-bold mb-4">Criar</h3>
                <button id="create-map-button" class="w-full bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md hover:bg-botao-rosa focus:outline-none flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                    </svg>
                    Mapa Completo
                </button>
                <button id="create-assinatura-button" class="w-full bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md hover:bg-botao-rosa focus:outline-none mt-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                    </svg>
                    Análise de Assinatura
                </button>
                <button id="create-placa-button" class="w-full bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md hover:bg-botao-rosa focus:outline-none mt-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                    </svg>
                    An. Placa e Telefone
                </button>
                <button id="create-endereco-button" class="w-full bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md hover:bg-botao-rosa focus:outline-none mt-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M19.006 3.705a.75.75 0 1 0-.512-1.41L6 6.838V3a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 3 3v4.93l-1.006.365a.75.75 0 0 0 .512 1.41l16.5-6Z" />
                        <path fill-rule="evenodd" d="M3.019 11.114 18 5.667v3.421l4.006 1.457a.75.75 0 1 1-.512 1.41l-.494-.18v8.475h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3v-9.129l.019-.007ZM18 20.25v-9.566l1.5.546v9.02H18Zm-9-6a.75.75 0 0 0-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75H9Z" clip-rule="evenodd" />
                    </svg>
                    Análise de 
                    Endereço
                </button>
                <button id="create-empresa-button" class="w-full bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md hover:bg-botao-rosa focus:outline-none mt-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 0 0 7.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 0 0 4.902-5.652l-1.3-1.299a1.875 1.875 0 0 0-1.325-.549H5.223Z" />
                        <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 0 0 9.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 0 0 2.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3Zm3-6a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75v-3Zm8.25-.75a.75.75 0 0 0-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-5.25a.75.75 0 0 0-.75-.75h-3Z" clip-rule="evenodd" />
                    </svg>
                    Análise Empresarial
                </button>
            </section>
            <section class="mt-4">
                <h3 class="w-full text-white text-xl font-bold">Consultar</h3>
                <a href="/" class="mt-4 w-full inline-block bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                    </svg> <!-- Ícone do mapa -->
                    Mapas
                </a>
                <a href="/assinaturas" class="mt-4 w-full inline-block bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                    </svg>
                    Análises de Assinatura
                </a>
                <a href="/placas" class="mt-4 w-full inline-block bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                    </svg>
                    An. Placa e Telefone
                </a>
                <a href="/enderecos" class="mt-4 w-full inline-block bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M19.006 3.705a.75.75 0 1 0-.512-1.41L6 6.838V3a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 3 3v4.93l-1.006.365a.75.75 0 0 0 .512 1.41l16.5-6Z" />
                        <path fill-rule="evenodd" d="M3.019 11.114 18 5.667v3.421l4.006 1.457a.75.75 0 1 1-.512 1.41l-.494-.18v8.475h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3v-9.129l.019-.007ZM18 20.25v-9.566l1.5.546v9.02H18Zm-9-6a.75.75 0 0 0-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75H9Z" clip-rule="evenodd" />
                    </svg>
                    Análises de Endereços
                </a>
                <a href="/empresas" class="mt-4 w-full inline-block bg-botao-lilas text-cor-numera text-sm py-2 px-4 rounded-md text-center hover:bg-botao-rosa focus:outline-none flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 mr-2 max-w-5 icone-btn">
                        <path d="M5.223 2.25c-.497 0-.974.198-1.325.55l-1.3 1.298A3.75 3.75 0 0 0 7.5 9.75c.627.47 1.406.75 2.25.75.844 0 1.624-.28 2.25-.75.626.47 1.406.75 2.25.75.844 0 1.623-.28 2.25-.75a3.75 3.75 0 0 0 4.902-5.652l-1.3-1.299a1.875 1.875 0 0 0-1.325-.549H5.223Z" />
                        <path fill-rule="evenodd" d="M3 20.25v-8.755c1.42.674 3.08.673 4.5 0A5.234 5.234 0 0 0 9.75 12c.804 0 1.568-.182 2.25-.506a5.234 5.234 0 0 0 2.25.506c.804 0 1.567-.182 2.25-.506 1.42.674 3.08.675 4.5.001v8.755h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3Zm3-6a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-.75.75h-3a.75.75 0 0 1-.75-.75v-3Zm8.25-.75a.75.75 0 0 0-.75.75v5.25c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75v-5.25a.75.75 0 0 0-.75-.75h-3Z" clip-rule="evenodd" />
                    </svg>
                    Análises Empresariais
                </a>
            </section>
        </div>
    </div>
    <div class="container mx-auto p-2">
        <div class="text-center bg-white rounded shadow-md text-2xl flex flex-col">
            <!-- Link de Suporte -->
            <a class="text-sm p-2 text-cor-numera"
               href="https://lojaterapiasdeluz.com.br/comunidadenumera/"
               target="_blank"
               rel="noopener">
                Suporte
                <img src="<?php echo get_stylesheet_directory_uri() . '/images/whatsapp.png'; ?>" alt="WhatsApp" class="w-4 h-4 inline-block ml-1">
            </a>
        </div>

        <style>
            .link-footer {
                color: #43265F;
            }
            .link-kdevs {
                color: #a8a8a8;
            }
        </style>
    </div>

</div>
</div>

<!-- Main Content Area -->
<div id="content" class="main-content">
    <!-- Seu conteúdo principal vai aqui -->
</div>

<!-- Popup Modal para Criar Mapa -->
<?php get_template_part('template-parts/modals/criar-mapa-modal') ?>

<?php get_template_part('template-parts/modals/criar-assinatura-modal') ?>

<!-- Popup Modal para Criar Placa e Telefone -->
<?php get_template_part('template-parts/modals/criar-placa-telefone-modal') ?>

<!-- Popup Modal para Criar Endereço -->
<?php get_template_part('template-parts/modals/criar-endereco-modal') ?>

<!-- Popup Modal para Criar Empresa -->
<?php get_template_part('template-parts/modals/criar-empresa-modal') ?>


<style>
    /* CSS para mobile */
    

    /* CSS para desktop */
    @media (min-width: 1025px) {
        #logo-superior {
            display: none;
        }

        #offcanvas-menu {
            transform: translateX(0);
            position: fixed;
            width: 16vw; /* Ajuste conforme necessário */
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 50;
            background-color: #43265F;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Ajuste do masthead para seguir o tamanho do off-canvas */
        #masthead {
            position: fixed;
            width: 84vw;
            margin-left: 16vw; /* Mesma largura do off-canvas */
            padding-left: 1rem; /* Ajuste de padding conforme necessário */
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            top: 0; /* Posiciona no topo */
            height: 90px; /* Defina a altura do masthead */
            z-index: 9999;
        }

        /* Ajuste do content para seguir o tamanho do off-canvas */
        #content, .main-content {
            margin-left: 16vw; /* Mesma largura do off-canvas */
            margin-top: 90px; /* Mesma altura do masthead */
        }

        #menu-toggle, #offcanvas-backdrop, #close-menu {
            display: none; /* Esconda o botão de toggle no desktop */
        }

        #colophon {
            position: fixed;
            width: 84vw; /* Alinhado com a largura do conteúdo */
            bottom: 0;
            left: 16vw; /* Mesma largura do off-canvas */
            background-color: #ededed; /* Cor de fundo do rodapé */
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            padding-left: 1rem;
            padding-right: 1rem;
            z-index: 50; /* Garanta que o rodapé esteja acima de outros elementos */
        }
    }
</style>
