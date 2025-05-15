<?php
function render_modal($id, $titulo, $conteudo, $orientacao = null)
{
?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <h2 class="text-2xl font-bold mb-4"><?php echo esc_html($titulo); ?></h2>
            <p><?php echo esc_html($conteudo); ?></p>
            <?php if (!empty($orientacao)) : ?>
                <div class="bg-gray-200 p-4 rounded-2xl">
                    <h3 class="font-bold">Orientação</h3>
                    <p><?php echo esc_html($orientacao); ?></p>
                </div>
            <?php endif; ?>
            <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
<?php
}
function render_modal_licoes($id, $licoes_carmicas, $orientacao = null)
{
    ?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%] z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4">Lições Cármicas</h2>

            <?php foreach ($licoes_carmicas as $licao) : ?>
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-xl font-semibold text-purple-700 mb-2">Lição <?php echo esc_html($licao['numero_licao_carmica']); ?></h3>
                    <p class="text-gray-800 whitespace-pre-line"><?php echo esc_html($licao['texto_licao_carmica']); ?></p>
                </div>
            <?php endforeach; ?>

            <?php if (!empty($orientacao)) : ?>
                <div class="bg-gray-200 p-4 rounded-2xl mt-4">
                    <h3 class="font-bold">Orientação</h3>
                    <p><?php echo esc_html($orientacao); ?></p>
                </div>
            <?php endif; ?>

            <button class="closeModal mt-6 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}
function render_modal_divida($id, $divida_carmica)
{
    ?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%] z-50">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <h2 class="text-2xl font-bold mb-4">Dívidas Cármicas</h2>

            <?php foreach ($divida_carmica as $divida) : ?>
                <div class="mb-6 border-b pb-4">
                    <h3 class="text-xl font-semibold text-purple-700 mb-2">Dívidas <?php echo esc_html($divida['numero_divida_carmica']); ?></h3>
                    <p class="text-gray-800 whitespace-pre-line"><?php echo esc_html($divida['texto_divida_carmica']); ?></p>
                </div>
            <?php endforeach; ?>
            <button class="closeModal mt-6 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}
function render_modal_with_columns($id, $titulo, $conteudo)
{
    ?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <h2 class="text-2xl font-bold mb-4"><?php echo esc_html($titulo); ?></h2>
            <?php foreach ($conteudo as $dados): ?>
<!--                <p>--><?php //echo esc_html($dados["numero_tendencia_oculta"]); ?><!--</p>-->
                <?php echo esc_html($dados["texto_tendencia_oculta"]); ?><br><br>
            <?php endforeach; ?>
            <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}


function rende_sequences_modal($id, $sequencia, $conteudo)
{
    
    ?>
    <div
            id="<?php echo $id ?>"
            class="modal hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white w-1/3 p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Sequência: <?php echo $sequencia ?></h3>

            <div class="text-sm text-gray-800">
                <h4 class="font-bold mb-2">Conteúdo:</h4>
                <ul class="list-disc pl-5">
                    <li><?php echo htmlspecialchars($conteudo);?></li>
                </ul>
            </div>
            <button
                    class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                    onclick="closeModal('<?php echo $id ?>')">
                Fechar
            </button>
        </div>
    </div>
    <?php
}

function render_piramid_sequences_modal($id, $sequencia, $conteudo)
{
    var_dump($conteudo);
    ?>
    <div
            id="<?php echo $id ?>"
            class="modal hidden fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex items-center justify-center">
        <div class="bg-white w-1/3 p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Sequência: <?php echo $sequencia ?></h3>
            <p class="text-sm text-gray-600 mb-4">
                Aqui você pode adicionar mais informações sobre a sequência <strong><?php echo $sequencia ?></strong>.
            </p>
            <div class="text-sm text-gray-800">
                <h4 class="font-bold mb-2">Conteúdo:</h4>
                <ul class="list-disc pl-5">
                    <?php foreach ($conteudo as $item) : ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <button
                    class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
                    onclick="closeModal('<?php echo $id ?>')">
                Fechar
            </button>
        </div>
    </div>
    <?php
}

function render_arcano_modal($id, $arcano_basicavida_options, $arcano_vez) {
    ?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <?php foreach ($arcano_basicavida_options as $arcano) : ?>
                <?php
//                var_dump($arcano['numero_arcano_basicavida']);
//                var_dump($arcano_vez['arcano']);
                ?>
                <?php if($arcano_vez['arcano'] == $arcano['numero_arcano_basicavida']): ?>
                    <h2 class="text-2xl text-black font-bold mb-4">
                        <?php echo esc_html("Arcano " . $arcano['numero_arcano_basicavida']); ?>
                    </h2>
                    <?php if (!empty($arcano['imagem_arcano'])) : ?>
                        <img src="<?php echo esc_url($arcano['imagem_arcano']); ?>" alt="Imagem do Arcano" class="mb-4 w-[100px] h-auto rounded" />
                    <?php endif; ?>
                    <p class="text-black"><?php echo esc_html($arcano['texto_arcano_basicavida']); ?></p>
                <?php endif; ?>
            <?php endforeach; ?>
            <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}

function render_modal_anjo($id, $titulo, $conteudo, $nome, $numero, $salmo, $vela, $incenso, $cristal, $categoria, $hora_prece)
{
    ?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <h2 class="text-2xl font-bold mb-4">Anjo Nº <?php echo esc_html($numero); ?>, <?php echo esc_html($nome); ?></h2>
            <h3><strong>Categoria:</strong> <?php echo esc_html($categoria); ?></h3>
            <br>
            <p><?php echo esc_html($conteudo); ?></p>
            <div class="bg-gray-200 p-4 rounded-2xl">
                <h2><strong>Hora da prece:</strong> <?php echo esc_html($hora_prece); ?></h2>
                <h2><strong>Vela:</strong> <?php echo esc_html($vela); ?></h2>
                <h2><strong>Incenso:</strong> <?php echo esc_html($incenso); ?></h2>
                <h2><strong>Cristal:</strong> <?php echo esc_html($cristal); ?></h2>
                <h2><strong>Salmo:</strong> <?php echo esc_html($salmo); ?></h2>
            </div>
            <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}
function render_modal_numeros_harmonicos($id, $titulo, $conteudo)
{
    ?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <h2 class="text-2xl font-bold mb-4"><?php echo esc_html($titulo); ?></h2>
            <?php foreach ($conteudo as $dados): ?>
                <!--                <p>--><?php //echo esc_html($dados["numero_numeros_harmonicos"]); ?><!--</p>-->
                <?php echo esc_html($dados["texto_numeros_harmonicos"]); ?><br><br>
            <?php endforeach; ?>
            <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}
function render_modal_ciclos($id, $titulo, $conteudo, $orientacao = null)
{
    ?>
    <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
            <h2 class="text-2xl font-bold mb-4"><?php echo esc_html($titulo); ?></h2>

            <?php foreach ($conteudo as $dados): ?>
                <h3><?php echo esc_html($dados["ciclo"]); ?> <strong>(Número: <?php echo esc_html($dados["numero"]); ?>)</strong></h3>
            <p><?php echo esc_html($dados["texto"]); ?></p>
            <?php endforeach; ?>
            <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    <?php
}

function render_modal_momentos($id, $titulo, $conteudo)
{
    ?>
        <div id="<?php echo esc_attr($id); ?>" class="modal hidden fixed inset-0 items-center justify-center bg-black bg-opacity-50 ml-[16%]">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-4xl w-full">
                <h2 class="text-2xl font-bold mb-4"><?php echo esc_html($titulo); ?></h2>
                <?php
                $momentos = [
                    'Primeiro Momento: ',
                    'Segundo Momento: ',
                    'Terceiro Momento: ',
                    'Quarto Momento: '
                ];
                ?>
                <?php foreach ($conteudo as $index => $dados): ?>
                    <strong><?php echo esc_html($momentos[$index] ?? ''); ?></strong>
                    <?php echo esc_html($dados["numero_momento_decisivo"]); ?> <span> - </span>
                    <?php echo esc_html($dados["texto_momento_decisivo"]); ?><br><br>
                <?php endforeach; ?>
                <button class="closeModal mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
            </div>
        </div>
    <?php
}