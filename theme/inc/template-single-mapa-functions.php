<?php
include_once __DIR__ . "/Numerologia.php";
include_once __DIR__ . "/NumerologiaDados.php";


$post_meta = get_post_meta(get_the_ID());

if ($post_meta !== "") {
    $nome_completo = $post_meta['mapas_details__mapas_nome_completo'][0];
    $data_nascimento = $post_meta['mapas_details__mapas_data_nascimento'][0];
}

$post_meta = NULL;


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_completo_post = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $data_nascimento_post = isset($_POST['dob']) ? sanitize_text_field($_POST['dob']) : '';

    // Se os valores foram enviados via POST, substitua os valores padrão
    $nome_completo = !empty($nome_completo_post) ? $nome_completo_post : $nome_completo;
    $data_nascimento = !empty($data_nascimento_post) ? $data_nascimento_post : $data_nascimento;
}

// Dados
$vogais = NumerologiaDados::obterVogais();
$consoantes = NumerologiaDados::obterConsoantes();
$alfabeto = NumerologiaDados::obterAlfabeto();
$tabelaPiramides = NumerologiaDados::obterTabelaPiramides();
// Calcula os valores baseados nos dados de entrada
$letras_nome = str_split($nome_completo);

$numerologia = new Numerologia();

$partes_nome = $numerologia->separarNomeCompleto($nome_completo);

$numero_destino = $numerologia->calcularNumeroDestino($data_nascimento);  // Baseado na data de nascimento
$numero_expressao = $numerologia->calcularNumeroExpressao($nome_completo);  // Baseado no nome completo
$numero_motivacao = $numerologia->calcularNumeroMotivacao($nome_completo);  // Baseado no nome completo
$numero_impressao = $numerologia->calcularNumeroImpressao($nome_completo);  // Baseado no nome completo
$numero_psiquico = $numerologia->calcularNumeroPsiquico($data_nascimento);  // Baseado na data de nascimento


$partes_nome_com_dados = [];

foreach ($partes_nome as $parte) {
    // Calcula a somatória de motivação (vogais)
    $soma_motivacao = $numerologia->calcularNumeroMotivacao($parte);

    // Calcula a somatória de expressão (todas as letras)
    $soma_expressao = $numerologia->calcularNumeroExpressao($parte);

    // Adiciona a parte com suas somatórias ao novo array
    $partes_nome_com_dados[] = [
        'parte' => $parte,
        'motivacao' => $soma_motivacao,
        'expressao' => $soma_expressao
    ];
}

// Agora $partes_nome_com_dados contém um array onde cada elemento é um array com 3 dados:
$numero_missao = $numerologia->calcularNumeroMissao($numero_destino, $numero_expressao);  // Depende de destino e expressão
//inserção do back
$licoes_carmicas = $numerologia->calcularLicoesCarmicas($nome_completo);  // sem explode
$dividas_carmicas = explode(', ', $numerologia->calculoDividasCarmicas($nome_completo, $data_nascimento));  // Baseado em ambos
$tendencias_ocultas = explode(', ', $numerologia->calcularTendenciaOculta($nome_completo));  // Baseado no nome completo
$harmonia_conjugal = $numerologia->calcularNumeroAmor($numero_destino, $numero_expressao);  // Depende de destino e expressão
$harmonia = $harmonia_conjugal['harmonia'];
$vibra_com = $harmonia_conjugal['vibra_com'];
$atrai = $harmonia_conjugal['atrai'];
$e_oposto = $harmonia_conjugal['e_oposto'];
$e_passivo_em_relacao_a = $harmonia_conjugal['e_passivo_em_relação_a'];

$hamonia_conjugal_options = get_field('hamonia_conjugal', 'option');
$texto_hamononia_conjugal = [];
foreach ($hamonia_conjugal_options as $item) {
    if ($item['numero_hamonia_conjugal'] == $harmonia) {
        $texto_hamononia_conjugal = $item['texto_hamonia_conjugal'];
        break; // para o loop, pois já encontramos o valor desejado
    }
}

$texto_vibra_com = [];
foreach ($hamonia_conjugal_options as $item) {
    if ($item['numero_hamonia_conjugal'] == $vibra_com) {
        $texto_vibra_com = $item['texto_hamonia_conjugal'];
        break;
    }
}
$resposta_subconsciente = $numerologia->calcularRespostaSubconsciente($nome_completo);
$relacoes_intervalores = $numerologia->relacoesIntervalores($nome_completo);
$ano_pessoal = $numerologia->calcularAnoPessoal($data_nascimento);  // Depende do número de destino

$mes_pessoal = $numerologia->mesPessoalCalc($data_nascimento);  // Baseado na data de nascimento
$dia_pessoal = $numerologia->calcularDiaPessoal($data_nascimento);  // Baseado na data de nascimento

$grau_ascensao = $numerologia->grauAscensao($nome_completo);  // Baseado no nome completo
$talento_oculto = $numerologia->talentoOculto($numero_motivacao, $numero_expressao);  // Depende de motivação e expressão
$cores = $numerologia->coresFavoraveis($nome_completo);  // Baseado no nome completo
$arcanos = $numerologia->calcularArcanos($nome_completo, $data_nascimento);
$arcanos = $arcanos['arcanos'];
$arcanoAtual = $numerologia->getArcanoAtual($arcanos);
$arcano_vida = $numerologia->calcularArcanoVida($nome_completo, $data_nascimento);
$arcanos_pessoais = $numerologia->calcularArcanoPessoal($nome_completo, $data_nascimento);

$arcanos_sociais = $numerologia->calcularArcanoSocial($nome_completo, $data_nascimento);
$arcanos_destino = $numerologia->calcularArcanoDestino($nome_completo, $data_nascimento);

$resultado = $numerologia->obterDiasFavoraveis($data_nascimento);
if (is_string($resultado)) {
    $dias_favoraveis = explode(', ', $resultado);
} else {
    // Tratamento alternativo caso não seja string
    $dias_favoraveis = is_array($resultado) ? $resultado : [];
}

$numeros_harmonicos = $numerologia->numerosHarmonicos($data_nascimento);
$ciclos = $numerologia->calcularCiclos($data_nascimento, $licoes_carmicas);
function calcularIdadeNosCiclos($dataNascimento, $ciclos) {
    // Verifica se a string da data está correta
    if (!is_string($dataNascimento) || strlen($dataNascimento) !== 8 || !ctype_digit($dataNascimento)) {
        throw new Exception("Erro: a data de nascimento deve ser uma string no formato 'YYYYMMDD'.");
    }

    // Extraindo dia, mês e ano
    $anoNascimento = substr($dataNascimento, 0, 4);
    $mesNascimento = substr($dataNascimento, 4, 2);
    $diaNascimento = substr($dataNascimento, 6, 2);

    // Criando um objeto DateTime para a data de nascimento
    $dataNascimentoObj = DateTime::createFromFormat('Y-m-d', "$anoNascimento-$mesNascimento-$diaNascimento");

    $idades = [];
    $ultimoCiclo = array_key_last($ciclos); // Obtém a chave do último ciclo

    foreach ($ciclos['ciclos'] as $nomeCiclo => $ciclo) {
        $periodo = $ciclo['periodo'];
        $datas = explode(" - ", $periodo);

        // Obtém o ano de início do ciclo
        $anoInicio = (int) substr($datas[0], -4);
        $idadeInicio = $anoInicio - (int) $anoNascimento;

        // Verifica se é o último ciclo
        if ($nomeCiclo === $ultimoCiclo || stripos($periodo, "Até o fim da vida") !== false) {
            $idadeFim = "Até o fim da vida";
        } else {
            // Obtém o ano de fim do ciclo (se existir)
            $anoFim = isset($datas[1]) ? (int) substr($datas[1], -4) : null;
            $idadeFim = $anoFim ? ($anoFim - (int) $anoNascimento) : "Até o fim da vida";
        }

        $idades[$nomeCiclo] = [
            'idade_inicio' => $idadeInicio,
            'idade_fim' => $idadeFim
        ];
    }

    return $idades;
}

$idades = calcularIdadeNosCiclos($data_nascimento,$ciclos);
$ciclos_numeros = [];
foreach ($ciclos['ciclos'] as $ciclo) {
    $ciclos_numeros[$ciclo['ciclo']] = $ciclo['numero'];
}
$fim_primeiro_ciclo = $ciclos['fim_primeiro_ciclo'];
$momentos_decisivos = $numerologia->momentosDecisivos($data_nascimento, $fim_primeiro_ciclo);
$numeros_momentos = array_filter(
    $momentos_decisivos,
    function ($key) {
        return str_ends_with($key, "Momento");
    },
    ARRAY_FILTER_USE_KEY
);

$desafios = $numerologia->carcularDesafios($data_nascimento);
$piramide_vida = $numerologia->calcularPiramdeVida($nome_completo);
// Obtendo o último array
$ultimo_array_piramide_vida = end($piramide_vida);
$sequencia_piramide_vida = $numerologia->sequenciaVibracional($piramide_vida);
$sequencias_vida = $numerologia->sequenciasEncontradas($sequencia_piramide_vida);


$piramide_pessoal = $numerologia->calcularPiramdePessoal($nome_completo, $data_nascimento);
$ultimo_array_piramide_pessoal = end($piramide_pessoal);
$sequencia_piramide_pessoal = $numerologia->sequenciaVibracional($piramide_pessoal);
$sequencias_pessoal = $numerologia->sequenciasEncontradas($sequencia_piramide_pessoal);

$piramide_social = $numerologia->calcularPiramdeSocial($nome_completo, $data_nascimento);
$ultimo_array_piramide_social = end($piramide_social);
$sequencia_piramide_social = $numerologia->sequenciaVibracional($piramide_social);
$sequencias_social = $numerologia->sequenciasEncontradas($sequencia_piramide_social);
$piramide_destino = $numerologia->calcularPiramdeDestino($nome_completo, $data_nascimento);
$ultimo_array_piramide_destino = end($piramide_destino);
$sequencia_piramide_destino = $numerologia->sequenciaVibracional($piramide_destino);
$sequencias_destino = $numerologia->sequenciasEncontradas($sequencia_piramide_destino);
$vocacional = $numerologia->calcularTesteVocacional($numero_destino, $numero_missao, $numero_expressao, $data_nascimento);

$anjo = $numerologia->buscaAnjo($data_nascimento);

// Retorna o conteúdo da array de MOTIVACAO do usuário
$motivacao_options = get_field('motivacao', 'option');
$motivacao_content = getUserCalculusResultContent($motivacao_options, $numero_motivacao, "", 'numero_motivacao', 'texto_motivacao');
$motivacao_orientacao = getUserCalculusResultContent($motivacao_options, $numero_motivacao, "", 'numero_motivacao', 'orientacao');
// Retorna o conteúdo da array de IMPRESSAO do usuário
$impressao_options = get_field('impressao', 'option');
$impressao_content = getUserCalculusResultContent($impressao_options, $numero_impressao, "", 'numero_impressao', 'texto_impressao');
$impressao_orientacao = getUserCalculusResultContent($impressao_options, $numero_impressao, "", 'numero_impressao', 'orientacao');

// Retorna o conteúdo da array de EXPRESSAO do usuário
$expressao_options = get_field('expressao', 'option');
$expressao_content = getUserCalculusResultContent($expressao_options, $numero_expressao, "", 'numero_expressao', 'texto_expressao');
$expressao_orientacao = getUserCalculusResultContent($expressao_options, $numero_expressao, "", 'numero_expressao', 'orientacao');
// Retorna o conteúdo da array de ARCANOS do usuário
$arcano_basicavida_options = get_field('arcano_basicavida', 'option');
$arcano_basicavida_content = getUserArcanosCalculusResultContent($arcano_basicavida_options, $arcanos, "");

// Retorna o conteúdo da array de MISSAO do usuário
$missao_options = get_field('missao', 'option');
$missao_content = getUserCalculusResultContent($missao_options, $numero_missao, "", 'numero_missao', 'texto_missao');

// Retorna o conteúdo da array de DESTINO do usuário
$destino_options = get_field('destino', 'option');
$destino_content = getUserCalculusResultContent($destino_options, $numero_destino, "", 'numero_destino', 'texto_destino');
$destino_orientacao = getUserCalculusResultContent($destino_options, $numero_destino, "", 'numero_destino', 'orientacao');
// Retorna o conteúdo da array de ANO PESSOAL do usuário
$ano_pessoal_options = get_field('ano_pessoal', 'option');
$ano_pessoal_content = getUserCalculusResultContent($ano_pessoal_options, $ano_pessoal, "", 'numero_ano_pessoal', 'texto_ano_pessoal');
// Retorna o conteúdo da array de MES PESSOAL do usuário
$numeros_mes_pessoal_options = get_field('numeros_mes_pessoal', 'option');
$mes_pessoal_content = getUserCalculusResultContent($numeros_mes_pessoal_options, $mes_pessoal, "", 'numero_mes_pessoal', 'texto_mes_pessoal');
// Retorna o conteúdo da array de DIA PESSOAL do usuário
$numeros_dia_pessoal_options = get_field('numeros_dia_pessoal', 'option');
$dia_pessoal_content = getUserCalculusResultContent($numeros_dia_pessoal_options, $dia_pessoal, "", 'numero_dia_pessoal', 'texto_dia_pessoal');
$arcano_pessoal_options = get_field('arcano_basicavida', 'option');

$arcano_social_options = get_field('arcano_basicavida', 'option');
$arcano_destino_options = get_field('arcano_basicavida', 'option');
$piramide_basicavida_options = get_field('piramide_basicavida', 'option');
$texto_piramide_vida = buscarTextoPorNumero($ultimo_array_piramide_vida, $piramide_basicavida_options);

$piramide_social_options = get_field('piramide_basicavida', 'option');
$texto_piramide_social = buscarTextoPorNumero($ultimo_array_piramide_social, $piramide_social_options);
$piramide_pessoal_options = get_field('piramide_basicavida', 'option');
$texto_piramide_pessoal = buscarTextoPorNumero($ultimo_array_piramide_pessoal, $piramide_pessoal_options);

$piramide_destino_options = get_field('piramide_basicavida', 'option');
$texto_piramide_destino = buscarTextoPorNumero($ultimo_array_piramide_destino, $piramide_destino_options);
$sequencias_positivas_options = get_field('sequencias_positivas', 'option');
$sequencias_negativas_options = get_field('sequencias_negativas', 'option');

$dias_favoraveis_options = get_field('dias_favoraveis', 'option');
$numeros_harmonicos_options = get_field('numeros_harmonicos', 'option');

$numeros_desafios_options = get_field('numeros_desafios', 'option');

$desafio_content = getUserCalculusResultContent($numeros_desafios_options, $desafios, " ", 'numero_do_desafio', 'texto_desafio');

$numeros_psiquicos_options = get_field('numeros_psiquicos', 'option');
$psiquico_content = getUserCalculusResultContent($numeros_psiquicos_options, $numero_psiquico, " ", 'numero_psiquico', 'texto_numero_psiquico');
$grau_ascenssao_options = get_field('grau_ascenssao', 'option');
$resposta_subconsciente_options = get_field('resposta_subconsciente', 'option');
$resposta_subconsciente_content = getUserCalculusResultContent($resposta_subconsciente_options, $resposta_subconsciente, " ", 'numero_resposta_subconsciente', 'texto_resposta_subconsciente');
$momentos_decisivos_options = get_field('momentos_decisivos', 'option');

$textos_momentos = [];
    foreach ($numeros_momentos as $key => $numero) {
      foreach ($momentos_decisivos_options as $momento) {
        if ((int) $momento['numero_momento_decisivo'] === $numero) {
            $textos_momentos[] = $momento;
        }
    }
}

$momento_decisivo_numero = [];
foreach ($numeros_momentos as $key => $numero) {
    $momento_decisivo_numero[] = $numero;
}
$relacoes_intervalores_options = get_field('relacoes_intervalores', 'option');
$resultado_relacoes_intervalor = getRelacoesIntervalores($relacoes_intervalores, $relacoes_intervalores_options);
if (is_array($resultado_relacoes_intervalor) && isset($resultado_relacoes_intervalor[0])) {
    $resultado_relacoes_intervalor = $resultado_relacoes_intervalor[0];
}

$relacoes_intervalores_content = getUserCalculusResultContent($relacoes_intervalores_options, $relacoes_intervalores, " ", 'numero_relacao_intervalor', 'texto_relacao_intervalor');
$licoes_carmicas_options = get_field('licoes_carmicas', 'option');
$dividas_carmicas_options = get_field('dividas_carmicas', 'option');

// As opções dos ciclos obtidas
$primeiro_ciclo_de_vida_options = get_field('primeiro_ciclo_de_vida', 'option');
$segundo_ciclo_de_vida_options = get_field('segundo_ciclo_de_vida', 'option');
$terceiro_ciclo_de_vida_options = get_field('terceiro_ciclo_de_vida', 'option');

// Criar o array com os textos organizados
$ciclos_textos = [
    'ciclo_1' => extrairTextos($primeiro_ciclo_de_vida_options, 'numero_primeiro_ciclo_de_vida', 'texto_primeiro_ciclo_de_vida'),
    'ciclo_2' => extrairTextos($segundo_ciclo_de_vida_options, 'numero_segundo_ciclo_de_vida', 'texto_segundo_ciclo_de_vida'),
    'ciclo_3' => extrairTextos($terceiro_ciclo_de_vida_options, 'numero_terceiro_ciclo_de_vida', 'texto_terceiro_ciclo_de_vida'),
];

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

// Exemplos de uso:
$ciclos_textos_filtrados = gerarCiclosComTextos($ciclos, $ciclos_textos);

// Exibe o array gerado para verificação
$tendencias_ocultas_options = get_field('tendencias_ocultas', 'option');
$talento_oculto_options = get_field('talento_oculto', 'option');
$talento_content = getUserCalculusResultContent($talento_oculto_options, $talento_oculto , "", 'numero_talento_oculto', 'texto_talento_oculto');
$cores_options = get_field('cores', 'option');
$anjo_options = get_field('anjo', 'option');

$anjo = $anjo[0];
$dia_natalicio_options = get_field('dia_natalicio', 'option');
$dia_natalicio = getDiaNatalicio($data_nascimento, $dia_natalicio_options);

$descricao_itens_docx_options = get_field('descricao_itens_docx', 'option');
$letra_inicio_nome_option = get_field('letra_inicial_nome', 'option');
$letra_inicio_nome = getLetraNome($nome_completo, $letra_inicio_nome_option);
$letra_inicio_nome = $letra_inicio_nome[0];
$descricao_itens_docx_options = get_field('descricao_docx', 'option');
$numero_anjo = $anjo['numero'];

//tratamento para o frontend
$licao_carmica = [];
foreach ($licoes_carmicas as $numero_licao) {
    foreach ($licoes_carmicas_options as $licao) {
        if ($licao['numero_licao_carmica'] == $numero_licao) {
            $licao_carmica[] = $licao; // Adiciona todas as lições cármicas encontradas
        }
    }
}

$divida_carmica = [];
foreach ($dividas_carmicas as $numero_divida) {
    foreach ($dividas_carmicas_options as $divida) {
        if ($divida['numero_divida_carmica'] == $numero_divida) {
            $divida_carmica[] = $divida;
        }
    }
}

//numero_tendencia_oculta e texto_tendencia_oculta
$resultado_tendencias = array_filter($tendencias_ocultas_options, function ($item) use ($tendencias_ocultas) {
    return in_array($item["numero_tendencia_oculta"], $tendencias_ocultas);
});
$resultado_numeros_harmonicos = array_filter($numeros_harmonicos_options, function ($item) use ($numeros_harmonicos) {
    return in_array($item["numero_numeros_harmonicos"], $numeros_harmonicos);
});

$resultado_desafios = [];

foreach ($desafios as $key => $numero) {
    foreach ($numeros_desafios_options as $item) {
        if ($item['numero_do_desafio'] == $numero) {
            $resultado_desafios[] = $item;
        }
    }
}

$resultado_talento = [];
foreach ($talento_oculto_options as $talento) {
    if($talento['numero_talento_oculto'] == $talento_oculto){
        $resultado_talento = $talento;
    }
}

$resultado_numero_psiquico = [];
foreach ($numeros_psiquicos_options as $numero) {
    if($numero['numero_psiquico'] == $numero_psiquico){
        $resultado_numero_psiquico = $numero;
    }
}
$resultado_resposta_subconsciente = [];
foreach ($resposta_subconsciente_options as $subconciente) {
    if($subconciente['numero_resposta_subconsciente'] == $resposta_subconsciente){
        $resultado_resposta_subconsciente = $subconciente;
    }
}
// funções de tratamento de dados
function transformDate($date)
{
    $dateTime = DateTime::createFromFormat('Ymd', $date);
    return $dateTime ? $dateTime->format('Y-m-d') : 'Invalid date format';
}

function formatBrDate($date)
{
    $dateObj = DateTime::createFromFormat('Y-m-d', $date);
    return $dateObj ? $dateObj->format('d/m/Y') : $date;
}

function convertDate($date)
{
    return str_replace('-', '/', $date);
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

function getUserArcanosCalculusResultContent($arcano_basicavida_options, $arcanoAtual, $arcano_basicavida_content)
{
    foreach ($arcano_basicavida_options as $arcano_basicavida_option):
        if ($arcano_basicavida_option['numero_arcano_basicavida'] == $arcanoAtual):
            $arcano_basicavida_content = array(
                "img" => $arcano_basicavida_option['imagem_arcano'],
                "text" => $arcano_basicavida_option['texto_arcano_basicavida']
            );
            break;
        endif;
    endforeach;

    return $arcano_basicavida_content;
}
function getDiaNatalicio($data_nascimento, $dia_natalicio)
{
    // Obtém o dia do nascimento como um número inteiro
    $diaNascimento = (int)date('d', strtotime($data_nascimento));

    // Procura no array o elemento correspondente ao dia
    foreach ($dia_natalicio as $dia) {
        if ((int)$dia['dia'] === $diaNascimento) {
            return $dia; // Retorna o array do dia correspondente
        }
    }

    // Caso o dia não seja encontrado, retorna null ou uma mensagem padrão
    return null;
}
function getLetraNome($nome_completo, $primeira_letra) {
    // Extrai a primeira letra do nome completo
    $nomeCompleto = trim($nome_completo); // Remove espaços extras no início e no final
    $primeiraLetraNome = (substr($nomeCompleto, 0, 1)); // Extrai a primeira letra e a transforma em minúscula

    $resultadoLetra =[];
    // Verifica se a letra está na string $primeira_letra
    foreach ($primeira_letra as $letra) {
        if ($letra['id_letra'] == $primeiraLetraNome) {
            $resultadoLetra[] = $letra;

            return $resultadoLetra;
        }
    }
    return "Letra não encontrada"; // Retorna a mensagem padrão
}
function getRelacoesIntervalores($relacoes_intervalores, $relacoes)
{
    $resultado = [];
    foreach ($relacoes as $relacao) {
        if ($relacao['numero_relacao_intervalor'] == $relacoes_intervalores) {
            $resultado[] = $relacao;
            return $resultado;
        }
    }
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
/**
 * Função para buscar o texto correspondente ao número do último array
 *
 * @param array $ultimo_array O último array contendo o número.
 * @param array $piramide_options O array de opções com números e textos.
 * @return string|null O texto correspondente ao número ou null se não encontrado.
 */
function buscarTextoPorNumero($ultimo_array, $piramide_options) {
    // Obtendo o número do último array
    $numero_ultimo_array = intval(end($ultimo_array)); // Converte para inteiro

    // Iterando sobre as opções para encontrar o texto correspondente
    foreach ($piramide_options as $opcao) {
        if (intval($opcao['numero_piramide_basicavida']) === $numero_ultimo_array) {
            // Retorna o texto se encontrado
            //return $opcao['texto_piramide_basicavida'];
            return "Base da Pirâmide: {$numero_ultimo_array} - {$opcao['texto_piramide_basicavida']}";
        }
    }

    // Retorna null se nenhum texto for encontrado
    return null;
}

