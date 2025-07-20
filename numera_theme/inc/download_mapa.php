<?php
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
function gerar_mapa()
{
    require get_template_directory() . '/inc/template-single-mapa-functions.php';

    if ($_GET['action'] !== 'gerar_mapa') {
        return;
    }

    $phpWord = new PhpWord();

    $section = $phpWord->addSection();

    // Adiciona um texto simples à seção
    $section->addText('Este é um documento Word gerado automaticamente com um texto simples.');

    // Define o nome do arquivo
    $fileName = 'mapa_' . time() . '.docx';
    $filePath = sys_get_temp_dir() . '/' . $fileName;

    // Salva o documento temporariamente
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filePath);

    // Define os headers para download
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Pragma: public');

    flush();
    readfile($filePath);

    unlink($filePath); // Remove o arquivo temporário
    exit;
}

// Registra a ação para usuários autenticados e visitantes
add_action('admin_post_gerar_mapa', 'gerar_mapa');
add_action('admin_post_nopriv_gerar_mapa', 'gerar_mapa');
