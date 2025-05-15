<?php
include_once __DIR__ . "/Numerologia.php";
include_once __DIR__ . "/NumerologiaDados.php";
// Recupera todos os metadados da placa na query
$post_meta = get_post_meta(get_the_ID());


if (
    !empty($post_meta) && is_array($post_meta) &&
    isset($post_meta['razao_social'][0], $post_meta['nome_fantasia'][0], $post_meta['data_abertura'][0], $post_meta['data_alteracao'][0])
) {

    $razao_social = $post_meta['razao_social'][0];
    $nome_fantasia = $post_meta['nome_fantasia'][0];
    $data_abertura = formatBrDate($post_meta['data_abertura'][0]);
    $data_alteracao = formatBrDate($post_meta['data_alteracao'][0]);
}
$post_meta = NULL;

$dados = new NumerologiaDados();
$areas = $dados->obterAreasDeAtuacao();

$post_id = get_the_ID();
$saved_area = get_post_meta($post_id, 'area_de_atuacao', true);

// Função para retornar o array no formato desejado
$get_area = function($saved_area) use ($areas) {
    if ($saved_area && isset($areas[$saved_area])) {
        return [
            $saved_area => $areas[$saved_area]
        ];
    }

    return null; // Retorna null se não encontrar
};

// Usa a função
$area_completa = $get_area($saved_area);
if (is_array($area_completa) && !empty($area_completa)) {
    $nome_area = array_keys($area_completa)[0];
} else {
    $nome_area = null; // ou o que fizer sentido no seu caso
}

$numerologia = new Numerologia(); // extenssão 
// razao social
$expressao_razao = $numerologia->calcularNumeroExpressao($razao_social);
$expressao_options = get_field('expressao_empresarial', 'option');
$expressao_razao_content = getUserCalculusResultContent($expressao_options, $expressao_razao, "", 'numero', 'descricao');
$impressao_razao = $numerologia->calcularNumeroImpressao($razao_social);
$impressao_options = get_field('impressao_empresarial', 'option');
$impressao_razao_content = getUserCalculusResultContent($impressao_options,$impressao_razao, "", 'numero', 'descricao' );
$motivacao_razao = $numerologia->calcularNumeroMotivacao($razao_social);
$motivacao_options = get_field('motivacao_empresarial', 'option');
$motivacao_razao_content = getUserCalculusResultContent($motivacao_options, $motivacao_razao, "", 'numero', 'texto');


// data abertura
$desafios = $numerologia->carcularDesafios ($data_abertura);
$desafios_content = get_field('desafio_empresarial', 'option');
$desafio_empresarial_content = getUserCalculusResultContent($desafios_content, $desafios, " ", 'numero', 'descricao');
$resultado_desafios_empresarial = [];

foreach ($desafios as $key => $numero) {
    foreach ($desafios_content as $item) {
        if ($item['numero'] == $numero) {
            $resultado_desafios_empresarial[] = $item;
        }
    }
}
$destino_options = get_field('destino_empresarial', 'option');
$destino = $numerologia->calcularNumeroDestino($data_abertura);
$destino_empresarial_content = getUserCalculusResultContent($destino_options, $destino, " ", 'numero_destino', 'texto_destino');
$missao = $numerologia->calcularNumeroMissao ($destino, $expressao_razao);
$missao_options = get_field('missao_empresarial', 'option');

//$licoes_carmicas = explode(', ' ,$numerologia->calcularLicoesCarmicas($razao_social));
$licoes_carmicas = $numerologia->calcularLicoesCarmicas($razao_social);  // sem explode
$ciclos = $numerologia->calcularCiclos ($data_abertura, $licoes_carmicas); //lições carmicas?
// As opções dos ciclos obtidas
$primeiro_ciclo_empresarial_options = get_field('primeiro_ciclo', 'option');
$segundo_ciclo_empresarial_options = get_field('segundo_ciclo', 'option');
$terceiro_empresarial_options = get_field('terceiro_ciclo', 'option');
$ciclos_textos = [
    'ciclo_1' => extrairTextos($primeiro_ciclo_empresarial_options, 'numero', 'texto'),
    'ciclo_2' => extrairTextos($segundo_ciclo_empresarial_options, 'numero', 'texto'),
    'ciclo_3' => extrairTextos($terceiro_empresarial_options, 'numero', 'texto'),
];
$ciclos_textos_empresa = gerarCiclosComTexto($ciclos, $ciclos_textos);

$momentos_decisivos = $numerologia->momentosDecisivos ($data_abertura, $ciclos['fim_primeiro_ciclo']);
$momentos_decisivos_options = get_field('momentos', 'option');
$numeros_momentos = array_filter(
    $momentos_decisivos,
    function ($key) {
        return str_ends_with($key, "Momento");
    },
    ARRAY_FILTER_USE_KEY
);

$textos_momentos = [];
foreach ($numeros_momentos as $key => $numero) {
    foreach ($momentos_decisivos_options as $momento) {
        if ((int) $momento['numero'] === $numero) {
            $textos_momentos[] = $momento;
        }
    }
}
$momento_decisivo_numero = [];
foreach ($numeros_momentos as $key => $numero) {
    $momento_decisivo_numero[] = $numero;
}
$numeros_harmonicos = $numerologia->numerosHarmonicos($data_abertura);
$dias_favoraveis = explode(', ', $numerologia->obterDiasFavoraveis($data_abertura));
$missao_empresarial_content = getUserCalculusResultContent($missao_options, $missao, "", 'numero', 'descricao');


// nome fantasia 
$expressao_fantasia = $numerologia->calcularNumeroExpressao($nome_fantasia);
$expressao_fantasia_content = getUserCalculusResultContent($expressao_options, $expressao_fantasia, "", 'numero', 'descricao');
$impressao_fantasia = $numerologia->calcularNumeroImpressao($nome_fantasia);
$impressao_fantasia_content = getUserCalculusResultContent($impressao_options,$impressao_fantasia, "", 'numero', 'descricao' );
$motivacao_fantasia = $numerologia->calcularNumeroMotivacao($nome_fantasia);
$motivacao_fantasia_content = getUserCalculusResultContent($motivacao_options, $motivacao_fantasia, "", 'numero', 'texto');

// data alteracao
$destino_alteracao = $numerologia->calcularNumeroDestino($data_alteracao);
$missao_alteracao = $numerologia->calcularNumeroMissao ($destino_alteracao, $expressao);
$desafios_alteracao = $numerologia->carcularDesafios ($data_alteracao);
$ciclos_alteracao = $numerologia->calcularCiclos ($data_alteracao, $licoes_carmicas); //lições carmicas?
$momentos_decisivos_alteracao = $numerologia->momentosDecisivos ($data_alteracao, $ciclos_alteracao['fim_primeiro_ciclo']);
$numeros_harmonicos_alteracao = $numerologia->numerosHarmonicos($data_alteracao);
$dias_favoraveis_alteracao = explode(', ', $numerologia->obterDiasFavoraveis($data_alteracao));

function gerarCiclosComTexto($ciclos, $ciclos_textos) {
    $result = [];

    if (isset($ciclos['ciclos']) && is_array($ciclos['ciclos'])) {
        foreach ($ciclos['ciclos'] as $key => $ciclo) {
            if (isset($ciclo['numero'], $ciclos_textos[$key][$ciclo['numero']])) {
                $result[$key] = [
                    'ciclo' => $ciclo['ciclo'],
                    'numero' => $ciclo['numero'],
                    'periodo' => $ciclo['periodo'],
                    'texto' => $ciclos_textos[$key][$ciclo['numero']]
                ];
            }
        }
    }

    return $result;
}
function extrairTextos($ciclo_options, $numero_chave, $texto_chave)
{
    $textos_ciclo = [];

    // Iterando sobre os dados de ciclo e organizando por número e texto
    foreach ($ciclo_options as $item) {
        // Adiciona ao array com o número como chave e o texto como valor
        $textos_ciclo[$item[$numero_chave]] = $item[$texto_chave];
    }

    return $textos_ciclo;
}
function getUserCalculusResultContent($options, $numero, $content, $index, $select_index)
{
    foreach ($options as $option):
        if ($option[$index] == $numero):
            $content = $option[$select_index];
            break;
        endif;
    endforeach;

    return $content;
}
function formatBrDate($date)
{
    $dateTime = DateTime::createFromFormat('Y-m-d', $date);
    if ($dateTime) {
        return $dateTime->format('Y-m-d'); // Retorna no formato adequado para o input type="date"
    }
    return ''; // Ou retorne uma data padrão se necessário
}

function render_modal($id, $titulo, $conteudo) {
    ?>
    <!-- Modal -->
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <h2 class="text-2xl font-bold mb-4">Número <?php echo esc_html($titulo); ?></h2>
            <p><?php echo esc_html($conteudo); ?></p>
            <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}


function renderizarBloco($id, $titulo, $valor, $modal, $opcoes, $tipoOpcao) {
    ?>
    <div class="border border-green-300 rounded-lg p-4 shadow-md bg-white">
        <div class="flex items-center justify-between">
            <!-- Resultado com estilo -->
            <span id="resultado-<?= $id ?>"
                  class="border border-purple-300 text-purple-700 bg-purple-50 rounded-full px-3 py-1 text-sm font-medium mr-2">
            <?= $valor ?>
        </span>
            <!-- Título -->
            <span class="text-lg font-semibold text-gray-800"><?= $titulo ?></span>
        </div>
        <!-- Link para detalhes -->
        <a href="#"
           class="text-blue-500 text-sm mt-2 inline-block text-right hover:underline transition"
           data-modal="<?= $modal ?>">
            Ver detalhes
        </a>
    </div>

    <?php foreach ($opcoes as $opcao): ?>
        <?php if ($opcao[$tipoOpcao] == $valor):
            $tipo_opcao = explode('_', $tipoOpcao);
        ?>
            <?php render_modal($modal, $valor, $opcao['texto' . $tipo_opcao[1]] ); ?>
        <?php endif; ?>
    <?php endforeach;
}
function renderizarBlocoDois($id, $titulo, $valor, $modal, $opcoes, $tipoOpcao) {
    ?>
    <div class="border border-green-300 rounded-lg p-4 shadow-md bg-white">
        <div class="flex items-center justify-between">
            <!-- Resultado com estilo -->
            <span id="resultado-<?= $id ?>"
                  class="border border-purple-300 text-purple-700 bg-purple-50 rounded-full px-3 py-1 text-sm font-medium mr-2">
            <?= $valor ?>
        </span>
            <!-- Título -->
            <span class="text-lg font-semibold text-gray-800"><?= $titulo ?></span>
        </div>
        <!-- Link para detalhes -->
        <a href="#"
           class="text-blue-500 text-sm mt-2 inline-block text-right hover:underline transition"
           data-modal="<?= $modal ?>">
            Ver detalhes
        </a>
    </div>

    <?php foreach ($opcoes as $opcao): ?>
        <?php if ($opcao[$tipoOpcao] == $valor):
            $tipo_opcao = explode('_', $tipoOpcao);
            ?>
            <?php render_modal($modal, $valor, $opcao['descricao' . $tipo_opcao[1]] ); ?>
        <?php endif; ?>
    <?php endforeach;
}

function renderizarBlocoTres($id, $titulo, $valor, $modal, $opcoes, $tipoOpcao) {
    ?>
    <div class="border border-green-300 rounded-lg p-4 shadow-md bg-white">
        <div class="flex items-center justify-between">
            <!-- Resultado com estilo -->
            <span id="resultado-<?= $id ?>"
                  class="border border-purple-300 text-purple-700 bg-purple-50 rounded-full px-3 py-1 text-sm font-medium mr-2">
            <?= $valor ?>
            </span>
            <!-- Título -->
            <span class="text-lg font-semibold text-gray-800"><?= $titulo ?></span>
        </div>
        <!-- Link para detalhes -->
        <a href="#"
           class="text-blue-500 text-sm mt-2 inline-block text-right hover:underline transition"
           data-modal="<?= $modal ?>">
            Ver detalhes
        </a>
    </div>

    <?php foreach ($opcoes as $opcao): ?>
        <?php if ($opcao[$tipoOpcao] == $valor): ?>
            <!-- Acessa o 'texto_destino' baseado no 'numero_destino' -->
            <?php render_modal($modal, $valor, $opcao['texto_destino']); ?>
        <?php endif; ?>
    <?php endforeach;
}


function renderizarNumerosHarmonicos($titulo, $numerosHarmonicos, $modal = null) {
    ?>
    <div class="flex items-center w-full gap-4 mb-4 p-4 border border-gray-300 rounded-lg shadow-md bg-white">
        <!-- Título -->
        <h2 class="text-sm font-semibold text-gray-800 whitespace-nowrap"><?= $titulo ?></h2>

        <!-- Números Harmônicos -->
        <div class="flex flex-wrap gap-2">
            <?php foreach ($numerosHarmonicos as $num): ?>
                <span class="bg-gray-100 text-purple-700 border border-purple-300 rounded-full px-3 py-1 text-sm font-medium shadow-sm">
                <?= $num ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
}

function renderizarMomentosDecisivos($titulo, $momentos_decisivos, $modal) {
    ?>
    <div class="flex bg-white gap-4 w-full p-4 rounded-lg shadow-md items-start border border-solid border-borda-laranja">
        <h2 class="text-xl font-semibold text-gray-800"><?= $titulo ?></h2>

        <div class="mt-4 flex flex-wrap gap-6">
            <?php for ($i = 1; $i <= 4; $i++): ?>
                <div class="flex items-center mb-4">
                <span class="bg-gray-100 text-gray-700 border border-[#bc9fc9] rounded-full px-3 py-2 mr-3 text-sm font-medium shadow-md">
                    <?php
                    // Exibindo os momentos decisivos com base no índice
                    $momentoKey = "momentoInicial{$i}";
                    echo $momentos_decisivos["primeiroMomento"] ?? ''; // Default caso não exista
                    ?>
                </span>
                    <div class="flex flex-col">
                        <span class="font-medium text-gray-600"><?= $momentos_decisivos["momentoInicial{$i}"] ?> até <?= $momentos_decisivos["momentoFinal{$i}"] ?></span>
                        <span class="text-sm text-gray-500"><?= $momentos_decisivos["descricao{$i}"] ?? 'Sem descrição' ?></span>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <?php

}
function renderizarCiclos($ciclos) {
    if (!empty($ciclos)) {
        foreach ($ciclos['ciclos'] as $nome_ciclo => $dados_ciclo) {
            ?>
            <div class="border border-green-300 rounded-lg p-4 shadow-md bg-white mb-4">
                <div class="flex flew-wrap items-center justify-between">
                    <!-- Número do Ciclo -->
                    <span class="border border-purple-300 text-purple-700 bg-purple-50 rounded-full px-3 py-1 text-sm font-medium mr-2">
            <?= $dados_ciclo['numero'] ?>
        </span>
                    <!-- Período -->
                    <div class="text-lg text-gray-800">
                        <strong>Período:</strong><br>
                        <?= $dados_ciclo['periodo'] ?>
                    </div>
                </div>
            </div>

            <?php
        }

        if (!empty($ciclos['alertas'])) {
            foreach ($ciclos['alertas'] as $alerta) {
                ?>
                <div class="border border-red-300 rounded-lg p-4 shadow-md bg-red-50 mb-4">
                    <div class="flex items-center">
                        <!-- Ícone de alerta -->
                        <svg class="w-6 h-6 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 18.93a10.004 10.004 0 0113.86 0M12 2a10 10 0 00-10 10v1a10 10 0 0010 10 10 10 0 0010-10v-1a10 10 0 00-10-10z" />
                        </svg>
                        <!-- Texto de Alerta -->
                        <span class="text-red-700 font-medium">
            Alerta: <?= $alerta ?>
        </span>
                    </div>
                </div>

                <?php
            }
        }
    } else {
        ?>
        <div class="border border-gray-300 rounded-lg p-4 shadow-md bg-gray-50 mb-4 flex items-center">
            <!-- Ícone de informação -->
            <svg class="w-6 h-6 text-gray-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m0-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
            <!-- Mensagem -->
            <p class="text-gray-700 font-medium">Nenhum ciclo encontrado.</p>
        </div>

        <?php
    }
}
function gerarCiclosComTextos($ciclos, $ciclos_textos) {
    $result = [];

    if (isset($ciclos['ciclos']) && is_array($ciclos['ciclos'])) {
        foreach ($ciclos['ciclos'] as $key => $ciclo) {
            if (isset($ciclo['numero'], $ciclos_textos[$key][$ciclo['numero']])) {
                $result[$key] = [
                    'ciclo' => $ciclo['ciclo'],
                    'numero' => $ciclo['numero'],
                    'periodo' => $ciclo['periodo'],
                    'texto' => $ciclos_textos[$key][$ciclo['numero']]
                ];
            }
        }
    }

    return $result;
}




