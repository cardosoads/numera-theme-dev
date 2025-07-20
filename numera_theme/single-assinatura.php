<?php
/**
 * The template for displaying single Assinatura posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package numera_theme
 */

// Inclui os dados necessários para o template
include_once __DIR__ . "/inc/template-single-assinatura-functions.php";
include_once __DIR__ . "/inc/template-modals.php";

get_header();
?>

    <div class="container mx-auto p-4 max-w-[1400px]">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-4">
                    <h1 class="entry-title text-2xl font-bold"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <form id="edit-assinatura-form" class="space-y-6">
                        <div class="flex gap-4">
                            <div style="width: 75%;" class="mb-4">
                                <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
                                <label for="nome_completo" class="block text-sm font-medium text-gray-700">Nome Completo</label>
                                <input type="text" id="nome_completo" name="nome_completo"
                                       value="<?php echo esc_attr($nome_completo); ?>"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div style="width: 25%;" class="mb-4">
                                <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                                <input type="date" id="data_nascimento" name="data_nascimento"
                                       value="<?php echo transformDate($data_nascimento); ?>"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <button type="submit"
                                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none">
                                Calcular
                            </button>
                        </div>
                    </form>

                    <div id="tabs-content">
                        <div class="mb-6">
                            <div class="text-center space-y-6 border border-gray-300 rounded-2xl bg-white p-6 shadow-sm mt-4" id="numerologia-results">
                                <h2 class="text-2xl font-semibold text-gray-900">Análise de Assinatura</h2>

                                <!-- Exibir números de consoantes (impressões) -->
                                <div class="flex justify-center flex-wrap gap-2" id="consoantes-result">
                                    <span id="consoantes" class="hidden"><?php echo json_encode($consoantes); ?></span>
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <?php if (preg_match('/\p{L}/u', $letra) || (is_numeric($letra) && trim($letra) !== ' ')): ?>
                                                <div class="bg-green-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                                                    <?php echo isset($consoantes[$letra]) ? $consoantes[$letra] : ' '; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-8 h-8"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Exibir letras do nome completo -->
                                <div class="flex justify-center flex-wrap gap-2" id="letras-result">
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <div class="text-gray-900 font-medium">
                                                <?php echo esc_html($letra); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Exibir números de vogais (motivações) -->
                                <div class="flex justify-center flex-wrap gap-2" id="vogais-result">
                                    <span id="vogais" class="hidden"><?php echo json_encode($vogais); ?></span>
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <?php if (preg_match('/\p{L}/u', $letra) || (is_numeric($letra) && trim($letra) !== ' ')): ?>
                                                <div class="bg-blue-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                                                    <?php echo isset($vogais[$letra]) ? $vogais[$letra] : ' '; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-8 h-8"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Exibir números de expressão (alfabeto) -->
                                <div class="flex justify-center flex-wrap gap-2" id="all-vl-result">
                                    <span id="alfabeto" class="hidden"><?php echo json_encode($alfabeto); ?></span>
                                    <?php foreach ($letras_nome as $letra): ?>
                                        <div class="flex flex-col items-center w-8">
                                            <?php if (preg_match('/\p{L}/u', $letra) || (is_numeric($letra) && trim($letra) !== ' ')): ?>
                                                <div class="bg-purple-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">
                                                    <?php echo isset($alfabeto[$letra]) ? $alfabeto[$letra] : ' '; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="w-8 h-8"></div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Exibir somatórias das partes (Motivação e Expressão) -->
                                <div class="flex justify-center flex-wrap gap-2" id="somatorias-partes-result">
                                    <?php
                                    $posicoes_partes = [];

                                    // Transforma cada letra do nome completo em minúscula (com suporte a acentos)
                                    $letras_nome_lower = array_map(fn($l) => mb_strtolower($l, 'UTF-8'), $letras_nome);
                                    $nome_completo_junto = implode('', $letras_nome_lower);

                                    // Localiza as posições de cada parte no nome completo
                                    foreach ($partes_nome_com_dados as $parte_dados) {
                                        $parte_nome = mb_strtolower($parte_dados['parte'], 'UTF-8');
                                        $posicao_str = mb_strpos($nome_completo_junto, $parte_nome, 0, 'UTF-8');

                                        if ($posicao_str !== false) {
                                            $prefixo = mb_substr($nome_completo_junto, 0, $posicao_str, 'UTF-8');
                                            $posicao_inicial = mb_strlen($prefixo, 'UTF-8');

                                            $posicoes_partes[] = [
                                                'posicao' => $posicao_inicial,
                                                'motivacao' => $parte_dados['motivacao'],
                                                'expressao' => $parte_dados['expressao'],
                                                'tamanho' => mb_strlen($parte_nome, 'UTF-8'),
                                            ];
                                        }
                                    }

                                    // Exibe os quadradinhos
                                    $indice_parte = 0;
                                    $letras_exibidas = 0;

                                    for ($i = 0; $i < count($letras_nome); $i++) {
                                        // Verifica se é o início de uma parte
                                        if ($indice_parte < count($posicoes_partes) && $i === $posicoes_partes[$indice_parte]['posicao']) {
                                            // Motivação
                                            echo '<div class="flex flex-col items-center w-8">';
                                            echo '<div class="bg-yellow-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">';
                                            echo esc_html($posicoes_partes[$indice_parte]['motivacao']);
                                            echo '</div>';
                                            echo '</div>';

                                            $i++;

                                            // Expressão
                                            echo '<div class="flex flex-col items-center w-8">';
                                            echo '<div class="bg-red-500 text-white rounded-lg shadow-md w-8 h-8 flex items-center justify-center">';
                                            echo esc_html($posicoes_partes[$indice_parte]['expressao']);
                                            echo '</div>';
                                            echo '</div>';

                                            $letras_exibidas = 2;
                                            $indice_parte++;
                                        } elseif ($letras_exibidas > 0 && $indice_parte > 0 && $letras_exibidas < $posicoes_partes[$indice_parte - 1]['tamanho']) {
                                            // Espaços ocupados pela parte do nome (sem número)
                                            echo '<div class="w-8 h-8"></div>';
                                            $letras_exibidas++;
                                        } else {
                                            // Espaços vazios
                                            $letras_exibidas = 0;
                                            echo '<div class="w-8 h-8"></div>';
                                        }
                                    }
                                    ?>
                                </div>

                                <!-- Legendas -->
                                <div class="flex flex-wrap gap-6 justify-center py-6">
                                    <?php
                                    $legendas = [
                                        'Impressão' => 'bg-green-500',
                                        'Motivação' => 'bg-blue-500',
                                        'Expressão' => 'bg-purple-500',
                                        'Somatória das partes (Motivação)' => 'bg-yellow-500',
                                        'Somatória das partes (Expressão)' => 'bg-red-500',
                                    ];
                                    ?>
                                    <?php foreach ($legendas as $legenda => $cor): ?>
                                        <div class="flex items-center gap-2">
                                            <span class="block w-4 h-4 <?php echo esc_html($cor); ?> rounded-full shadow"></span>
                                            <p class="text-gray-600"><?php echo esc_html($legenda); ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Resultados dos Cálculos -->
                        <div class="bg-gray-50 p-8 rounded-2xl shadow-lg mb-8 border border-gray-300">
                            <h3 class="text-2xl font-semibold mb-6 text-gray-900">Resultados dos Cálculos</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Resultado de Motivação -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                    <span id="resultado-motivacao"
                                          class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                        <?php echo $numero_motivacao; ?>
                                    </span>
                                        <span class="text-lg font-medium text-gray-800">Motivação</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-motivacao">Ver detalhes</a>
                                </div>
                                <?php render_modal('modal-motivacao', $numero_motivacao, $motivacao_content, $motivacao_orientacao); ?>

                                <!-- Resultado de Impressão -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                    <span id="resultado-impressao"
                                          class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                        <?php echo $numero_impressao; ?>
                                    </span>
                                        <span class="text-lg font-medium text-gray-800">Impressão</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-impressao">Ver detalhes</a>
                                </div>
                                <?php render_modal('modal-impressao', $numero_impressao, $impressao_content, $impressao_orientacao); ?>

                                <!-- Resultado de Expressão -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                    <span id="resultado-expressao"
                                          class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                        <?php echo $numero_expressao; ?>
                                    </span>
                                        <span class="text-lg font-medium text-gray-800">Expressão</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-expressao">Ver detalhes</a>
                                </div>
                                <?php render_modal('modal-expressao', $numero_expressao, $expressao_content, $expressao_orientacao); ?>

                                <!-- Resultado de Arcano -->
                                <div class="border border-green-300 rounded-2xl p-6 bg-white shadow-sm">
                                    <div class="flex items-center justify-between">
                                    <span id="resultado-arcano"
                                          class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                        <?php echo $arcanoAtual['arcano']; ?>
                                    </span>
                                        <span class="text-lg font-medium text-gray-800">Arcano</span>
                                    </div>
                                    <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                       data-modal="modal-arcano">Ver detalhes</a>
                                </div>
                                <?php
                                $dados = [];
                                foreach ($arcano_basicavida_options as $arcano) {
                                    if ($arcano['numero_arcano_basicavida'] == $arcanoAtual['arcano']) {
                                        $dados = $arcano;
                                    }
                                }
                                render_modal('modal-arcano', "Arcano {$arcanoAtual['arcano']}", $dados['texto_arcano_basicavida'], null, $dados['imagem_arcano']);
                                ?>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6 mt-6">
                                <!-- Bloco Harmonia Conjugal -->
                                <div class="bg-gray-50 rounded-2xl">
                                    <div class="flex items-center mb-6">
                                        <h2 class="text-2xl font-semibold text-gray-800">Harmonia Conjugal</h2>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">
                                        <!-- Vibra Com -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $vibra_com; ?>
                                            </span>
                                                <h3 class="font-semibold text-gray-800">Vibra Com</h3>
                                            </div>
                                        </div>

                                        <!-- Atrai -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $atrai; ?>
                                            </span>
                                                <h3 class="font-semibold text-gray-800">Atrai</h3>
                                            </div>
                                        </div>

                                        <!-- É Oposto -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-lg px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $e_oposto; ?>
                                            </span>
                                                <h3 class="font-semibold text-gray-800">É Oposto</h3>
                                            </div>
                                        </div>

                                        <!-- É Passivo -->
                                        <div class="border border-green-300 rounded-lg p-4 bg-white shadow-sm">
                                            <div class="flex items-center">
                                            <span class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium mr-4">
                                                <?php echo $e_passivo_em_relacao_a; ?>
                                            </span>
                                                <h3 class="font-semibold text-gray-800">É Passivo em relação a</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bloco Números Harmônicos -->
                                <div class="bg-gray-50 rounded-2xl">
                                    <div class="flex flex-col gap-4">
                                        <h3 class="text-2xl font-semibold text-gray-800">Números Harmônicos</h3>
                                        <div class="flex flex-wrap gap-2">
                                            <?php foreach ($numeros_harmonicos as $num): ?>
                                                <span id="resultado-numeros-harmonicos"
                                                      class="bg-purple-50 border border-purple-300 rounded-full px-4 py-2 text-purple-700 font-medium">
                                                <?php echo $num; ?>
                                            </span>
                                            <?php endforeach; ?>
                                        </div>
                                        <a href="#" class="text-blue-600 hover:underline mt-4 block text-right"
                                           data-modal="modal-numeros-harmonicos">Ver detalhes</a>
                                        <?php render_modal_numeros_harmonicos('modal-numeros-harmonicos', "Números Harmônicos", $resultado_numeros_harmonicos); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="entry-footer mt-8">
                    <?php if (has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto mt-4']); ?>
                    <?php endif; ?>
                </footer>
            </article>
        <?php endwhile; ?>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Função para abrir e fechar os modais
            document.querySelectorAll('a[data-modal]').forEach(openModalButton => {
                const modalId = openModalButton.getAttribute('data-modal');
                const modal = document.getElementById(modalId);
                const closeModalButton = modal.querySelector('.closeModal');

                // Abrir o modal ao clicar no link
                openModalButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    modal.style.display = 'flex';
                });

                // Fechar o modal ao clicar no botão de fechar
                closeModalButton.addEventListener('click', function () {
                    modal.style.display = 'none';
                });

                // Fechar o modal ao clicar fora do conteúdo
                window.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.style.display = 'none';
                    }
                });
            });
        });
    </script>

<?php
get_footer();