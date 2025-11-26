<?php
include_once __DIR__ . "/Numerologia.php";
include_once __DIR__ . "/NumerologiaDados.php";
include_once __DIR__ . "/NumerologiaCalculos.php";
// Recupera todos os metadados do endereço na query
$post_meta = get_post_meta(get_the_ID());

if ($post_meta !== "") {
    $cep = $post_meta['cep'][0];
    $endereco = $post_meta['endereco'][0];
    $numero = $post_meta['numero'][0];
    $complemento = $post_meta['complemento'][0];
}

$rua = $endereco;

$post_meta = NULL;

$numerologia = new Numerologia();

$endereco_options = get_field('vibracoes_endereco', 'option');

$calculo_endereco = $numerologia->calcularEndereco($numero, $endereco, $complemento ?? null);
$calculo_casa = $numerologia->calcularNumeroCasa($numero);

$texto_endereco = [];
foreach ($endereco_options as $endereco) {
        if ($endereco["numero_vibracao"] == $calculo_endereco) {
            $texto_endereco[] = $endereco["texto_vibracao"];
        }
}
$texto_casa = [];
foreach ($endereco_options as $endereco) {
    if ($endereco["numero_vibracao"] == $calculo_casa) {
        $texto_casa[] = $endereco["texto_vibracao"];
    }
}
//echo '<pre>';
//var_dump($texto_casa);
//echo '</pre>';
//die();