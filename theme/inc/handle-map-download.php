<?php
include_once get_stylesheet_directory() . '/helpers/docx-download.php';
use PhpOffice\PhpWord\SimpleType\Jc;
function gerar_docx_com_infos()
{
    if (isset($_GET['download_docx'])) {
        // Ativar log de erros para debug (mas silenciar warnings do ACF)
        error_reporting(E_ALL & ~E_NOTICE & ~E_USER_NOTICE);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);

        // Suprimir warnings específicos do ACF sobre tradução
        add_filter('doing_it_wrong_trigger_error', function ($trigger, $function) {
            if ($function === '_load_textdomain_just_in_time' && strpos(debug_backtrace()[3]['file'] ?? '', 'acf') !== false) {
                return false;
            }
            return $trigger;
        }, 10, 2);

        // Garantir que estamos no contexto correto do post
        if (isset($_GET['post_id'])) {
            $post_id = intval($_GET['post_id']);
            global $post;
            $post = get_post($post_id);

            if (!$post) {
                wp_die('Post não encontrado. ID: ' . $post_id);
            }

            setup_postdata($post);
            error_log('Contexto do post configurado para ID: ' . $post_id . ' | Título: ' . get_the_title());
        } else {
            error_log('AVISO: post_id não foi passado na URL do download');
        }

        try {
            require_once get_template_directory() . '/inc/template-single-mapa-functions.php';

            // Verificar se as variáveis essenciais foram definidas
            if (!isset($nome_completo) || !isset($data_nascimento)) {
                throw new Exception('Dados essenciais não encontrados. Nome: ' . (isset($nome_completo) ? 'OK' : 'FALTA') . ', Data: ' . (isset($data_nascimento) ? 'OK' : 'FALTA'));
            }

            $phpWord = start_php_word_docx();
            $section = $phpWord->addSection();
            add_basic_info_section($section, $nome_completo, $data_nascimento); // Adiciona informações básicas
            // Resultados de cálculos Motivação, Impressão, Expressão
            add_calculations_section($section, $numero_motivacao, $numero_impressao, $numero_expressao, $numero_psiquico, $talento_oculto, $numero_destino, $numero_missao, $resposta_subconsciente, $relacoes_intervalores);
            // Dia natalício
            add_dia_nascimento_section($section, $dia_natalicio);
            // Resultado do Calculo Lições Carmicas, Dívidas Cármicas, tendencias ocultas
            add_karmic_number($section, $licoes_carmicas, $dividas_carmicas, $tendencias_ocultas);
            // Momentos Decisivos
            add_momentos_decisivos($section, $momento_decisivo_numero);
            // Ciclos da Vida
            add_life_cycles_section($section, $ciclos);
            // Desafios
            add_challenges_section($section, $desafios);
            // Hamonia conjugal
            add_marital_harmony($section, $harmonia);
            // Texto ano, mes e ano
            add_personal_dado_section($section, $ano_pessoal, $mes_pessoal, $dia_pessoal);
            // Texto grau_ascensão
            add_personal_section_grau($section, $grau_ascensao);
            // Anjo
            add_ange_num_section($section, $anjo);
            // Arcano Atual
            add_arcano_section($section, $arcanoAtual, $arcano_basicavida_options);
            // QUEM VOCÊ É?
            add_conteudo_quem_section($section);
            // texto motivacao, impressao, expressão, psiquico, desafio, resposta subconciente, relacao intervalor, missao, talento oculto
            add_calculations_text_quem_section($section, $numero_motivacao, $motivacao_content, $numero_impressao, $numero_expressao, $impressao_content, $expressao_content, $numero_psiquico, $psiquico_content, $talento_oculto, $talento_content);
            // Dia natalício
            add_dia_natalicio_section($section, $dia_natalicio);
            // Letra inicial do Nome
            add_inicial_name_section($section, $letra_inicio_nome);
            // PARA ONDE VOCÊ QUER IR?
            add_conteudo_onde_ir_section($section);
            add_text_destino_missao_section($section, $numero_destino, $destino_content, $numero_missao, $missao_content);
            // Vocacional
            add_vocational_section($section, $vocacional);
            // Texto Ciclo de Vida
            add_life_cycles_content_section($section);
            add_life_cycles_text_section($section, $ciclos_textos_filtrados);
            // Momentos Decisivos
            add_moment_section($section, $textos_momentos, $momentos_decisivos);
            // Ano, Mes e Dia pessoal
            add_personal_section($section, $ano_pessoal_content, $mes_pessoal_content, $dia_pessoal_content);
            // anjo dado
            add_angel_section($section, $anjo, $anjo_options);

            // LIÇÕES E APRENDIZADOS (texto lições carmicas, dividas carmicas, tendencias ocultas, resposta subconciente, desafios)
            add_karmic_lessons_debts_section($section, $licoes_carmicas, $licao_carmica, $dividas_carmicas, $divida_carmica);
            // Tendências Ocultas
            add_hidden_tendencies_section($section, $tendencias_ocultas, $resultado_tendencias);
            // Resposta subconciente
            add_resposta_sub_section($section, $resposta_subconsciente, $resposta_subconsciente_content);
            //desafios
            add_challenges_text_section($section, $resultado_desafios);
            // QUALIDADE DE VIDA TEXTO
            add_qualidade_vida_section($section);
            //Dados Cores, das favoraveis, numeros hamonicos
            add_energies_life_cycles_section($section, $cores, $dias_favoraveis, $resultado_numeros_harmonicos);
            // Harmonia Conjugal
            add_marital_harmony_section($section, $harmonia, $vibra_com, $atrai, $e_oposto, $e_passivo_em_relacao_a, $texto_hamononia_conjugal, $texto_vibra_com);

            // Análise de Assinatura
            add_signature_analysis_section($section, $letras_nome, $vogais, $consoantes); // Análise de Assinatura
            //ANÁLISE DO NOME: Triangulo de Vida e Sequências Negativas
            add_content_pyramid_section($section);
            // Pirâmide vida
            add_pyramid_sequence_section($section, 'Vida', $nome_completo, $piramide_vida, $sequencias_vida);
            // sequencia negativas vida
            add_sequence_section($section, $sequencias_negativas_options, $sequencias_vida, $texto_piramide_vida);
            // sequencias positivas da vida
            add_sequence_positive_section($section, $sequencias_positivas_options, $sequencias_vida, $texto_piramide_vida);
            // titulo parte arcanos, inserir texto descritivo
            add_arcano_significado_section($section);
            // Arcanos vida - retorna array '
            add_arcanos_section($section, 'Arcanos da Vida', $arcanos ?? [], $arcano_basicavida_options);
            // piramide pessoal
            add_pyramid_sequence_section($section, 'Pessoal', $nome_completo, $piramide_pessoal, $sequencias_pessoal);
            // sequencia  negativas pessoal
            add_sequence_section($section, $sequencias_negativas_options, $sequencias_pessoal, $texto_piramide_pessoal);
            // sequencias positivas da vida
            add_sequence_positive_section($section, $sequencias_positivas_options, $sequencias_pessoal, $texto_piramide_pessoal);
            // titulo parte arcanos, inserir texto descritivo

            // Arcano Pessoal - retorna array direto, sem chave 'arcanos'
            add_arcanos_section($section, 'Arcanos Pessoais', is_array($arcanos_pessoais) ? $arcanos_pessoais : [], $arcano_basicavida_options);

            // piramide social
            add_pyramid_sequence_section($section, 'Social', $nome_completo, $piramide_social, $sequencias_social);
            // sequencia negativas social
            add_sequence_section($section, $sequencias_negativas_options, $sequencias_social, $texto_piramide_social);
            // sequencias positivas da Sociais
            add_sequence_positive_section($section, $sequencias_positivas_options, $sequencias_social, $texto_piramide_social);
            // titulo parte arcanos, inserir texto descritivo

            // arcano social - retorna array direto, sem chave 'arcanos'
            add_arcanos_section($section, 'Arcanos Sociais', is_array($arcanos_sociais) ? $arcanos_sociais : [], $arcano_basicavida_options);

            // piramide Destino
            add_pyramid_sequence_section($section, 'Destino', $nome_completo, $piramide_destino, $sequencias_destino);
            // Sequencia negativas Destino
            add_sequence_section($section, $sequencias_negativas_options, $sequencias_destino, $texto_piramide_destino);
            // sequencias positivas da Sociais
            add_sequence_positive_section($section, $sequencias_positivas_options, $sequencias_destino, $texto_piramide_destino);
            // titulo parte arcanos, inserir texto descritivo

            // arcano Destino - retorna array direto, sem chave 'arcanos'
            add_arcanos_section($section, 'Arcanos Destino', is_array($arcanos_destino) ? $arcanos_destino : [], $arcano_basicavida_options);
            // Envia o documento gerado
            send_php_word_docx($phpWord, 'analise_mapa');

            // Resetar contexto do post
            wp_reset_postdata();

        } catch (Exception $e) {
            // Resetar contexto do post em caso de erro
            wp_reset_postdata();

            // Log do erro
            error_log('ERRO ao gerar mapa DOCX: ' . $e->getMessage());
            error_log('Trace: ' . $e->getTraceAsString());

            // Mensagem amigável para o usuário
            wp_die(
                '<h1>Erro ao gerar o mapa</h1>' .
                '<p>Ocorreu um erro ao processar seu mapa numerológico. Por favor, tente novamente.</p>' .
                '<p>Se o erro persistir, entre em contato com o suporte.</p>' .
                '<p><strong>Detalhes técnicos:</strong> ' . esc_html($e->getMessage()) . '</p>' .
                '<p><a href="javascript:history.back()">← Voltar</a></p>',
                'Erro no Download',
                ['response' => 500]
            );
        }
    }
}

// Funções auxiliares
function add_basic_info_section($section, $nome_completo, $data_nascimento)
{
    $titleStyle = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle = ['name' => 'Arial', 'size' => 12, 'color' => '333333'];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $heading2Style = ['name' => 'Arial', 'size' => 22, 'bold' => true, 'color' => '000000'];
    $heading2StyleJustify = ['alignment' => Jc::CENTER];

    $section->addText("Bem vindo (a) ao seu Mapa Numerológico Completo", $heading2Style, $heading2StyleJustify);
    $section->addTextBreak(2);
    // Convertendo a data para o formato dd/mm/yyyy dentro da função
    if ($data_nascimento && $data_nascimento !== "0000-00-00") {
        $data_nascimento_formatada = date("d/m/Y", strtotime($data_nascimento));
    } else {
        $data_nascimento_formatada = "Data Inválida";
    }

    $section->addText($nome_completo, $titleStyle);
    //$section->addTextBreak(1);
    $section->addText("Nascido(a) em " . $data_nascimento_formatada, $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
}

function add_signature_analysis_section($section, $letras_nome, $vogais, $consoantes)
{
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $heading2Style = ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '000000']; // formatação do titulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];

    $section->addPageBreak();
    $section->addText("Análise de Assinatura", $heading2Style, $heading2StyleJustify);
    $section->addTextBreak(1);
    $section->addText("A Análise de Assinatura na Numerologia Cabalística é uma prática que busca harmonizar a energia pessoal com os objetivos de vida, utilizando o nome escrito de forma consciente para potencializar vibrações positivas. A assinatura representa a identidade energética da pessoa no mundo material e pode influenciar diretamente o sucesso, a comunicação, os relacionamentos e a realização de metas.", $paragraphStyle3, $paragraphStyleJustify);
    $section->addTextBreak(1);

    $table = $section->addTable();
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];

    $table->addRow();
    foreach ($letras_nome as $letra) {
        $table->addCell()->addText($vogais[$letra] ?? ' ', 'ParagraphStyle', $paragraphStyleJustify);
    }

    $table->addRow();
    foreach ($letras_nome as $letra) {
        $table->addCell()->addText($letra, 'ParagraphStyle', $paragraphStyleJustify);
    }

    $table->addRow();
    foreach ($letras_nome as $letra) {
        $table->addCell()->addText($consoantes[$letra] ?? ' ', 'ParagraphStyle', $paragraphStyleJustify);
    }

    $section->addTextBreak(2);
}
function add_conteudo_quem_section($section)
{
    $heading2StyleJustify = ['alignment' => Jc::CENTER]; // alinhamento titulo
    $heading2Style = ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '000000']; // formatação do titulo
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    //$paragraphStyleJustify = ['alignment' => Jc::BOTH]; // alinhamento do texto descrição
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240, 'lineHeight' => '1.2em']; // alinhamento dos textos
    //$section->addPageBreak();
    $section->addText("Quem é você?", $heading2Style, $heading2StyleJustify);
    $section->addTextBreak(1);
    $section->addText("Os números relacionados a Motivação, Expressão,Impressão, Talento Oculto e Número Psíquico, Dia de Nascimento, descrevem a personalidade com
seu temperamento, os dons, os talentos e as aptidões pessoais e profissionais. Mostra quem é você.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addTextBreak(1);
}
function add_calculations_text_quem_section($section, $numero_motivacao, $motivacao_content, $numero_impressao, $numero_expressao, $impressao_content, $expressao_content, $numero_psiquico, $psiquico_content, $talento_oculto, $talento_content)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240, 'lineHeight' => '1.2em']; // alinhamento dos textos
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação do subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados do ACF e dos Funções do Sistema


    $section->addTextBreak(1);
    $section->addText("Motivação", $paragraphStyle2);
    $section->addText("Descreve os motivos que estão por trás das decisões que uma pessoa toma e do seu modo de proceder. É o número que corresponde á ação e a maneira que essa ação é desenvolvida.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de motivação - $numero_motivacao: $motivacao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addTextBreak(1);
    $section->addText("Impressão ou 'Aparência'", $paragraphStyle2);
    $section->addText("É o número que descreve o que está oculto no ser humano e a imagem que uma pessoa tem de si mesma (geralmente sem perceber). Revela, ainda, a primeira impressão que os outros têm de nós, antes de nos conhecerem na realidade, ou seja, a condenação ou a absolvição antes do julgamento. ", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Impressão - $numero_impressao: $impressao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addTextBreak(1);
    $section->addText("Expressão", $paragraphStyle2);
    $section->addText("Descreve a maneira como um ser humano interage com outro. Ele diz quais são seus verdadeiros talentos e qual a melhor forma de expressá-los. ", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de expressão - $numero_expressao: $expressao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addTextBreak(1);
    $section->addText("Número psíquico", $paragraphStyle2);
    $section->addText("É o número que mostra as qualidades psíquicas que influenciam as pessoas nascidas em determinados dias em comum, mostrando certos padrões interiores comuns entre elas.  Esse número revela as qualidades que influenciam nas escolhas pessoais, como amizades, sexo, casamentos, relacionamentos, profissões, desejos, ambições e até alimentos.  Mostra como nos vemos em nosso interior e como nós lidamos com as forças interiores de nossa personalidade.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número psíquico - $numero_psiquico: $psiquico_content ", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addTextBreak(1);
    $section->addText("Talento Oculto", $paragraphStyle2);
    $section->addText("O número do Talento Oculto revela um dos aspectos da personalidade cuja manifestação se assemelha a um dom inato que desperta como um talento a mais algum daqueles descritos pelo número de Expressão. ", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Talento Oculto - $talento_oculto: $talento_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addTextBreak(1);

}

function add_conteudo_onde_ir_section($section)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $heading2Style = ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '000000'];
    //$paragraphStyleJustify = ['alignment' => Jc::BOTH];

    $section->addText("Para Onde Você quer ir?", $heading2Style, $heading2StyleJustify);
    $section->addTextBreak(1);
    $section->addText("Os números relacionados a Destino, Missão, Potencialidades Vocacionais, Ciclo de Vida, Momento Decisivo, Ano Pessoal, Mês Pessoal e Dia Pessoal, revelam a sua destinação na vida, com as influências, suas circunstâncias e as suas oportunidades. Mostra qual seu propósito de vida e o que você está destinado a construir.", $paragraphStyle, $paragraphStyleWithSpacing);
}
function add_text_destino_missao_section($section, $numero_destino, $destino_content, $numero_missao, $missao_content)
{

    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação do subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados

    $section->addText("Destino", $paragraphStyle2);
    $section->addText("Este é um dos números mais importantes do Mapa Numerológico. Ele descreve as influências na personalidade, oportunidades e os obstáculos que uma pessoa irá encontrar ao longo da sua vida. Indica, ainda, as alternativas disponíveis e o provável resultado de cada uma delas. ", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Destino - $numero_destino: $destino_content ", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addText("Missão", $paragraphStyle2);
    $section->addText("A Numerologia Cabalística dá grande importância a este número, sendo considerado mesmo de alta 'importância', pois reflete, na essência, o que a pessoa veio fazer neste planeta, nesta existência. É fundamental e muito importante esclarecer que toda e qualquer pessoa tem 'livre-arbítrio' e pode fazer o que bem entender com a sua vida. Porém, também é importante saber que os números obedecem a uma ordem rigorosa de harmonia, compatibilidade, neutralidade e incompatibilidade que, se não respeitada, pode causar ao seu portador inúmeros aborrecimentos ou mesmo derrocadas na vida. ", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Lembre-se de que a Numerologia Cabalística existe para facilitar a vida das pessoas e não para complicá-la.  Todos nós temos uma 'Missão' sobre a Terra, nesta e em outras existências. (Deus jamais desejou que qualquer um de seus filhos viesse a sofrer; e, se tal fato acontece, a culpa é exclusiva do ser humano). Logo, este item é de grande utilidade, pois a sua essência mostra como podemos tirar o melhor proveito da vida, sem que, com isso, prejudiquemos qualquer outro ser humano.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Missão - $numero_missao: $missao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
}

function add_vocational_section($section, $vocacional)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados

    $section->addText("Aptidões e Potencialidades Vocacional", $paragraphStyle2);
    $section->addText("Revelam quais são as atividades profissionais mais favoráveis a você de acordo com os seus talentos e seus dons.", $paragraphStyle, $paragraphStyleWithSpacing);

    // Limita a quantidade de elementos a 15
    $vocacionalLimitado = array_slice($vocacional, 0, 15, true);

    // Itera sobre o array de vocações
    foreach ($vocacionalLimitado as $vocacao) {
        // Divide a string para separar a profissão e os outros dados
        $parts = explode(" - ", $vocacao);

        // Extraímos o nome da profissão, que é a primeira parte
        $profissao = explode(" x ", $parts[0])[0];

        // Agora, extraímos as fontes a partir da segunda parte da string
        $fontes = isset($parts[1]) ? $parts[1] : '';

        // Adiciona as informações ao documento
        $section->addText("$profissao: $fontes", $paragraphStyle3, $paragraphStyleWithSpacing);
    }
}

function add_moment_section($section, $textos_momentos, $momentos_decisivos)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número
    $paragraphStyle4 = ['name' => 'Arial', 'size' => 10, 'color' => 'D2122E', 'italic' => true]; //formatação da descrição
    //$paragraphStyleJustify = ['alignment' => Jc::BOTH];



    $section->addText("Momentos Decisivos", $paragraphStyle2);
    $section->addText("Revelam eventos que podem acontecer em eterminados períodos da sua vida, indicando quais serão as melhores atitudes a serem tomadas em cada uma dessas situações. Porém, lembre-se de que o que for dito sobre um certo momento irá servir apenas para o período em questão.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("ATENÇÃO: Verifique se tem alguma relação dos números abaixo com o seu Momento Decisivo. Motivação: 1 - Expressão: 11 - Destino: 11 - Lições Cármicas: 9", $paragraphStyle4, $paragraphStyleWithSpacing);
    $section->addTextBreak(2);
    // Itera sobre os momentos decisivos e adiciona o número e texto correspondentes
    $count = 0;
    foreach ($textos_momentos as $momento) {
        $numero = $momento['numero_momento_decisivo'];
        $texto = $momento['texto_momento_decisivo'];
        $count++;
        if ($count == 1) {
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("O Primeiro Momento Decisivo retrata o início da nossa vida, onde nos encontramos mais vulneráveis às influências alheias.", $paragraphStyle, $paragraphStyleWithSpacing);
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        } elseif ($count == 2) {
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("O Segundo Momento Decisivo retrata uma etapa onde a maior parte do seu tempo é ocupada pelas responsabilidades familiares e profissionais. Quando um Momento Decisivo e uma Lição Cármica possuem o mesmo número, o período em questão pode decorrer de forma conturbada até que você aprenda essa Lição Cármica..", $paragraphStyle, $paragraphStyleWithSpacing);
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        } elseif ($count == 3) {
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("O Terceiro Momento Decisivo retrata uma etapa onde, na maior parte das vezes, você alcançará uma posição com maior estabilidade.", $paragraphStyle, $paragraphStyleWithSpacing);
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        } elseif ($count == 4) {
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("O Quarto Momento Decisivo carrega com ele as recompensas que você merece, como a serenidade, a sabedoria e a consciência universal.", $paragraphStyle, $paragraphStyleWithSpacing);
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        } else {
            echo "Erro";
        }
    }
    $section->addTextBreak(1);

    //    // Adiciona os períodos de cada momento decisivo
//    for ($i = 1; $i <= 4; $i++) {
//        $momentoKey = "momentoInicial" . $i;
//        $momentoFinalKey = "momentoFinal" . $i;
//        $momentoNumeroKey = "primeiroMomento";
//        if ($i > 1) {
//            $momentoNumeroKey = "{$i}Momento";
//        }
//
//        if (isset($momentos_decisivos[$momentoKey]) && isset($momentos_decisivos[$momentoFinalKey])) {
//            $momentoNumero = $momentos_decisivos[$momentoNumeroKey];
//            $momentoInicial = $momentos_decisivos[$momentoKey];
//            $momentoFinal = $momentos_decisivos[$momentoFinalKey];
//
//            $section->addText("Momento $i - $momentoInicial até $momentoFinal", $paragraphStyleNumber);
//        }
//    }
}
function add_resposta_sub_section($section, $resposta_subconsciente, $resposta_subconsciente_content)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da desscrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; //formatação do subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados


    $section->addText("Resposta Subconsciente", $paragraphStyle2);
    $section->addText("Esse número mostra como será sua reação instintiva e automática em uma situação de emergência. ", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Resposta Subconsciente - $resposta_subconsciente: $resposta_subconsciente_content", $paragraphStyle3, $paragraphStyleWithSpacing);
}
//function add_calculations_section($section, $numero_motivacao, $numero_impressao, $numero_expressao, $numero_psiquico, $talento_oculto, $numero_destino, $numero_missao, $resposta_subconsciente, $relacoes_intervalores) {
//    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000']; // formatação dos dados
//
//    $section->addText("Estes são os seus números...", $paragraphStyle3);
//    $section->addText("Motivação - $numero_motivacao", $paragraphStyle3);
//    $section->addText("Impressão - $numero_impressao", $paragraphStyle3);
//    $section->addText("Expressão - $numero_expressao", $paragraphStyle3);
//    $section->addText("Número Psiquico - $numero_psiquico", $paragraphStyle3);
//    $section->addText("Talento Oculto - $talento_oculto", $paragraphStyle3);
//    $section->addText("Destino - $numero_destino", $paragraphStyle3);
//    $section->addText("Missão - $numero_missao", $paragraphStyle3);
//    $section->addText("Resposta Subconciente - $resposta_subconsciente", $paragraphStyle3);
//    $section->addText("Relação Intervalores - $relacoes_intervalores", $paragraphStyle3);
//}
function add_calculations_section(
    $section,
    $numero_motivacao,
    $numero_impressao,
    $numero_expressao,
    $numero_psiquico,
    $talento_oculto,
    $numero_destino,
    $numero_missao,
    $resposta_subconsciente,
    $relacoes_intervalores
) {
    // Definição dos estilos de texto
    $textStyle = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $boldTextStyle = ['bold' => true, 'name' => 'Arial', 'size' => 12, 'color' => '000000'];

    // Adiciona uma introdução ao documento
    $section->addText("🔢 Estes são os seus números:", $boldTextStyle);

    // Adiciona cada número formatado ao documento
    $section->addText("Motivação: $numero_motivacao", $textStyle);
    $section->addText("Impressão: $numero_impressao", $textStyle);
    $section->addText("Expressão: $numero_expressao", $textStyle);
    $section->addText("Número Psíquico: $numero_psiquico", $textStyle);
    $section->addText("Talento Oculto: $talento_oculto", $textStyle);
    $section->addText("Destino: $numero_destino", $textStyle);
    $section->addText("Missão: $numero_missao", $textStyle);
    $section->addText("Resposta Subconsciente: $resposta_subconsciente", $textStyle);
    $section->addText("Relação Intervalores: $relacoes_intervalores", $textStyle);
}


function add_arcano_significado_section($section)
{
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da desscrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];



    $section->addText("Significado dos Arcanos do seu Nome ", 'Heading2Style', $heading2StyleJustify);
    $section->addText("Os Arcanos são vibrações que nós carregamos ao longo da vida e não podem ser
anulados, porém, a Numerologia Cabalística ensina que ao deixarmos de assinar o
nosso nome de batismo completo, nós passamos a atrair essas vibrações com menor
intensidade.O seu nome de batismo carrega os seguintes Arcanos", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
}
function add_arcano_section($section, $arcanos, $arcano_options)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número

    $dados = '';
    foreach ($arcano_options as $arcano) {
        if ($arcano['numero_arcano_basicavida'] == $arcanos['arcano']) {
            $dados = $arcano;
            break;
        }
    }
    if (!empty($dados)) {
        $section->addText("Arcano Atual:" . $dados['numero_arcano_basicavida'], $paragraphStyle3, $paragraphStyleWithSpacing);

        // Validar e adicionar imagem apenas se existir e for válida
        if (!empty($dados['imagem_arcano'])) {
            $image_path = $dados['imagem_arcano'];

            // Se for um array ACF, extrair URL
            if (is_array($image_path)) {
                $image_path = $image_path['url'] ?? $image_path['path'] ?? '';
            }

            // Validar se o arquivo existe
            if (!empty($image_path)) {
                // Se for URL, tentar converter para caminho do servidor
                if (filter_var($image_path, FILTER_VALIDATE_URL)) {
                    $upload_dir = wp_upload_dir();
                    $image_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_path);
                }

                // Adicionar imagem apenas se o arquivo existir
                if (file_exists($image_path) && is_readable($image_path)) {
                    try {
                        $section->addImage($image_path, ['width' => 150, 'height' => 225]);
                    } catch (Exception $e) {
                        error_log('Erro ao adicionar imagem do arcano: ' . $e->getMessage());
                        $section->addText('[Imagem do arcano não disponível]', $paragraphStyle);
                    }
                }
            }
        }

        $section->addTextBreak(1);
    }
    $section->addTextBreak(1);
}
function add_arcanos_section($section, $titulo, $arcanos, $arcano_options)
{
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];

    $section->addText("$titulo ", 'Heading2Style');
    $section->addTextBreak(1);

    // Validar se arcanos é um array válido
    if (!is_array($arcanos)) {
        $section->addText("Nenhum arcano disponível para este período.", $paragraphStyle);
        $section->addTextBreak(1);
        return;
    }

    // Contar arcanos válidos antes de processar
    $arcanos_validos = 0;
    foreach ($arcanos as $arcano) {
        if (is_array($arcano) && !empty($arcano['arcano'])) {
            $arcanos_validos++;
        }
    }

    // Se não houver arcanos válidos, mostrar mensagem
    if ($arcanos_validos == 0) {
        $section->addText("Nenhum arcano disponível para este período.", $paragraphStyle);
        $section->addTextBreak(1);
        return;
    }

    // Processar cada arcano
    foreach ($arcanos as $arcano) {
        // Garantir que é um array válido
        if (!is_array($arcano)) {
            continue;
        }

        // Acessar dados de forma segura
        $arcano_name = $arcano['arcano'] ?? null;
        $inicio = $arcano['inicio'] ?? '';
        $fim = $arcano['fim'] ?? '';

        // Pular se não houver número de arcano
        if (empty($arcano_name)) {
            continue;
        }

        // Converter datas
        $inicio_formatted = convertDate($inicio) ?: 'Data não disponível';
        $fim_formatted = convertDate($fim) ?: 'Data não disponível';

        $section->addText("Arcano: $arcano_name (De $inicio_formatted até $fim_formatted)", $paragraphStyle2);

        // Buscar informações do arcano no banco de dados (ACF)
        $dados = null;
        foreach ($arcano_options as $option) {
            if (isset($option['numero_arcano_basicavida']) && $option['numero_arcano_basicavida'] == $arcano_name) {
                $dados = $option;
                break;
            }
        }

        if (!empty($dados) && !empty($dados['texto_arcano_basicavida'])) {
            $section->addText($dados['texto_arcano_basicavida'], $paragraphStyle3, $paragraphStyleJustify);
            $section->addTextBreak(1);
        } else {
            $section->addText("Informações do arcano $arcano_name não encontradas no banco de dados.", $paragraphStyle3);
            $section->addTextBreak(1);
        }
    }

    $section->addTextBreak(1);
}

//function add_pyramid_sequence_section($section, $titulo, $sequencia) {
//    $section->addText("Sequência da Pirâmide $titulo:", 'Heading2Style');
//    foreach ($sequencia as $linha) {
//        $section->addText(trim(preg_replace('/[^\d]/', '', $linha)), 'ParagraphStyle');
//    }
//}

function add_vocational_table_section($section)
{
    $headers = ["Nº de destino", "Nº de Expressão Favorável", "Nº de Expressão Desfavorável", "Números Neutros"];
    $values = [
        ["1", "3, 5 e 9", "6", "1, 2, 4, 7 e 8"],
        ["2", "2, 4, 6 e 7", "5 e 9", "1, 3 e 8"],
        ["3", "1, 5 e 9", "4 e 8", "2, 3, 6 e 7"],
        ["4", "2, 6 e 7", "3 e 5", "1, 4, 8 e 9"],
        ["5", "1 e 3", "2, 4 e 6", "5, 7, 8 e 9"],
        ["6", "2, 4 e 7", "1 e 5", "3, 6, 8 e 9"],
        ["7", "2 e 4", "6 e 9", "1, 3, 5, 7 e 8"],
        ["8", "4", "3 e 7", "1, 2, 5, 6 e 9"],
        ["9", "1 e 3", "5 e 8", "2, 4, 6, 7 e 9"]
    ];

    $table = $section->addTable();
    $table->addRow();
    foreach ($headers as $header) {
        $table->addCell()->addText($header, 'ParagraphStyleBold');
    }

    foreach ($values as $value) {
        $table->addRow();
        foreach ($value as $v) {
            $table->addCell()->addText($v, 'ParagraphStyle');
        }
    }
}

function add_qualidade_vida_section($section)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //formatação da descrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $heading2Style = ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '000000'];



    $section->addTextBreak(1);
    $section->addText("Qualidade de Vida", $heading2Style, $heading2StyleJustify);
    $section->addTextBreak(1);
    $section->addText("Os números relacionados a Dias do Mês Favoráveis, Números Harmônicos, Relacionamentos/Harmonia Conjugal, e Cores que melhor se harmonizam com seu Dia de Nascimento. Mostra o apoio para a compreensão e as transformações necessárias, para o seu crescimento e prosperidade pessoal.", $paragraphStyle, $paragraphStyleWithSpacing, $paragraphStyleJustify);
    $section->addTextBreak(1);
}
function add_energies_life_cycles_section($section, $cores, $dias_favoraveis, $numeros_harmonicos)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número

    // dias favoraveis
    $section->addText("Dias Favoráveis ", $paragraphStyle2);
    $section->addTextBreak(1);
    $section->addText("São considerados os seus “dias da sorte”, sendo favoráveis para realizar coisas importantes. Porém, é importante checar se o mês e o ano pessoal também se encontram favoráveis à determinadas situações.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);

    if (is_array($dias_favoraveis)) {
        $section->addText(join(", ", $dias_favoraveis), $paragraphStyle3);
    } else {
        $section->addText($dias_favoraveis, $paragraphStyle3);
    }
    // numeros harmonicos
    $section->addTextBreak(1);
    $section->addText("Números Harmônicos ", $paragraphStyle2);
    $section->addText("Revelam quais são os números que você possui harmonia, sendo bastante uteis para verificar contas bancárias, sociedades, números de telefone, etc. .", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    // Verifica se $numeros_harmonicos é um array
    if (is_array($numeros_harmonicos)) {
        foreach ($numeros_harmonicos as $harmonico) {
            if (isset($harmonico['numero_numeros_harmonicos']) && isset($harmonico['texto_numeros_harmonicos'])) {
                // Adiciona o número com estilo específico
                $section->addText("Numero Harmônico " . $harmonico['numero_numeros_harmonicos'], $paragraphStyleNumber);
                // Adiciona o texto com o estilo apropriado
                $section->addText($harmonico['texto_numeros_harmonicos'], $paragraphStyle3, $paragraphStyleJustify);
                // Adiciona uma quebra de linha
                $section->addTextBreak(1);
            }
        }
    } else {
        $section->addText("Nenhum número harmônico disponível.", $paragraphStyle3);
    }
    $section->addTextBreak(1);
    //cores favoraveis
    $section->addText("Cores Favoráveis", $paragraphStyle2);
    $section->addText("São consideradas as suas “cores da sorte”, as quais, ao ser utilizadas durante os seus dias favoráveis, irão intensificar o seu poder de atração positiva.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    if (is_array($cores)) {
        $section->addText(implode(', ', $cores), $paragraphStyle3);
    } else {
        $section->addText($cores, $paragraphStyle3);
    }
    $section->addTextBreak(1);

}
function add_marital_harmony_section($section, $harmonia, $vibra_com, $atrai, $e_oposto, $e_passivo_em_relacao_a, $texto_hamononia_conjugal, $texto_vibra_com)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número
    $paragraphStyle4 = ['name' => 'Arial', 'size' => 10, 'color' => '054f77', 'italic' => true]; //formatação atenção


    $section->addText("Relacionamentos - Harmonia Conjugal", $paragraphStyle2);
    $section->addText("Revela como você interage com cada vibração, permitindo que você saiba distinguir paixões passageiras do verdadeiro amor. ", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText("Harmonia Conjugal: $harmonia", $paragraphStyleNumber);
    $section->addText("Representa a forma como uma pessoa se comporta dentro de um relacionamento amoroso, incluindo sua maneira de amar, suas necessidades afetivas, expectativas emocionais e o tipo de parceria que tende a buscar ou atrair.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText($texto_hamononia_conjugal, $paragraphStyle3, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText("O seu Número $harmonia Vibra com $vibra_com", $paragraphStyleNumber);
    $section->addText("Os números que vibram em conjunto emitem uma forte paixão e atração sexual,
porém podem passar por conflitos frequentes e enfrentar términos em
decorrência do ciúme exagerado, da arrogância ou da inconstância sexual. Além
disso, corre-se o risco dessa paixão não ser transformada em amor com o passar
do tempo.", $paragraphStyle, $paragraphStyleJustify);
    // adicionar texto de vibração matrimonial de ACF
    $section->addTextBreak(1);
    $section->addText($texto_vibra_com, $paragraphStyle3, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText("Atrai: $atrai", $paragraphStyleNumber);
    $section->addText("É oposto a: $e_oposto", $paragraphStyleNumber);
    $section->addText("É passivo em relação a: $e_passivo_em_relacao_a", $paragraphStyleNumber);
    $section->addTextBreak(1);
    $section->addText("OBSERVAÇÃO: Quando duas pessoas compartilham o mesmo número de Harmonia Conjugal, elas geralmente reconhecem no outro traços semelhantes aos seus, o que pode criar uma forte empatia e sintonia imediata. Elas compreendem intuitivamente as reações, necessidades e limites um do outro, o que pode gerar uma conexão profunda e verdadeira. No entanto, esse (espelhamento) também pode trazer desafios: se ambos possuem tendências emocionais fortes, por exemplo, podem amplificar os mesmos padrões — como insegurança, possessividade ou necessidade de controle. Por isso, a convivência entre duas pessoas com o mesmo número exige autoconhecimento, maturidade emocional e disposição para o diálogo.", $paragraphStyle4, $paragraphStyleJustify);


}

function add_marital_harmony($section, $harmonia)
{
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // Formatação do número
    $section->addText("Harmonia Conjugal: $harmonia", $paragraphStyleNumber);
}

function add_content_pyramid_section($section)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //formatação da descrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $heading2Style = ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color' => '000000'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '333333', 'italic' => false]; //formatação da descrição

    $section->addTextBreak(1);
    $section->addText("Análise do Nome", $heading2Style, $heading2StyleJustify);
    $section->addTextBreak(1);
    $section->addText("O Nome que você recebeu ao nascer será transformado em Números. Mostra cada uma das Etapas de Vida que viveu, vive e viverá.", $paragraphStyle, $paragraphStyleWithSpacing, $paragraphStyleJustify);
    $section->addText("A Pirâmide da Vida é um verdadeiro compêndio de códigos numéricos formados por
arcanos (números), em combinações diversas que podem revelar tudo o que está
contido no nome de uma pessoa.
Por meio dos trânsitos entre as letras do nome, caracterizados em períodos, vibram
padrões diversos de frequências marcando eventos e prevendo ocorrências que
podem acontecer, ou serem modificados em seu curso, conforme a vontade e a
disciplina de cada um.
Na primeira linha abaixo das letras do nome estão os arcanos que ditam os
principais eventos – Arcanos Dominantes.
Dentro das pirâmides invertidas podem aparecer, ainda, as mais diversas
combinações de números, todas importantes sinalizações de eventuais dificuldades,
obstáculos, desafios ou favorecimentos.
Dentre essas outras combinações numéricas, destacam-se as sequências de três ou
mais números iguais (Sequências Negativas), apontando para situações de
dificuldade em determinadas áreas da vida; são barreiras a serem transpostas.
Cada pessoa tem, no seu nome, as configurações necessárias para atrair os eventos
que ajudarão no fortalecimento da sua personalidade, para o seu crescimento
pessoal e a sua evolução espiritual, conforme são os seus méritos. É importante considerar que a ninguém é dado castigo por ter feito mal as lições no
passado, mas que cada um recebe as melhores oportunidades de aprendizado e
ajustamentos. Por isso, tudo pode ser modificado se não estiver de acordo com o
caminho da autorrealização e da felicidade.", $paragraphStyle3, $paragraphStyleJustify);
    $section->addTextBreak(1);
}
function add_pyramid_sequence_section($section, $titulo, $nome_completo, $piramide, $sequencias_vida)
{
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle5 = ['name' => 'Arial', 'size' => 12, 'color' => '333333'];
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $section->addPageBreak();
    $section->addText("Pirâmide $titulo", $paragraphStyle2);
    $section->addTextBreak(1);
    $section->addText($nome_completo, $paragraphStyle5, $heading2StyleJustify);
    $maxLinha = count($piramide);
    for ($i = 0; $i < $maxLinha; $i++) {
        $espacos = str_repeat(" ", $i * 2);
        $linhaFormatada = preg_replace('/[^0-9]/', '', implode("", $piramide[$i]));

        if (strlen($linhaFormatada) > 0) {
            $textRun = $section->addTextRun(['alignment' => Jc::CENTER]);
            $linhaLength = strlen($linhaFormatada);
            $j = 0;

            while ($j < $linhaLength) {
                $bold = false;

                foreach (array_merge($sequencias_vida['positivas'], $sequencias_vida['negativas']) as $sequencia) {
                    $seqLength = strlen($sequencia);

                    if ($j + $seqLength <= $linhaLength && substr($linhaFormatada, $j, $seqLength) === $sequencia) {
                        $bold = true;
                        $textRun->addText(implode(" ", mb_str_split($sequencia)) . " ", ['name' => 'Arial', 'size' => 10, 'color' => '800080', 'italic' => true, 'bold' => true]);
                        $j += $seqLength;
                        continue 2;
                    }
                }

                $textRun->addText($linhaFormatada[$j] . " ", ['name' => 'Arial', 'size' => 10, 'color' => '3c3c3c', 'alignment' => Jc::CENTER]);
                $j++;
            }
        }
    }
}
// sequencias negativas da piramide
function add_sequence_section($section, $sequencias_negativas_options, $sequencias_vida, $texto_piramide_vida)
{
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //formatação da descrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];

    $section->addText("Sequências Negativas", $paragraphStyle2);
    $section->addText("As Sequências Negativas atraem negatividades e por isso devem ser evitadas, sendo elas: (Adversidades que impedem a realização profissional, afetiva, pessoal e etc.) ou (Doenças físicas). Ao possuir uma Sequência Negativa, a pessoa pode atrair essas negatividades de forma parcial ou total.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    // Adiciona sequências negativas encontradas
    foreach ($sequencias_vida["negativas"] as $negativa) {
        foreach ($sequencias_negativas_options as $option) {
            if ($option["numero_sequencia_negativa"] === $negativa) {
                //$section->addText("" . $option["numero_sequencia_negativa"], $paragraphStyleNumber);
                $section->addText($option["sequencia_negativa"], $paragraphStyle3, $paragraphStyleJustify);
                $section->addTextBreak(1);
            }
        }
    }
}
// sequencias positivas da piramide
function add_sequence_positive_section($section, $sequencias_positivas_options, $sequencias_vida, $texto_piramide_vida)
{
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //formatação da descrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número

    $section->addText("Sequências Positivas", $paragraphStyle2);
    $section->addText("As Sequências positivas representam um fluxo energético ascendente baseado em vibrações numéricas alinhadas ao propósito de evolução espiritual, material e mental. Essa estrutura piramidal segue uma progressão lógica e simbólica, onde cada degrau ou nível corresponde a um número que influencia diretamente o crescimento e as oportunidades de quem trilha esse caminho.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    // Adiciona sequências positivas encontradas
    foreach ($sequencias_vida["positivas"] as $positiva) {
        foreach ($sequencias_positivas_options as $option) {
            if ($option["numero_sequencia_positiva"] === $positiva) {
                //$section->addText("" . $option["numero_sequencia_negativa"], $paragraphStyleNumber);
                $section->addText($option["sequencia_positiva"], $paragraphStyle3, $paragraphStyleJustify);
                $section->addTextBreak(1);
            }
        }
    }
    $section->addTextBreak(1);
    $section->addText("A Pirâmide da Vida do seu nome de batismo é regido pelo Arcano:", $paragraphStyleNumber);
    $section->addText("Arcano " . $texto_piramide_vida, $paragraphStyle3);
    $section->addTextBreak(2);
}

//function add_pyramid_sequence_section($section, $titulo, $piramide)
//{
//    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
//    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic'=> true]; //formatação da descrição
//    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
//
//
//    $section->addText("Pirâmide da $titulo", $paragraphStyle2);
//    $section->addText("Revela as vibrações positivas e negativas contido no nome de uma pessoa, através de códigos numéricos combinados com arcanos do tarô.", $paragraphStyle, $paragraphStyleJustify);
//
//    $section->addTextBreak(1);
//
//    $maxLinha = count($piramide);
//    for ($i = 0; $i < $maxLinha; $i++) {
//        $espacos = str_repeat(" ", $i * 2); // Ajusta o espaçamento para melhor formatação
//        $linhaFormatada = preg_replace('/[^0-9]/', '', implode("", $piramide[$i])); // Remove caracteres não numéricos e junta os elementos
//        $linhaEspacada = implode(" ", mb_str_split($linhaFormatada)); // Adiciona espaçamento entre os números
//
//        if (strlen($linhaFormatada) > 0) { // Evita adicionar linhas vazias
//            // Alinha à esquerda apenas no TextRun
//            $textRun = $section->addTextRun();
//            $textRun->addText(
//                $espacos . $linhaEspacada,
//                ['name' => 'Arial', 'size' => 10, 'color' => '800080', 'italic' => true], // Roxo
//                ['alignment' => Jc::BOTH] // Justifica o texto dentro da caixa
//                //['alignment' => Jc::CENTER]
//
//            );
//        }
//    }
//}

//função add texto ciclos de vida em Download
function add_life_cycles_content_section($section)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle4 = ['name' => 'Arial', 'size' => 10, 'color' => 'D2122E', 'italic' => true]; //formatação da descrição

    $section->addText("Ciclos da Vida", $paragraphStyle2);
    $section->addText("São os 3 grandes ciclos aos quais você sofrerá influência ao longo da sua vida. Através do seu conhecimento, você poderá tirar o máximo de proveito de cada um deles, uma vez que eles lhe mostrarão as condições e as circunstâncias as quais você será exposto(a).", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("ATENÇÃO: Se um Ciclo de Vida seu tiver o MESMO número que uma das LIÇÕES CÁRMICAS, este será um período difícil até que a 'Lição' seja aprendida.", $paragraphStyle4, $paragraphStyleWithSpacing);
}
function add_life_cycles_text_section($section, $ciclos)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];

    if (!empty($ciclos) && is_array($ciclos)) {
        $dataNascimento = null;

        foreach ($ciclos as $index => $dados_ciclo) {
            $titulo = $dados_ciclo['ciclo'] ?? 'Ciclo Desconhecido';
            $numero = $dados_ciclo['numero'] ?? '-';
            $periodo = $dados_ciclo['periodo'] ?? 'Período não informado';
            $texto = $dados_ciclo['texto'] ?? '';

            // Normalizar separadores (troca - por / para padronizar)
            $periodo_normalizado = str_replace('-', '/', $periodo);

            // Caso 1: data a data
            if (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{4})\s*a\s*(\d{1,2})\/(\d{1,2})\/(\d{4})/', $periodo_normalizado, $matches)) {
                $inicio = \DateTime::createFromFormat('d/m/Y', "{$matches[1]}/{$matches[2]}/{$matches[3]}");
                $fim = \DateTime::createFromFormat('d/m/Y', "{$matches[4]}/{$matches[5]}/{$matches[6]}");

                if ($inicio && $fim) {
                    if (!$dataNascimento) {
                        $dataNascimento = clone $inicio;
                    }

                    $periodoFormatado = $inicio->format('d/m/Y') . ' - ' . $fim->format('d/m/Y');

                    $idadeInicio = $dataNascimento->diff($inicio);
                    $idadeInicioTexto = "{$idadeInicio->y} anos";
                    if ($idadeInicio->m > 0) {
                        $idadeInicioTexto .= " e {$idadeInicio->m} meses";
                    }

                    $idadeFim = $dataNascimento->diff($fim);
                    $idadeFimTexto = "{$idadeFim->y} anos";
                    if ($idadeFim->m > 0) {
                        $idadeFimTexto .= " e {$idadeFim->m} meses";
                    }

                    $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
                    $section->addText("Período: {$periodoFormatado} - Início {$idadeInicioTexto} e Fim {$idadeFimTexto}", $paragraphStyle);
                    $section->addTextBreak(1);
                    $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
                }
            }
            // Caso 2: data até o fim da vida
            elseif (preg_match('/(\d{1,2})\/(\d{1,2})\/(\d{4})\s*até o fim da vida/', $periodo_normalizado, $matches)) {
                $inicio = \DateTime::createFromFormat('d/m/Y', "{$matches[1]}/{$matches[2]}/{$matches[3]}");

                if ($inicio) {
                    if (!$dataNascimento) {
                        $dataNascimento = clone $inicio;
                    }

                    $periodoFormatado = $inicio->format('d/m/Y') . " até o fim da vida";

                    $idadeInicio = $dataNascimento->diff($inicio);
                    $idadeInicioTexto = "{$idadeInicio->y} anos";
                    if ($idadeInicio->m > 0) {
                        $idadeInicioTexto .= " e {$idadeInicio->m} meses";
                    }

                    $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
                    $section->addText("Período: {$periodoFormatado} - Início {$idadeInicioTexto}", $paragraphStyle);
                    $section->addTextBreak(1);
                    $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
                }
            } else {
                // Se não bater nenhum formato
                $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
                $section->addText("Período: {$periodo}", $paragraphStyle);
                $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
            }

            $section->addText('');
        }
    }
}



//function add_life_cycles_text_section($section, $ciclos)
//{
//    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true, 'bold'=> true];
//    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
//    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000'];
//
//    if (!empty($ciclos) && is_array($ciclos)) {
//        $dataNascimento = null; // Para guardar a data de nascimento (início do primeiro ciclo)
//
//        foreach ($ciclos as $index => $dados_ciclo) {
//            $titulo = $dados_ciclo['ciclo'] ?? 'Ciclo Desconhecido';
//            $numero = $dados_ciclo['numero'] ?? '-';
//            $periodo = $dados_ciclo['periodo'] ?? 'Período não informado';
//            $texto = $dados_ciclo['texto'] ?? '';
//
//            // Extrair datas do período
//            if (preg_match('/(\d{1,2}-\d{1,2}-\d{4})\s*-\s*(\d{1,2}-\d{1,2}-\d{4})/', $periodo, $matches)) {
//                $inicio = \DateTime::createFromFormat('d-m-Y', $matches[1]);
//                $fim = \DateTime::createFromFormat('d-m-Y', $matches[2]);
//
//                if ($inicio && $fim) {
//                    if (!$dataNascimento) {
//                        $dataNascimento = clone $inicio;
//                    }
//
//                    // Calcular idade no final do ciclo
//                    $idade = $dataNascimento->diff($fim);
//                    $idadeTexto = "{$idade->y} anos";
//                    if ($idade->m > 0) {
//                        $idadeTexto .= " e {$idade->m} meses";
//                    }
//
//                    $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
//                    $section->addText("Período: {$periodo} — Idade no fim: {$idadeTexto}", $paragraphStyle);
//                    $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
//                } else {
//                    // Erro no formato de data
//                    $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
//                    $section->addText("Período: {$periodo}", $paragraphStyle);
//                    $section->addText("Formato de data inválido", $paragraphStyle, $paragraphStyleWithSpacing);
//                }
//            } else {
//                // Período fora do formato esperado
//                $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
//                $section->addText("Período: {$periodo}", $paragraphStyle);
//                $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
//            }
//
//            $section->addText('');
//        }
//    }
//}a

function add_life_cycles_section($section, $ciclos)
{
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados

    if (!empty($ciclos)) {
        $ciclos_text = []; // Array para armazenar os números dos ciclos

        foreach ($ciclos['ciclos'] as $dados_ciclo) {
            $ciclos_text[] = $dados_ciclo['numero']; // Adicionar o número ao array
        }

        // Juntar os números em uma única string, separados por vírgula
        $ciclos_concatenados = implode(' , ', $ciclos_text);

        // Adicionar o texto ao documento
        $section->addText("Ciclos de Vida: {$ciclos_concatenados}", $paragraphStyle3);
    }
}
function add_dia_natalicio_section($section, $dia_natalicio)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];



    $section->addText("Dia Natalício", $paragraphStyle2);
    $section->addText("Revela quais são as suas qualidades e os seus dons,
destacando as suas necessidades evolutivas.", $paragraphStyle, $paragraphStyleWithSpacing, $paragraphStyleJustify);
    if (!empty($dia_natalicio)) {
        foreach ($dia_natalicio as $dados_dia) {
            $section->addText($dados_dia, $paragraphStyle3, $paragraphStyleJustify);
        }
    }
    $section->addTextBreak(1);
}
function add_dia_nascimento_section($section, $dia_natalicio)
{
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    if (!empty($dia_natalicio['dia'])) {
        $section->addText("Dia Natalício: " . $dia_natalicio['dia'], $paragraphStyle3, $paragraphStyleJustify);
    }
}
function add_inicial_name_section($section, $letra_inicio_nome)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número


    $section->addText("Letra Inicial do Nome", $paragraphStyle2);
    $section->addText("Diz respeito a suas aptidões, suas reações face a diferentes experiências.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    if (!empty($letra_inicio_nome['descricao_letra'])) {
        $section->addText($letra_inicio_nome['descricao_letra'], $paragraphStyle3, $paragraphStyleJustify);
    }
    // Adiciona um espaçamento entre as seções
    $section->addTextBreak(1);

    // Seção dos desafios da letra
    if (!empty($letra_inicio_nome['desafios_letra'])) {
        $section->addText("Desafios da Letra", $paragraphStyleNumber);
        $section->addText($letra_inicio_nome['desafios_letra'], $paragraphStyle3, $paragraphStyleJustify);
    }
    $section->addTextBreak(2);
}
function add_personal_section_grau($section, $grau_ascensao)
{
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $section->addText("Grau de Ascensão: $grau_ascensao", $paragraphStyle3);
}
function add_personal_dado_section($section, $ano_pessoal, $mes_pessoal, $dia_pessoal)
{
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];

    $section->addText("Ano pessoal - " . $ano_pessoal, $paragraphStyle3);
    $section->addText("Mês pessoal - " . $mes_pessoal, $paragraphStyle3);
    $section->addText("Dia pessoal - " . $dia_pessoal, $paragraphStyle3);
}
function add_personal_section($section, $ano_pessoal_content, $mes_pessoal_content, $dia_pessoal_content)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formação do dado acf
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número
    $paragraphStyle4 = ['name' => 'Arial', 'size' => 10, 'color' => 'D2122E', 'italic' => true]; //formatação atenção


    $section->addText("Dia, Mês e Ano Pessoal", $paragraphStyle2);
    $section->addText("São previsões que irão revelar quais vibrações estarão presentes em cada ano, mês ou dia da sua vida, te guiando ao longo desses períodos.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("AVISO IMPORTANTE: Qualquer número do Ano Pessoal pode se repetir, quando ocorre esta repetição é porque a pessoa deve vivenciar as características deste número de maneira acentuada.", $paragraphStyle4, $paragraphStyleWithSpacing);
    $section->addText("Ano Pessoal", $paragraphStyleNumber);
    $section->addText("O seu Ano Pessoal pode ser visto como uma previsão anual que revela o que acontecerá ao longo desse período e quais são as melhores atitudes que podemos tomar para tirar um bom proveito de cada ciclo anual, descrevendo quais serão os obstáculos, as oportunidades e as influências que nos aguardam. O Ano Pessoal tem início no seu Dia de Nascimento, ou seja, sempre que você faz aniversário um novo Ano Pessoal se inicia.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText($ano_pessoal_content, $paragraphStyle3, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText("Mês Pessoal", $paragraphStyleNumber);
    $section->addText("O Mês Pessoal funciona como uma previsão mensal. Cada Mês Pessoal possui uma vibração específica, portanto, a vibração vigente muda todos os meses. Essas vibrações irão descrever quais serão as influências presentes naquele mês, te dando a oportunidade de tirar o máximo de proveito de todos os meses do ano ao fazer uso das orientações recebidas para tomar suas decisões pessoais.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("AVISO IMPORTANTE: Qualquer número do Mês Pessoal pode se repetir, quando ocorre esta repetição é porque a pessoa deve vivenciar as características deste número de maneira acentuada.", $paragraphStyle4, $paragraphStyleWithSpacing);
    $section->addText($mes_pessoal_content, $paragraphStyle3, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText("Dia Pessoal", $paragraphStyleNumber);
    $section->addText("O Dia Pessoal funciona como uma previsão diária e sua vibração muda diariamente, gerando novas orientações para que você possa fazer bom proveito da vibração vigente a cada novo dia.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("AVISO IMPORTANTE: Qualquer número do Dia Pessoal pode se repetir, quando ocorre esta repetição é porque a pessoa deve vivenciar as características deste número de maneira acentuada. Lembre-se que, o Dia Pessoal possui vibrações diárias, portanto, também precisa ser calculado diariamente para se obter as orientações necessárias, porém, mesmo que os Dias Pessoais tragam com eles as previsões diárias, são os Dias Favoráveis que irão prevalecer em dias importantes, como ao ir reuniões, eventos, assinar contratos e, até mesmo, fazer viagens longas..", $paragraphStyle4, $paragraphStyleWithSpacing);
    $section->addText($dia_pessoal_content, $paragraphStyle3, $paragraphStyleJustify);
    $section->addTextBreak(1);
}
function add_challenges_section($section, $desafios)
{
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados

    // Concatenar os números dos desafios
    $desafios_numeros = implode(' , ', $desafios);
    $section->addText("Desafio: $desafios_numeros", $paragraphStyle3);
}
function add_challenges_text_section($section, $resultado_desafios)
{
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número
    $paragraphStyle4 = ['name' => 'Arial', 'size' => 10, 'color' => 'D2122E', 'italic' => true]; //formatação da descrição

    // Título da seção
    $section->addText("Desafio", $paragraphStyle2);
    $section->addText("Revela as dificuldades e/ou desafios que irão aparecer ao longo da sua vida. Eles deverão ser superados ou servir como aprendizado para realizar reajustes na sua personalidade.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText("AVISO IMPORTANTE: Quando o número de um Desafio for igual ao número de um Ciclo de Vida, de um Momento Decisivo ou do Destino, no mesmo período poderá ocorrer certos distúrbios com a saúde caso o nível de estresse emocional esteja acima do
normal, conforme a lista a seguir:", $paragraphStyle4, $paragraphStyleJustify);
    $section->addText("Número 1 - Coração, cabeça e emocional;", $paragraphStyle, $paragraphStyleJustify);
    $section->addText("Número 2 - Rins, estômago e sistema nervoso;", $paragraphStyle, $paragraphStyleJustify);
    $section->addText("Número 3 - Garganta e fígado;", $paragraphStyle, $paragraphStyleJustify);
    $section->addText("Número 4 - Dentes, ossos e circulação sanguínea;", $paragraphStyle, $paragraphStyleJustify);
    $section->addText("Número 5 - Sistemas reprodutivo e nervoso;", $paragraphStyle, $paragraphStyleJustify);
    $section->addText("Número 6 - Coração e pescoço;", $paragraphStyle, $paragraphStyleJustify);
    $section->addText("Número 7 - Glândulas e sistema nervoso;", $paragraphStyle, $paragraphStyleJustify);
    $section->addText("Número 8 - Estômago e sistema nervoso.", $paragraphStyle, $paragraphStyleJustify);

    $section->addTextBreak(1);

    // Percorre os desafios e adiciona ao documento
    foreach ($resultado_desafios as $desafio) {
        if (isset($desafio['numero_do_desafio']) && isset($desafio['texto_desafio'])) {
            $section->addText("Desafio " . $desafio['numero_do_desafio'], $paragraphStyleNumber);
            $section->addText($desafio['texto_desafio'], $paragraphStyle3, $paragraphStyleJustify);
            $section->addTextBreak(1); // Adiciona um espaço entre os desafios
        }
    }
}

// função retorna apenas dados
function add_momentos_decisivos($section, $momento_decisivo_numero)
{
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados

    if (!empty($momento_decisivo_numero)) {
        $section->addText("Momentos Decisivos: " . join(", ", $momento_decisivo_numero), $paragraphStyle3);
    } else {
        $section->addText("Momentos Decisivos: $momento_decisivo_numero", $paragraphStyle3);
    }
}
function add_ange_num_section($section, $anjo)
{
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados
    if (!empty($anjo)) {
        $section->addText("Anjo: " . $anjo['numero'], $paragraphStyle3);
    }
}

function add_angel_section($section, $anjo, $anjo_options)
{
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados
    $paragraphStyle6 = ['name' => 'Arial', 'size' => 12, 'color' => '333333', 'italic' => true]; // formatação dos dados
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação subtitulo
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];

    $section->addText("Anjo", $paragraphStyle2);
    $section->addText("Os anjos são frequentemente associados a potenciais ocultos e missões de vida baseados nos números de um nome ou data de nascimento. Cada número revela aspectos espirituais e talentos que podem ser influenciados por energias angelicais. ", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);

    if (!empty($anjo)) {
        $section->addText("Número do Anjo: " . $anjo['numero'], $paragraphStyle3);
        foreach ($anjo_options as $anj) {
            if ($anj['numero_anjo'] == $anjo['numero']) {
                // Adiciona o nome do anjo
                $section->addText("Nome do Anjo: " . $anj['nome_anjo'], $paragraphStyle3);
                // Adiciona a categoria do anjo
                $section->addText("Categoria do Anjo: " . $anj['categoria_anjo'], $paragraphStyle3);
                // Adiciona o texto do anjo
                $section->addText("" . $anj['texto_anjo'], $paragraphStyle6, $paragraphStyleJustify);
                $section->addTextBreak();
                // Adiciona o horário de preces do anjo
                $section->addText("Horário de Preces: " . $anj['horario_preces'], $paragraphStyle3);
                // adiciona o dia da prece do anjo
                $section->addText("Dias de preces:" . $anj['dias_preces'], $paragraphStyle3);
                // Adiciona a vela do anjo
                $section->addText("Vela: " . $anj['vela_anjo'], $paragraphStyle3);
                // Adiciona o incenso do anjo
                $section->addText("Incenso: " . $anj['incenso_anjo'], $paragraphStyle3);
                // Adiciona o cristal do anjo
                $section->addText("Cristal: " . $anj['cristal_anjo'], $paragraphStyle3);
                // salmo do anjo
                $section->addText($anj['salmo_anjo'], $paragraphStyle3);
                break; // Encerra o loop após encontrar o anjo correspondente
            }
        }
    } else {
        $section->addText("Anjo não encontrado.", 'ParagraphStyle');
    }
    $section->addTextBreak(2);

}

// função imprimir conteúdo em Download
function add_karmic_lessons_debts_section($section, $licoes_carmicas, $licao_carmica, $dividas_carmicas, $divida_carmica)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];


    $section->addText("Lições e Aprendizados", 'Heading2Style', $heading2StyleJustify);
    $section->addTextBreak(1);
    $section->addText("Os números relacionados a Lições Cármicas, Dívidas Cármicas,
Tendências Ocultas, Resposta Subconsciente e Desafios, mostram os
aprendizados importantes e as dificuldades que precisa superar, bem como
aquilo que deve ajustar. Mostra o que veio aprender para evoluir e o que precisa
equilibrar perante a Lei de Causa e Efeito, em suas relações pessoais, em família
e nos vários ambientes que vier a percorrer nesta vida.", $paragraphStyle, $paragraphStyleWithSpacing, $paragraphStyleJustify);

    //Inserir nova atualização array lições cármicas
    $section->addText("Lições Cármicas ", $paragraphStyle2);
    $section->addText("Revela quais foram as faltas e os erros que você cometeu em encarnações anteriores e precisarão ser corrigidos ao longo dessa vida.", $paragraphStyle, $paragraphStyleWithSpacing, $paragraphStyleJustify);
    $section->addTextBreak(1);

    if (!empty($licoes_carmicas) && !empty($licao_carmica) && is_array($licao_carmica)) {
        foreach ($licao_carmica as $licao) {
            $section->addText("Lição Cármica " . $licao['numero_licao_carmica'], ['bold' => true, 'size' => 12], $paragraphStyleJustify);
            $section->addText($licao['texto_licao_carmica'], $paragraphStyle3, $paragraphStyleJustify);
            $section->addTextBreak(1);
        }
    } else {
        $section->addText("Nenhuma lição cármica encontrada.", 'ParagraphStyle');
    }
    $section->addTextBreak(1);

    $section->addText("Dívidas Cármicas", $paragraphStyle2);
    $section->addText("Revela os crimes ou transgressões que você cometeu
em encarnações anteriores e que irão precisar ser “pagos” ou reajustados ao
longo dessa vida. Esses assuntos devem ter um ponto final e ser “quitados”
para que você não sofra nessa vida por conta de atos perversos ou
criminosos do passado.", $paragraphStyle, $paragraphStyleWithSpacing, $paragraphStyleJustify);

    if (!empty($divida_carmica) && !empty($dividas_carmicas) && is_array($divida_carmica)) {
        foreach ($divida_carmica as $divida) {
            $section->addText("Dívidas Cármicas " . $divida['numero_divida_carmica'], ['bold' => true, 'size' => 12], $paragraphStyleJustify);
            $section->addText($divida['texto_divida_carmica'], $paragraphStyle3, $paragraphStyleJustify);
            $section->addTextBreak(1);
        }
    } else {
        $section->addText("Nenhuma Dívida cármica encontrada.", 'ParagraphStyle');
    }
    $section->addTextBreak(1);
}
// download apenas dos números
function add_karmic_number($section, $licoes_carmicas, $dividas_carmicas, $tendencias_ocultas)
{
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000']; // formatação dos dados

    // Lições Cármicas
    if (!empty($licoes_carmicas)) {
        $licoes_text = implode(' , ', $licoes_carmicas);
        $section->addText("Lições Cármicas: $licoes_text", $paragraphStyle3);
    } else {
        $section->addText("Nenhuma lição cármica encontrada.", $paragraphStyle3);
    }

    // Dívidas Cármicas
    if (!empty($dividas_carmicas)) {
        $dividas_text = implode(' , ', $dividas_carmicas);
        $section->addText("Dívidas Cármicas: $dividas_text", $paragraphStyle3);
    } else {
        $section->addText("Nenhuma dívida cármica encontrada.", $paragraphStyle3);
    }

    // Tendências Ocultas
    if (!empty($tendencias_ocultas)) {
        $tendencias_text = implode(' , ', $tendencias_ocultas);
        $section->addText("Tendências Ocultas: $tendencias_text", $paragraphStyle3);
    } else {
        $section->addText("Nenhuma tendência oculta encontrada.", $paragraphStyle3);
    }

}

// função imprimir conteúdo em Download
function add_hidden_tendencies_section($section, $tendencias_ocultas, $resultado_tendencias)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color' => '000000'];


    $section->addText("Tendências Ocultas", $paragraphStyle2);
    $section->addText("Revela os erros de conduta que você cometeu ou
desejou cometer em encarnações anteriores e que, caso você não saiba lidar
com eles nessa vida, podem te tornar escravo desses desejos. Essas
tendências devem ser evitadas para, dessa forma, quebrar um círculo vicioso
que pode te perseguir nessa e em outras vidas, caso não seja extinguido.", $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
    //$numero = '';
    if (!empty($tendencias_ocultas)) {
        foreach ($tendencias_ocultas as $tendencia_valor) {
            $numero = $tendencia_valor;
            foreach ($resultado_tendencias as $resultado_texto) {
                if ($numero == $resultado_texto['numero_tendencia_oculta']) {
                    $section->addText($resultado_texto['texto_tendencia_oculta'], $paragraphStyle3, $paragraphStyleJustify);
                    $section->addTextBreak(1);
                }
            }
        }
    } else {
        $section->addText("Nenhuma tendência oculta encontrada.", 'ParagraphStyle');
    }
    $section->addTextBreak(1);
}

add_action('template_redirect', 'gerar_docx_com_infos');