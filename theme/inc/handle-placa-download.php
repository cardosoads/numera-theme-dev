<?php
include_once get_template_directory() . '/helpers/docx-download.php';

function download_placa_docx()
{
    if (isset($_GET['download_placa_docx'])) {
        $phpWord = start_php_word_docx();

        // Cria uma nova seção no documento
        $section = $phpWord->addSection();
       
        $section->addText(get_the_title(), 'TitleStyle', 'TitleAlign');

        // Adiciona o conteúdo do post
        $section->addText(get_the_content(), 'ParagraphStyle', 'ParagraphAlign');

        // ADICIONAR O CONTEÚDO DO MAPA AQUI
        $section->addText('PRECISA TRAZER O CONTEÚDO PARA O DOCUMENTO!!!', 'ParagraphStyle', 'ParagraphAlign');

        send_php_word_docx($phpWord, 'analise_placa');
    }
}

add_action('template_redirect', 'download_placa_docx');
