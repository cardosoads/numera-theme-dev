<?php
/* Template para exibir um único post do tipo "Placas" */

include_once __DIR__ . "/inc/template-single-enderecos-functions.php";

get_header(); ?>

<div class="container mx-auto p-4">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="mb-4">
                    <h1 class="text-3xl font-bold"><?php the_title(); ?></h1>
                </header>

                <div class="entry-content">
                    <form id="edit-endereco-form">
                        <div class="flex flex-wrap justify-between gap-1">
                            <div style="width: 17%;" class="mb-4">
                                <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
                                <input type="text" id="cep" name="cep" value="<?php echo esc_attr($cep); ?>"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div style="width: 80%;" class="mb-4">
                                <label for="endereco"
                                    class="block text-sm font-medium text-gray-700">Endereço</label>
                                <input type="text" id="endereco" name="endereco"
                                    value="<?php echo esc_attr($rua); ?>"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div style="width: 17%;" class="mb-4">
                                <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
                                <input type="text" id="numero" name="numero"
                                    value="<?php echo esc_attr($numero); ?>"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div style="width: 80%;" class="mb-4">
                                <label for="complemento"
                                    class="block text-sm font-medium text-gray-700">Complemento</label>
                                <input type="text" id="complemento" name="complemento"
                                    value="<?php echo esc_attr($complemento); ?>"
                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">Salvar Alterações</button>
                        </div>
                    </form>
                </div>
                    <?php
                if (!is_array($endereco_options)) {
                    $endereco_options = []; // Garante que seja um array
                }
                    ?>

                <div class="container mx-auto p-6 bg-gray-50 rounded-lg shadow-md my-8 min-h-[400px]">
                    <h2 class="text-2xl font-semibold mb-6">Resultado do Cálculo do Endereço</h2>

                    <!-- Layout de 2 colunas -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Vibração do Número da Casa -->
                        <div class="bg-white border border-green-300 rounded-lg p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Número da Casa</h3>
                            <div class="text-center">
                                <!-- Número -->
                                <span class="block text-4xl font-semibold text-blue-500">
                                    <?php echo esc_html($calculo_casa ?? 'N/A'); ?>
                                </span>
                                <!-- Título -->
                                <h4 class="text-md font-medium text-gray-800 mt-2">
                                   Vibração
                                </h4>
                                <!-- Descrição -->
                                <?php if (!empty($texto_casa[0])): ?>
                                    <p class="text-gray-600 mt-4">
                                        <?php echo esc_html($texto_casa[0]); ?>
                                    </p>
                                <?php else: ?>
                                    <p class="text-gray-500 mt-4">Nenhuma Texto encontrado para o número da casa.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Vibração do Endereço Completo -->
                        <div class="bg-white border border-green-300 rounded-lg p-6 shadow-sm">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Endereço Completo</h3>
                            <div class="text-center">
                                <!-- Número -->
                                <span class="block text-4xl font-semibold text-green-500">
                                    <?php echo esc_html($calculo_endereco ?? 'N/A'); ?>
                                </span>
                                <!-- Título -->
                                <h4 class="text-md font-medium text-gray-800 mt-2">
                                    Vibração
                                </h4>
                                <!-- Descrição -->
                                <?php if (!empty($texto_endereco[0])): ?>
                                    <p class="text-gray-600 mt-4">
                                        <?php echo esc_html($texto_endereco[0]); ?>
                                    </p>
                                <?php else: ?>
                                    <p class="text-gray-500 mt-4">Nenhuma Texto encontrado para o endereço completo.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="bg-[#D8CAE5] text-gray-800 font-medium mt-2 p-4 text-center rounded-lg">
                    <strong>Copie e cole o resultado no Mapa Pessoal</strong>
                </p>
                <footer class="mt-6">
                    <a href="<?php echo esc_url(home_url('/endereco')); ?>" class="text-blue-600 hover:underline">Voltar para a listagem de Endereço</a>
                </footer>
            </article>

        <?php endwhile;
    else : ?>
        <p>Nenhuma endereço encontrado.</p>
    <?php endif; ?>
</div>

<?php
get_footer();
