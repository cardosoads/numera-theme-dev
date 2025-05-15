<?php
include_once get_template_directory() . '/helpers/docx-download.php';
use PhpOffice\PhpWord\Style\Align;
use PhpOffice\PhpWord\SimpleType\Jc;
function download_empresarial_docx()
{
    if (isset($_GET['download_empresarial_docx'])) {
        require_once get_template_directory() . '/inc/template-single-empresa-functions.php';
        $phpWord = start_php_word_docx();
        // Cria uma nova seção no documento
        $section = $phpWord->addSection();
        //$section->addText(get_the_title(), 'TitleStyle', 'TitleAlign');
        // Adiciona o conteúdo do post
        $section->addText(get_the_content(), 'ParagraphStyle', 'ParagraphAlign');
        // ADICIONAR O CONTEÚDO DO MAPA AQUI
        // Rasão social e data da criação
        add_name_section($section, $razao_social, $data_abertura); // Adiciona informações básicas
        // Área de Atuação
        add_area_atuacao($section, $nome_area);
        // texto motivacao, impressao, expressão
        add_calculations_text_razao($section, $motivacao_razao, $motivacao_razao_content, $expressao_razao, $expressao_razao_content, $impressao_razao, $impressao_razao_content);
        // Missão e Destino
        add_text_destiny_mission_section($section, $destino, $destino_empresarial_content, $missao, $missao_empresarial_content);
        // Dias Favoráveis e Numeros Harmonicos
        add_energies_section($section, $dias_favoraveis, $numeros_harmonicos);
        // Desafios
        add_text_desafios($section, $resultado_desafios_empresarial);
        // ciclos de vida
        add_text_cycles_content_section ($section);
        //add_cycles_text_section($section, $ciclos);
        add_cycles($section, $ciclos_textos_empresa);
        //momentos decisivos
        add_moment($section, $textos_momentos);
        //Nome fantasia
        add_fantasia_section($section, $nome_fantasia); // Adiciona informações básicas
        //texto motivação, impressao, expressao nome fantasia
        add_calculations_text_fantasia($section, $motivacao_fantasia, $motivacao_fantasia_content, $expressao_fantasia, $expressao_fantasia_content, $impressao_fantasia, $impressao_fantasia_content);
        //Data de Alteração

        //
        // envia o documento gerado
        send_php_word_docx($phpWord, 'analise_empresa');
    }
}
function add_name_section($section, $razao_social, $data_abertura) {
    $titleStyle = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $heading2StyleJustify = ['alignment' => Jc::CENTER];
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $heading2Style = ['name' => 'Arial', 'size' => 22, 'bold' => true, 'color'=> '000000'];
    $heading3Style = ['name' => 'Arial', 'size' => 16, 'bold' => true, 'color'=> '000000'];
    $paragraphStyle = ['name' => 'Arial', 'size' => 12, 'color' => '333333'];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];


    $section->addText("Numerologia Cabalística  – Consultoria Empresárial", $heading3Style, $heading2StyleJustify);
    $section->addTextBreak(1);
    $section->addText("Numerologia Empresarial é o estudo para adequar e harmonizar uma empresa ou Negócio aos propósitos dos seus sócios/proprietários/investidores em seus produtos, serviços e ao ramo de atividades.

Ajuda a analisar as compatibilidades dos proprietários, executivos e ocupantes dos vários cargos de gestão, administração e lideranças com as atividades que venham a desempenhar na empresa.
", $paragraphStyle2, $paragraphStyleJustify);
    $section->addTextBreak(1);
    $section->addText("A organização empresarial agrupa pessoas em torno de um ideal, com objetivos definidos pelos seus proprietários; portanto, para que seja bem sucedida e progrida, será necessário que haja harmonia e a mais ampla sintonia entre todos. Por esse motivo é necessário um estudo detalhado dentro da Numerologia Cabalística Empresarial para harmonizar as pessoas em suas equipes, as equipes na empresa e a empresa com os seus propósitos.
 ", $paragraphStyle2, $paragraphStyleJustify);
    $section->addTextBreak(2);
    $section->addText("Bem vindo(a) ao seu Mapa Empresárial",$heading2Style,$heading2StyleJustify );
    $section->addTextBreak(2);
    // Convertendo a data para o formato dd/mm/yyyy dentro da função
    if ($data_abertura && $data_abertura !== "0000-00-00") {
        $data_nascimento_formatada = date("d/m/Y", strtotime($data_abertura));
    } else {
        $data_nascimento_formatada = "Data Inválida";
    }

    $section->addText("Razão Social da Empresa: $razao_social", $titleStyle);
    $section->addText("Data de Abertura " .  $data_nascimento_formatada, $paragraphStyle, $paragraphStyleJustify);
    $section->addTextBreak(1);
}

function add_area_atuacao($section, $nome_area)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240, 'lineHeight' => '1.2em']; // alinhamento dos textos
    $paragraphStyle3 = ['name' => 'Arial', 'bold'=>  true, 'size' => 12, 'color'=> '000000']; // formatação dos dados do ACF e dos Funções do Sistema

    $section->addText("Área de Atuação: $nome_area", $paragraphStyle3, $paragraphStyleWithSpacing);
}
function add_calculations_text_razao($section, $motivacao_razao, $motivacao_razao_content, $expressao_razao, $expressao_razao_content, $impressao_razao, $impressao_razao_content) {
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240, 'lineHeight' => '1.2em']; // alinhamento dos textos
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação do subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000']; // formatação dos dados do ACF e dos Funções do Sistema

    $section->addText("Motivação", $paragraphStyle2);
    $section->addText("Mostra o que a Empresa ou Negócio busca no mercado. É a alma do negócio. É muito importante que este número seja compatível com a área de atuação da Empresa ou Negócio.",$paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de Motivação - $motivacao_razao: $motivacao_razao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addText("Expressão", $paragraphStyle2);
    $section->addText("Revela a ação da Empresa ou Negócio no mercado; como se relaciona com seus clientes. Este número deve ser compatível com o fluxo de clientes para a Empresa ou Negócio.",$paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de Expressão - $expressao_razao: $expressao_razao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addText("Impressão", $paragraphStyle2);
    $section->addText("É como a Empresa ou Negócio é visto pelo cliente, pelo consumidor e pelo mercado de modo geral. Deve ser um número compatível com a área de atuação da Empresa/Negócio ou pelo menos que seja compatível com a atividade desenvolvida para que o consumidor a reconheça e a visualize.",$paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de Impressão - $impressao_razao: $impressao_razao_content", $paragraphStyle3, $paragraphStyleWithSpacing);

}
function add_text_desafios($section, $resultado_desafios_empresarial)
{
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $paragraphStyle4 = ['name' => 'Arial', 'size' => 12, 'color' => '#ED1C24']; // orientacao
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação do subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000']; // formatação dos dados do ACF e dos Funções do Sistema

    $section->addText("Desafio", $paragraphStyle2);
    $section->addText("Revela qual será o Destino do Empresa/Negócio com suas influências positivas ou negativas. É a meta na qual a Empresa/Negócio se propõe.",$paragraphStyle, $paragraphStyleWithSpacing);
    $section->addTextBreak(1);

    // Percorre os desafios e adiciona ao documento
    foreach ($resultado_desafios_empresarial as $desafio) {
        if (isset($desafio['numero']) && isset($desafio['descricao'])) {
            $section->addText("Desafio " . $desafio['numero'], $paragraphStyleNumber);
            $section->addText($desafio['descricao'], $paragraphStyle3, $paragraphStyleJustify);
            $section->addTextBreak(1);
            $section->addText("Orientação: ". $desafio['orentacao'], $paragraphStyle4, $paragraphStyleJustify);
            $section->addTextBreak(1); // Adiciona um espaço entre os desafios
        }
    }
}
function add_text_destiny_mission_section($section, $destino, $destino_empresarial_content, $missao, $missao_empresarial_content) {

    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic'=>  true]; // formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação do subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000']; // formatação dos dados

    $section->addText("Destino", $paragraphStyle2);
    $section->addText("Este é um dos números mais importantes do Mapa Numerológico. Ele descreve as influências na personalidade, oportunidades e os obstáculos que uma empresa irá encontrar ao longo da sua existência. Indica, ainda, as alternativas disponíveis e o provável resultado de cada uma delas. ", $paragraphStyle,$paragraphStyleWithSpacing);
    $section->addText("Destino - $destino: $destino_empresarial_content ", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addText("Missão", $paragraphStyle2);
    $section->addText("A missão empresarial vai além de metas comerciais e estratégias de mercado — ela representa o propósito essencial da empresa no mundo, o porquê de sua existência sob uma perspectiva energética e espiritual. Cada empresa carrega uma vibração específica determinada pelo nome empresarial e sua data de fundação. Esses elementos, ao serem convertidos em números por meio da tabela cabalística, revelam a Missão Empresarial, também conhecida como Número de Destino. Esse número indica o caminho que a empresa deve trilhar para se alinhar com seu verdadeiro propósito e obter sucesso duradouro.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Missão - $missao: $missao_empresarial_content", $paragraphStyle3, $paragraphStyleWithSpacing);
}
function add_energies_section($section, $dias_favoraveis, $numeros_harmonicos)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic'=> true]; // formatação da descrição
    $paragraphStyleJustify = ['alignment' => Jc::BOTH];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000'];
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número

    // dias favoraveis
    $section->addText("Números Harmônicos " ,$paragraphStyle2);
    $section->addTextBreak(1);
    $section->addText("Revelam quais são os números que você possui harmonia, sendo bastante uteis para verificar contas bancárias, sociedades, números de telefone, etc. .",$paragraphStyle, $paragraphStyleJustify );
    $section->addTextBreak(1);

    if (is_array($numeros_harmonicos)) {
        $section->addText(join(", ", $numeros_harmonicos), $paragraphStyle3);
    } else {
        $section->addText($numeros_harmonicos, $paragraphStyle3);
    }
    // numeros harmonicos
    $section->addTextBreak(1);
    $section->addText("Dias Favoráveis "  ,$paragraphStyle2);
    $section->addText("São considerados os seus “dias da sorte”, sendo favoráveis para realizar coisas importantes. Porém, é importante checar se o mês e o ano pessoal também se encontram favoráveis à determinadas situações.",$paragraphStyle, $paragraphStyleJustify );
    $section->addTextBreak(1);
    if (is_array($dias_favoraveis)) {
        $section->addText(join(", ", $dias_favoraveis), $paragraphStyle3);
    } else {
        $section->addText($dias_favoraveis, $paragraphStyle3);
    }
    // Verifica se $numeros_harmonicos é um array
//    if (is_array($numeros_harmonicos)) {
//        foreach ($numeros_harmonicos as $harmonico) {
//            if (isset($harmonico['numero_numeros_harmonicos']) && isset($harmonico['texto_numeros_harmonicos'])) {
//                // Adiciona o número com estilo específico
//                $section->addText("Numero Harmônico " . $harmonico['numero_numeros_harmonicos'], $paragraphStyleNumber);
//                // Adiciona o texto com o estilo apropriado
//                $section->addText($harmonico['texto_numeros_harmonicos'], $paragraphStyle3, $paragraphStyleJustify);
//                // Adiciona uma quebra de linha
//                $section->addTextBreak(1);
//            }
//        }
//    } else {
//        $section->addText("Nenhum número harmônico disponível.", $paragraphStyle3);
//    }
    $section->addTextBreak(1);
}
function add_text_cycles_content_section($section)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];

    $section->addText("Ciclos da Vida", $paragraphStyle2);
    $section->addText("São os 3 grandes ciclos aos quais a empresa sofrerá influência ao longo da existencia. O primeiro ciclo é o nascimento da empresa, onde são construídas as bases e definidas as direções iniciais, com foco na formação da identidade. O segundo ciclo marca o amadurecimento, uma fase de expansão e consolidação, exigindo equilíbrio e estratégias sólidas. O terceiro ciclo representa a colheita e o legado, momento de máxima realização e de deixar uma marca duradoura no mercado. Cada fase é guiada por vibrações numéricas que orientam o crescimento e o propósito da organização.", $paragraphStyle, $paragraphStyleWithSpacing);
}
//function add_cycles_text_section($section, $ciclos)
//{
//    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000']; // formatação dos dados
//
//    if (!empty($ciclos)) {
//        $ciclos_text = []; // Array para armazenar os números dos ciclos
//
//        foreach ($ciclos['ciclos'] as $dados_ciclo) {
//            $ciclos_text[] = $dados_ciclo['numero']; // Adicionar o número ao array
//        }
//
//        // Juntar os números em uma única string, separados por vírgula
//        $ciclos_concatenados = implode(' , ', $ciclos_text);
//
//        // Adicionar o texto ao documento
//        $section->addText("Números dos Ciclos Empresarial: {$ciclos_concatenados}", $paragraphStyle3);
//    }
//}
function add_cycles($section, $ciclos)
{
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true];
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000'];

    if (!empty($ciclos) && is_array($ciclos)) {
        $dataNascimento = null; // Para guardar a data de nascimento (início do primeiro ciclo)

        foreach ($ciclos as $index => $dados_ciclo) {
            $titulo = $dados_ciclo['ciclo'] ?? 'Ciclo Desconhecido';
            $numero = $dados_ciclo['numero'] ?? '-';
            $periodo = $dados_ciclo['periodo'] ?? 'Período não informado';
            $texto = $dados_ciclo['texto'] ?? '';

            // Extrair datas do período
            if (preg_match('/(\d{1,2}-\d{1,2}-\d{4})\s*-\s*(\d{1,2}-\d{1,2}-\d{4})/', $periodo, $matches)) {
                $inicio = \DateTime::createFromFormat('d-m-Y', $matches[1]);
                $fim = \DateTime::createFromFormat('d-m-Y', $matches[2]);

                if ($inicio && $fim) {
                    if (!$dataNascimento) {
                        $dataNascimento = clone $inicio; // Define a data de nascimento como a do primeiro ciclo
                    }

                    // Calcular idade no início do ciclo
                    $idadeInicio = $dataNascimento->diff($inicio);
                    $idadeInicioTexto = "{$idadeInicio->y} anos";
                    if ($idadeInicio->m > 0) {
                        $idadeInicioTexto .= " e {$idadeInicio->m} meses";
                    }

                    // Calcular idade no fim do ciclo
                    $idadeFim = $dataNascimento->diff($fim);
                    $idadeFimTexto = "{$idadeFim->y} anos";
                    if ($idadeFim->m > 0) {
                        $idadeFimTexto .= " e {$idadeFim->m} meses";
                    }

                    // Adiciona os textos ao documento
                    $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
                    $section->addText("Período: {$periodo} - Início {$idadeInicioTexto} e Fim {$idadeFimTexto}", $paragraphStyle);
                    //$section->addText("Início do período: {$idadeInicioTexto}", $paragraphStyle);
                    //$section->addText("Fim do período: {$idadeFimTexto}", $paragraphStyle);
                    $section->addTextBreak(1);
                    $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
                } else {
                    // Erro no formato de data
                    $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
                    $section->addText("Período: {$periodo} ", $paragraphStyle);
                    $section->addTextBreak(1);
                    $section->addText("Formato de data inválido", $paragraphStyle, $paragraphStyleWithSpacing);
                }
            } else {
                // Período fora do formato esperado
                $section->addText("{$titulo} - Número {$numero}", 'Heading3Style');
                $section->addText("Período: {$periodo}", $paragraphStyle);
                $section->addTextBreak(1);
                $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
            }

            $section->addText('');
        }
    }
}
function add_moment($section, $textos_momentos)
{
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240];
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; //formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000']; // formatação dos dados
    $paragraphStyleNumber = ['name' => 'Arial', 'size' => 12, 'bold' => true, 'color' => '000000']; // Formatação do número
    $paragraphStyle4 = ['name' => 'Arial', 'size' => 10, 'color' => 'D2122E', 'italic' => true]; //formatação da descrição



    $section->addText("Momentos Decisivos", $paragraphStyle2);
    $section->addText("A vida de uma empresa é marcada por quatro momentos decisivos, que indicam fases de mudanças importantes, oportunidades e desafios. Cada momento é calculado a partir da data de fundação da empresa e revela tendências que precisam ser compreendidas e bem aproveitadas para o sucesso e longevidade do negócio.", $paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("ATENÇÃO: Verifique se tem alguma relação dos números abaixo com o seu Momento Decisivo. Motivação: 1 - Expressão: 11 - Destino: 11",$paragraphStyle4, $paragraphStyleWithSpacing );
    $section->addTextBreak(1);
    // Itera sobre os momentos decisivos e adiciona o número e texto correspondentes
    $count = 0;
    foreach ($textos_momentos as $momento) {
        $numero = $momento['numero'];
        $texto = $momento['texto'];
        $count++;
        if($count == 1){
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("É o início da trajetória. Representa a formação, a identidade e os primeiros aprendizados da empresa. Nessa fase, os desafios estão ligados à estruturação, definição de propósito e primeiros passos no mercado. É o momento de plantar as bases sólidas para o futuro.",$paragraphStyle, $paragraphStyleWithSpacing );
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        }elseif ($count == 2) {
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("Fase de crescimento e consolidação. Aqui a empresa já possui alguma estabilidade, mas também precisa lidar com expansão, concorrência e amadurecimento dos processos internos. As escolhas feitas aqui são fundamentais para determinar a direção que o negócio seguirá.",$paragraphStyle, $paragraphStyleWithSpacing );
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        }elseif($count == 3) {
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("É o auge do ciclo. A empresa atinge sua plena capacidade, colhendo os frutos dos investimentos e esforços anteriores. É o período ideal para ampliar projetos, fortalecer a marca e explorar novas oportunidades. Também é uma fase de responsabilidade e liderança no mercado.",$paragraphStyle, $paragraphStyleWithSpacing );
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        }elseif($count == 4) {
            $section->addText(" $count º Momento Decisivo: $numero", $paragraphStyleNumber);
            $section->addText("Marca a fase de transformação ou encerramento de um ciclo. Pode ser o momento de renovação, sucessão ou até reestruturação profunda. O foco aqui é garantir a continuidade, inovar para se adaptar às novas exigências ou, em alguns casos, preparar uma transição honrosa.",$paragraphStyle, $paragraphStyleWithSpacing );
            $section->addText($texto, $paragraphStyle3, $paragraphStyleWithSpacing);
        }else{
            echo "Erro";
        }
    }
    $section->addTextBreak(1);
}
function add_fantasia_section($section, $nome_fantasia) {
    $titleStyle = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C'];
    $section->addText("Nome Fantasia da Empresa: $nome_fantasia", $titleStyle);
    $section->addTextBreak(1);
}
function add_calculations_text_fantasia($section, $motivacao_razao, $motivacao_razao_content, $expressao_razao, $expressao_razao_content, $impressao_razao, $impressao_razao_content) {
    $paragraphStyleWithSpacing = ['align' => 'both', 'spaceAfter' => 240, 'lineHeight' => '1.2em']; // alinhamento dos textos
    $paragraphStyle = ['name' => 'Arial', 'size' => 10, 'color' => '333333', 'italic' => true]; // formatação da descrição
    $paragraphStyle2 = ['name' => 'Arial', 'size' => 14, 'bold' => true, 'color' => '2C0A5C']; // formatação do subtitulo
    $paragraphStyle3 = ['name' => 'Arial', 'size' => 12, 'color'=> '000000']; // formatação dos dados do ACF e dos Funções do Sistema

    $section->addText("Motivação", $paragraphStyle2);
    $section->addText("Mostra o que a Empresa ou Negócio busca no mercado. É a alma do negócio. É muito importante que este número seja compatível com a área de atuação da Empresa ou Negócio.",$paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de Motivação - $motivacao_razao: $motivacao_razao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addText("Expressão", $paragraphStyle2);
    $section->addText("Revela a ação da Empresa ou Negócio no mercado; como se relaciona com seus clientes. Este número deve ser compatível com o fluxo de clientes para a Empresa ou Negócio.",$paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de Expressão - $expressao_razao: $expressao_razao_content", $paragraphStyle3, $paragraphStyleWithSpacing);
    $section->addText("Impressão", $paragraphStyle2);
    $section->addText("É como a Empresa ou Negócio é visto pelo cliente, pelo consumidor e pelo mercado de modo geral. Deve ser um número compatível com a área de atuação da Empresa/Negócio ou pelo menos que seja compatível com a atividade desenvolvida para que o consumidor a reconheça e a visualize.",$paragraphStyle, $paragraphStyleWithSpacing);
    $section->addText("Número de Impressão - $impressao_razao: $impressao_razao_content", $paragraphStyle3, $paragraphStyleWithSpacing);

}
add_action('template_redirect', 'download_empresarial_docx');
