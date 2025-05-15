<?php
/* Template para exibir um único post do tipo "Placas" */

include_once __DIR__ . "/inc/template-single-placa-functions.php";

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
                    <form id="edit-placa-form">
                        <div class="flex flex-wrap justify-between gap-4">
                            <div style="width: 40%;" class="mb-4">
                                <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                                <?php
                                $data_nascimento_formato = formatBrDate($data_nascimento); // Chamando sua função
                                ?>
                                <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo esc_attr($data_nascimento_formato); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div style="width: 25%;" class="mb-4">
                                <label for="numero_telefone" class="block text-sm font-medium text-gray-700">Número de telefone</label>
                                <input type="text" id="numero_telefone" name="numero_telefone" value="<?php echo esc_attr($numero_telefone) ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <div style="width: 25%;" class="mb-4">
                                <label for="placa_veiculo" class="block text-sm font-medium text-gray-700">Placa do Veículo</label>
                                <input type="tel" id="placa_veiculo" name="placa_veiculo" value="<?php echo esc_attr($placa_veiculo) ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">Salvar Alterações</button>
<!--                            <a href="--><?php //echo add_query_arg('download_placa_docx', '1') ?><!--" class="w-[200px] bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700">Gerar Mapa</a>-->
                        </div>
                    </form>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 bg-gray-50 rounded-lg shadow-md my-8 min-h-[400px]">
                    <!-- Coluna Placa -->
                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Placa</h2>
                        <div class="text-center">
                            <!-- Número -->
                            <span class="block text-4xl font-semibold text-blue-500"><?php echo esc_attr($placa_veiculo) ?></span>
                            <!-- Título -->
                            <h3 class="text-lg font-medium text-gray-800 mt-2">A Vibração da Placa é <?php echo esc_attr($calculo_placa); ?></h3>
                            <!-- Texto -->
                            <p class="text-gray-600 mt-4">
                                <?php echo esc_attr($texto_placa[0]); ?>
                            </p>
                        </div>
                    </div>

                    <!-- Coluna Telefone -->
                    <div class="bg-white border border-gray-300 rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Telefone</h2>
                        <div class="text-center">
                            <!-- Número -->
                            <span class="block text-4xl font-semibold text-green-500"><?php echo esc_attr($numero_telefone) ?></span>
                            <!-- Título -->
                            <h3 class="text-lg font-medium text-gray-800 mt-2">A Vibração do Telefone é <?php echo esc_attr($calculo_telefone);?></h3>
                            <!-- Texto -->
                            <p class="text-gray-600 mt-4">
                                 <?php echo esc_attr($texto_telefone[0]);?>
                            </p>
                        </div>
                    </div>
                </div>
                <p class="bg-[#D8CAE5] text-gray-800 font-medium mt-2 p-4 text-center rounded-lg">
                    <strong>Copie e cole o resultado no Mapa Pessoal</strong>
                </p>
                <footer class="mt-6">
                    <a href="<?php echo esc_url(home_url('/placas')); ?>" class="text-blue-600 hover:underline">Voltar para a listagem de Placas</a>
                </footer>
            </article>
        <?php endwhile;
    else : ?>
        <p>Nenhuma placa encontrada.</p>
    <?php endif; ?>
</div>

<?php
get_footer();
