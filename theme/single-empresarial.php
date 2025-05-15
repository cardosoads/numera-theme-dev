<?php
/* Template para exibir um único post do tipo "Empresa" */
include_once __DIR__ . "/inc/template-single-empresa-functions.php";

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
                    <form id="edit-empresa-form">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>" />
                        <div class="flex flex-wrap w-full justify-between gap-1">
                            <!-- Campo Razão Social -->
                            <div class="mb-4 w-1/4">
                                <label for="razao_social" class="block text-sm font-medium text-gray-700">Razão Social</label>
                                <input type="text" id="razao_social" name="razao_social" value="<?php echo esc_attr($razao_social); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- Campo Nome Fantasia -->
                            <div class="mb-4 w-1/4">
                                <label for="nome_fantasia" class="block text-sm font-medium text-gray-700">Nome Fantasia</label>
                                <input type="text" id="nome_fantasia" name="nome_fantasia" value="<?php echo esc_attr($nome_fantasia); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- Campo Data de Abertura (Tipo Data) -->
                            <div class="mb-4 w-1/4">
                                <label for="data_abertura" class="block text-sm font-medium text-gray-700">Data de Abertura</label>
                                <?php $data_abertura_br = formatBrDate($data_abertura); ?>
                                <input type="date" id="data_abertura" name="data_abertura" value="<?php echo esc_attr($data_abertura); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>

                            <!-- Campo Data de Alteração (Tipo Data) -->
                            <div style="width: w-1/4;" class="mb-4">
                                <label for="data_alteracao" class="block text-sm font-medium text-gray-700">Data de Alteração</label>
                                <?php $data_alteracao_br = formatBrDate($data_alteracao); ?>
                                <input type="date" id="data_alteracao" name="data_alteracao" value="<?php echo esc_attr($data_alteracao); ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">Salvar Alterações</button>
                            <a href="<?php echo add_query_arg('download_empresarial_docx', '1') ?>" class="w-[200px] bg-green-600 text-white text-center py-2 px-4 rounded-md hover:bg-green-700">Gerar Mapa</a>
                        </div>
                    </form>
                </div>

                <div class="container mx-auto p-6 bg-gray-50 rounded-lg shadow-lg border border-gray-200 mt-8">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Razão Social: <?php echo esc_html($razao_social); ?></h2>
                    <div class="flex flex-wrap gap-6">
                        <div class="flex flex-nowrap gap-6">
                        <!-- Linha Principal -->
                            <div class="bg-white w-full p-6 rounded-lg shadow-md border border-orange-300">
                                <span class="text-sm text-gray-500 flex gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                      <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd" />
                                    </svg>
                                    <strong><?php echo $numerologia->fasesLua($data_abertura)?></strong>
                                </span>

                                <!-- Seções de Motivação, Impressão e Expressão -->

                                <div class="flex flex-wrap gap-4 mt-4"">
                                    <?php
                                    renderizarBloco('motivacao', 'Motivação', $motivacao_razao, 'modal-motivacao', $motivacao_options, 'numero');
                                    renderizarBlocoDois('impressao', 'Impressão', $impressao_razao, 'modal-impressao', $impressao_options, 'numero');
                                    renderizarBlocoDois('expressao', 'Expressão', $expressao_razao, 'modal-expressao', $expressao_options, 'numero');
                                    renderizarBlocoDois('missao', 'Missão', $missao, 'modal-missao', $missao_options, 'numero');
                                    renderizarBlocoTres('destino', 'Destino', $destino, 'modal-destino', $destino_options, 'numero_destino');
                                    ?>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <?php echo do_shortcode('[areas_de_atuacao]'); ?>
                            </div>
                        </div>


                        <!-- Números Harmônicos, Dias Favoráveis, e Desafios -->
                        <div class="flex flex-wrap gap-6 w-full">
                            <div class="flex-1 min-w-[250px] bg-white p-6 rounded-lg shadow-md border border-orange-200">
                                <?php renderizarNumerosHarmonicos('Números Harmônicos', $numeros_harmonicos, 'modal-numeros-harmonicos'); ?>
                            </div>
                            <div class="flex-1 min-w-[250px] bg-white p-6 rounded-lg shadow-md border border-orange-200">
                                <?php renderizarNumerosHarmonicos('Dias Favoráveis', $dias_favoraveis, 'modal-dias-favoraveis'); ?>
                            </div>
                            <div class="flex-1 min-w-[250px] bg-white p-6 rounded-lg shadow-md border border-orange-200">
                                <?php renderizarNumerosHarmonicos('Desafios', $desafios, 'modal-desafios'); ?>
                            </div>
                        </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Bloco Ciclos-->
                            <div class="bg-white border border-yellow-300 rounded-2xl p-6 shadow-md">
                                <div class="flex items-center mb-6">
                                    <h2 class="text-2xl font-semibold text-gray-800">Ciclos da Vida</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    <?php if (!empty($ciclos['ciclos'])):
                                        $contador = 1;
                                        foreach ($ciclos['ciclos'] as $nome_ciclo => $dados_ciclo): ?>
                                            <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                                <div class="flex items-center">
                                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                                     <?php echo esc_html($dados_ciclo['numero']); ?>
                                                                     </span>
                                                    <h3 class="font-semibold text-gray-800">
                                                        <?php
                                                        if($contador == 1){
                                                            echo esc_html("Primeiro Ciclo");
                                                        }elseif ($contador == 2){
                                                            echo esc_html("Segundo Ciclo");
                                                        }elseif ($contador == 3){
                                                            echo esc_html("Terceiro Ciclo");
                                                        }
                                                        ?>
                                                    </h3>
                                                </div>
                                                <p class="text-gray-800 mt-2">
                                                <p class="text-gray-500 text-sm font-semibold">Período</p>
                                                <p class="text-gray-800 text-sm font-small">
                                                    <?php
                                                    $periodo = $dados_ciclo['periodo'];
                                                    $datas = explode(' a ', $periodo);
                                                    if (count($datas) === 2) {
                                                        echo date('d/m/Y', strtotime($datas[0])) . ' a ' . date('d/m/Y', strtotime($datas[1]));
                                                    } else {
                                                        echo esc_html($periodo);
                                                    }
                                                    ?>
                                                </p>
                                            </div>
                                            <?php $contador++;
                                        endforeach;
                                    else: ?>
                                        <p class="text-gray-600">Nenhum ciclo encontrado.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- Bloco Momentos Decisivos -->
                            <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-md">
                                <div class="flex items-center mb-6">
                                    <h2 class="text-2xl font-semibold text-gray-800">Momentos Decisivos</h2>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                        <h3 class="font-semibold text-gray-800">1° Momento</h3>
                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos['primeiroMomento'] ?>
                                            </span>

                                        </div>
                                        <div class="mt-2">
                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                            <p class="text-gray-800 text-sm">
                                                <?php echo $momentos_decisivos['momentoInicial1'] . ' até ' . $momentos_decisivos['momentoFinal1'] ?>
                                            </p>
                                            <p>
                                                <?php
                                                $ano_inicio = $momentos_decisivos['momentoInicial1'];
                                                $ano_fim = $momentos_decisivos['momentoFinal1'];
                                                $diferenca_anos = is_numeric($ano_fim) ? ($ano_fim - $ano_inicio) : null;
                                                ?>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    duração: <?php echo $diferenca_anos; ?> anos <?php ; ?>
                                                </span
                                            </p>
                                            <p>
                                                <?php
                                                $ano_inicio_comeco = $momentos_decisivos['momentoInicial1'];
                                                // Cálculo da idade no período
                                                $soma_anos = $ano_fim - $ano_inicio_comeco;
                                                ?>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: 0 anos até <?php echo $soma_anos; ?> anos <?php ; ?>
                                                </span
                                            </p>
                                        </div>
                                    </div>
                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                        <h3 class="font-semibold text-gray-800">2° Momento</h3>
                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos['segundoMomento'] ?>
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                            <p class="text-gray-800 text-sm">
                                                <?php echo $momentos_decisivos['momentoInicial2'] . ' até ' . $momentos_decisivos['momentoFinal2'] ?>
                                            </p>
                                            <p>
                                                <?php
                                                $ano_inicio = $momentos_decisivos['momentoInicial2'];
                                                $ano_fim = $momentos_decisivos['momentoFinal2'];
                                                $diferenca_anos = is_numeric($ano_fim) ? ($ano_fim - $ano_inicio) : null;
                                                ?>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    duração: <?php echo $diferenca_anos; ?> anos <?php ; ?>
                                                </span
                                            </p>
                                            <p>
                                                <?php
                                                $ano_inicio_comeco = $momentos_decisivos['momentoInicial1'];
                                                // Cálculo da idade no período
                                                $soma_anos = $ano_fim - $ano_inicio_comeco;
                                                $idade_inicio = $ano_inicio - $ano_inicio_comeco;
                                                ?>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: <?php echo $idade_inicio; ?> anos até <?php echo $soma_anos; ?> anos <?php ; ?>
                                                </span
                                            </p>
                                        </div>
                                    </div>
                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                        <h3 class="font-semibold text-gray-800">3° Momento</h3>
                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos['terceiroMomento'] ?>
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                            <p class="text-gray-800 text-sm">
                                                <?php echo $momentos_decisivos['momentoInicial3'] . ' até ' . $momentos_decisivos['momentoFinal3'] ?>
                                            </p>
                                            <p>
                                                <?php
                                                $ano_inicio = $momentos_decisivos['momentoInicial3'];
                                                $ano_fim = $momentos_decisivos['momentoFinal3'];
                                                $diferenca_anos = is_numeric($ano_fim) ? ($ano_fim - $ano_inicio) : null;
                                                ?>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    duração: <?php echo $diferenca_anos; ?> anos <?php ; ?>
                                                </span
                                            </p>
                                            <p>
                                                <?php
                                                $ano_inicio_comeco = $momentos_decisivos['momentoInicial1'];
                                                // Cálculo da idade no período
                                                $soma_anos = $ano_fim - $ano_inicio_comeco;
                                                $idade_inicio = $ano_inicio - $ano_inicio_comeco;
                                                ?>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: <?php echo $idade_inicio; ?> anos até <?php echo $soma_anos; ?> anos <?php ; ?>
                                                </span
                                            </p>
                                        </div>
                                    </div>
                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                        <h3 class="font-semibold text-gray-800">4° Momento</h3>
                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos['quartoMomento'] ?>
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                            <p class="text-gray-800 text-sm">
                                                <?php echo $momentos_decisivos['momentoInicial4'] . ' até ' . $momentos_decisivos['momentoFinal4'] ?>
                                            </p>
                                            <p>
                                                <?php
                                                $ano_inicio = $momentos_decisivos['momentoInicial1'];
                                                $ano_fim = $momentos_decisivos['momentoInicial4'];
                                                $idade_inicio = $ano_fim - $ano_inicio;
                                                ?>
                                            </p>
                                            <p>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: <?php echo $idade_inicio; ?> anos até o fim<?php ; ?>
                                                </span
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                        <!-- Versão com o nome fantasia -->
                        <div class="container mx-auto p-6 bg-gray-50 rounded-lg shadow-lg border border-gray-200 mt-8">
                            <?php if (!empty($nome_fantasia)): ?>
                            <h2 class="text-xl font-semibold">Nome Fantasia: <?php echo esc_html($nome_fantasia); ?> </h2>
                            <div class="mt-2">
                                                <span class="text-sm text-gray-500 flex gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                      <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd" />
                                                    </svg>
                                                    <!--o calculo tem que ser referente a data que irá puxar na alteração do nome fantasia, se houver nome fantasia verificar a data da criação para poder calcular a data da lua referente aquela data de criação-->
                                                    <strong><?php echo $numerologia->fasesLua($data_alteracao)?></strong>

                                                </span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-2 gap-4 mt-4">
                                <div class="flex bg-white gap-4 w-full p-4 rounded-lg shadow-md items-center border border-solid border-borda-laranja">
                                    <?php
                                    renderizarBloco('motivacao', 'Motivação', $motivacao_fantasia, 'modal-motivacao', $motivacao_options, 'numero_motivacao');
                                    renderizarBloco('impressao', 'Impressão', $impressao_fantasia, 'modal-impressao', $impressao_options, 'numero_impressao');
                                    renderizarBloco('expressao', 'Expressão', $expressao_fantasia, 'modal-expressao', $expressao_options, 'numero_expressao');
                                    ?>
                                </div>
                            </div>
                            <?php else: ?>
                                <p class="text-gray-500">Nenhum nome fantasia disponível.</p>
                            <?php endif; ?>
                        </div>

                        <!--Versão com A data de alteração-->
                            <div class="container mx-auto p-6 bg-gray-50 rounded-lg shadow-lg border border-gray-200 mt-8">
                                <?php if (!empty($data_alteracao)): ?>
                                <?php
                                // Suponha que $data_alteracao seja uma string no formato Y-m-d
                                $data_obj = DateTime::createFromFormat('Y-m-d', $data_alteracao);

                                // Verifica se a data foi criada corretamente
                                if ($data_obj) {
                                    // Cria a variável $data_exibicao com o formato desejado
                                    $data_exibicao = $data_obj->format('d-m-Y');
                                } else {
                                    $data_exibicao = "Data inválida!";
                                }
                                ?>
                                <h2 class="text-xl font-semibold">Data de Alteração: <?php echo esc_html($data_exibicao); ?></h2>
                                <div class="mt-2">
                                    <span class="text-sm text-gray-500 flex gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                          <path fill-rule="evenodd" d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 0 0 9 6a9 9 0 0 0 9 9 8.97 8.97 0 0 0 3.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.7-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162Z" clip-rule="evenodd" />
                                        </svg>
                                        <strong><?php echo $numerologia->fasesLua($data_alteracao)?></strong>
                                    </span>
                                </div>
                                <div class="flex bg-white gap-4 w-full p-4 rounded-lg shadow-md items-center border border-solid border-borda-laranja mt-4">
                                    <?php
                                    renderizarBloco('missao', 'Missão', $missao_alteracao, 'modal-missao', $missao_options, 'numero_missao');
                                    renderizarBloco('destino', 'Destino', $missao_alteracao, 'modal-destino', $destino_options, 'numero_destino');
                                    ?>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-4 mt-4">
                                    <div class="flex flex-wrap gap-4 w-full">
                                        <div class="flex-1 min-w-[250px] bg-white p-4 rounded-lg shadow-md items-center border border-solid border-[#f2b37d]">
                                            <?php renderizarNumerosHarmonicos('Números Harmônicos', $numeros_harmonicos_alteracao, 'modal-numeros-harmonicos'); ?>
                                        </div>
                                        <div class="flex-1 min-w-[250px] bg-white p-4 rounded-lg shadow-md items-center border border-solid border-[#f2b37d]">
                                            <?php renderizarNumerosHarmonicos('Dias Favoráveis', $dias_favoraveis_alteracao, 'modal-dias-favoraveis'); ?>
                                        </div>
                                        <div class="flex-1 min-w-[250px] bg-white p-4 rounded-lg shadow-md items-center border border-solid border-[#f2b37d]">
                                            <?php renderizarNumerosHarmonicos('Desafios', $desafios_alteracao, 'modal-desafios'); ?>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                            <!-- Bloco Ciclos-->
                                            <div class="bg-white border border-yellow-300 rounded-2xl p-6 shadow-md">
                                                <div class="flex items-center mb-6">
                                                    <h2 class="text-2xl font-semibold text-gray-800">Ciclos da Vida</h2>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                                    <?php if (!empty($ciclos_alteracao['ciclos'])):
                                                        $contador = 1;
                                                        foreach ($ciclos_alteracao['ciclos'] as $nome_ciclo => $dados_ciclo): ?>
                                                            <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                                                <div class="flex items-center">
                                                                <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                                     <?php echo esc_html($dados_ciclo['numero']); ?>
                                                                     </span>
                                                                    <h3 class="font-semibold text-gray-800">
                                                                        <?php
                                                                        if($contador == 1){
                                                                            echo esc_html("Primeiro Ciclo");
                                                                        }elseif ($contador == 2){
                                                                            echo esc_html("Segundo Ciclo");
                                                                        }elseif ($contador == 3){
                                                                            echo esc_html("Terceiro Ciclo");
                                                                        }
                                                                        ?>
                                                                    </h3>
                                                                </div>
                                                                <p class="text-gray-800 mt-2">
                                                                <p class="text-gray-500 text-sm font-semibold">Período</p>
                                                                <p class="text-gray-800 text-sm font-small">
                                                                    <?php
                                                                    $periodo = $dados_ciclo['periodo'];
                                                                    $datas = explode(' a ', $periodo);
                                                                    if (count($datas) === 2) {
                                                                        echo date('d/m/Y', strtotime($datas[0])) . ' a ' . date('d/m/Y', strtotime($datas[1]));
                                                                    } else {
                                                                        echo esc_html($periodo);
                                                                    }
                                                                    ?>
                                                                </p>
                                                            </div>
                                                            <?php $contador++;
                                                        endforeach;
                                                    else: ?>
                                                        <p class="text-gray-600">Nenhum ciclo encontrado.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <!-- Bloco Momentos Decisivos -->
                                            <div class="bg-gray-50 border border-yellow-300 rounded-2xl p-6 shadow-md">
                                                <div class="flex items-center mb-6">
                                                    <h2 class="text-2xl font-semibold text-gray-800">Momentos Decisivos</h2>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                                        <h3 class="font-semibold text-gray-800">1° Momento</h3>
                                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos_alteracao['primeiroMomento'] ?>
                                            </span>

                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                                            <p class="text-gray-800 text-sm">
                                                                <?php echo $momentos_decisivos_alteracao['momentoInicial1'] . ' até ' . $momentos_decisivos_alteracao['momentoFinal1'] ?>
                                                            </p>
                                                            <p>
                                                                <?php
                                                                $ano_inicio = $momentos_decisivos_alteracao['momentoInicial1'];
                                                                $ano_fim = $momentos_decisivos_alteracao['momentoFinal1'];
                                                                $diferenca_anos = is_numeric($ano_fim) ? ($ano_fim - $ano_inicio) : null;
                                                                ?>
                                                                <span class="text-gray-500 text-sm font-semibold">
                                                    duração: <?php echo $diferenca_anos; ?> anos <?php ; ?>
                                                </span
                                                            </p>
                                                            <p>
                                                                <?php
                                                                $ano_inicio_comeco = $momentos_decisivos_alteracao['momentoInicial1'];
                                                                // Cálculo da idade no período
                                                                $soma_anos = $ano_fim - $ano_inicio_comeco;
                                                                ?>
                                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: 0 anos até <?php echo $soma_anos; ?> anos <?php ; ?>
                                                </span
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                                        <h3 class="font-semibold text-gray-800">2° Momento</h3>
                                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos_alteracao['segundoMomento'] ?>
                                            </span>
                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                                            <p class="text-gray-800 text-sm">
                                                                <?php echo $momentos_decisivos_alteracao['momentoInicial2'] . ' até ' . $momentos_decisivos_alteracao['momentoFinal2'] ?>
                                                            </p>
                                                            <p>
                                                                <?php
                                                                $ano_inicio = $momentos_decisivos_alteracao['momentoInicial2'];
                                                                $ano_fim = $momentos_decisivos_alteracao['momentoFinal2'];
                                                                $diferenca_anos = is_numeric($ano_fim) ? ($ano_fim - $ano_inicio) : null;
                                                                ?>
                                                                <span class="text-gray-500 text-sm font-semibold">
                                                    duração: <?php echo $diferenca_anos; ?> anos <?php ; ?>
                                                </span
                                                            </p>
                                                            <p>
                                                                <?php
                                                                $ano_inicio_comeco = $momentos_decisivos_alteracao['momentoInicial1'];
                                                                // Cálculo da idade no período
                                                                $soma_anos = $ano_fim - $ano_inicio_comeco;
                                                                $idade_inicio = $ano_inicio - $ano_inicio_comeco;
                                                                ?>
                                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: <?php echo $idade_inicio; ?> anos até <?php echo $soma_anos; ?> anos <?php ; ?>
                                                </span
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                                        <h3 class="font-semibold text-gray-800">3° Momento</h3>
                                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos_alteracao['terceiroMomento'] ?>
                                            </span>
                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                                            <p class="text-gray-800 text-sm">
                                                                <?php echo $momentos_decisivos_alteracao['momentoInicial3'] . ' até ' . $momentos_decisivos_alteracao['momentoFinal3'] ?>
                                                            </p>
                                                            <p>
                                                                <?php
                                                                $ano_inicio = $momentos_decisivos_alteracao['momentoInicial3'];
                                                                $ano_fim = $momentos_decisivos_alteracao['momentoFinal3'];
                                                                $diferenca_anos = is_numeric($ano_fim) ? ($ano_fim - $ano_inicio) : null;
                                                                ?>
                                                                <span class="text-gray-500 text-sm font-semibold">
                                                    duração: <?php echo $diferenca_anos; ?> anos <?php ; ?>
                                                </span
                                                            </p>
                                                            <p>
                                                                <?php
                                                                $ano_inicio_comeco = $momentos_decisivos_alteracao['momentoInicial1'];
                                                                // Cálculo da idade no período
                                                                $soma_anos = $ano_fim - $ano_inicio_comeco;
                                                                $idade_inicio = $ano_inicio - $ano_inicio_comeco;
                                                                ?>
                                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: <?php echo $idade_inicio; ?> anos até <?php echo $soma_anos; ?> anos <?php ; ?>
                                                </span
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="border border-purple-300 rounded-lg p-4 bg-white shadow-sm">
                                                        <h3 class="font-semibold text-gray-800">4° Momento</h3>
                                                        <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $momentos_decisivos_alteracao['quartoMomento'] ?>
                                            </span>
                                                        </div>
                                                        <div class="mt-2">
                                                            <p class="text-gray-500 text-sm font-semibold">Período</p>
                                                            <p class="text-gray-800 text-sm">
                                                                <?php echo $momentos_decisivos_alteracao['momentoInicial4'] . ' até ' . $momentos_decisivos_alteracao['momentoFinal4'] ?>
                                                            </p>
                                                            <p>
                                                                <?php
                                                                $ano_inicio = $momentos_decisivos_alteracao['momentoInicial1'];
                                                                $ano_fim = $momentos_decisivos_alteracao['momentoInicial4'];
                                                                $idade_inicio = $ano_fim - $ano_inicio;
                                                                ?>
                                                            </p>
                                                            <p>
                                                <span class="text-gray-500 text-sm font-semibold">
                                                    Tempo: <?php echo $idade_inicio; ?> anos até o fim<?php ; ?>
                                                </span
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <p class="text-gray-500">Nenhuma data de alteração disponível.</p>
                                <?php endif; ?>
                            </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Função para abrir e fechar o modal
                        document.querySelectorAll('a[data-modal]').forEach(openModalButton => {
                            const modalId = openModalButton.getAttribute('data-modal');
                            const modal = document.getElementById(modalId);
                            const closeModalButton = modal.querySelector('.closeModal');

                            // Abrir o modal ao clicar no link
                            openModalButton.addEventListener('click', function(event) {
                                event.preventDefault(); // Prevenir comportamento padrão do link
                                modal.style.display = 'flex'; // Mostrar o modal
                            });

                            // Fechar o modal ao clicar no botão de fechar
                            closeModalButton.addEventListener('click', function() {
                                modal.style.display = 'none'; // Esconder o modal
                            });

                            // Fechar o modal ao clicar fora do conteúdo
                            window.addEventListener('click', function(event) {
                                if (event.target === modal) {
                                    modal.style.display = 'none';
                                }
                            });
                        });
                    });
                </script>
                <footer class="mt-6">
                    <!--<a href="<?php // echo esc_url(home_url('/empresas')); ?>" class="text-blue-600 hover:underline">Voltar para a listagem de Empresas</a>-->
                </footer>
            </article>

        <?php endwhile;
    else : ?>
        <p>Nenhuma empresa encontrada.</p>
    <?php endif; ?>
</div>

<?php
get_footer();
