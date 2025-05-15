<?php

function start_php_word_docx()
{
    $phpWord = new \PhpOffice\PhpWord\PhpWord();
    $phpWord->addFontStyle('TitleStyle', array('name' => 'Arial Unicode MS', 'size' => 16, 'bold' => true, 'color' => '000000'));
    $phpWord->addFontStyle('Heading2Style', array('name' => 'Arial Unicode MS', 'size' => 14, 'bold' => true, 'color' => '000000'));
    $phpWord->addFontStyle('Heading3Style', array('name' => 'Arial Unicode MS', 'size' => 12, 'bold' => true, 'color' => '000000'));
    $phpWord->addFontStyle('ParagraphStyle', array('name' => 'Arial Unicode MS', 'size' => 12, 'color' => '000000'));
    $phpWord->addFontStyle('ParagraphStyleBold', array('name' => 'Arial Unicode MS', 'size' => 12, 'bold' => true,  'color' => '000000'));
    $phpWord->addParagraphStyle('TitleAlign', array('align' => 'left', 'spaceAfter' => 300));
    $phpWord->addParagraphStyle('ParagraphAlign', array('align' => 'left', 'spaceAfter' => 200));

    return $phpWord;
}

function send_php_word_docx($phpWord, $docTitle)
{
    $fileName = $docTitle . "_" . get_the_ID() . '.docx';
    $filePath = sys_get_temp_dir() . '/' . $fileName;

    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filePath);

    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Pragma: public');

    flush();
    readfile($filePath);

    unlink($filePath);
    exit;
}
