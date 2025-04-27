<?php
$arquivo = 'dados.csv';

$dados = file_exists($arquivo) ? array_map(function($linha) {
    return str_getcsv($linha, ';');
}, file($arquivo)) : [];

$id = $_GET['id'] ?? null;

if ($id !== null && isset($dados[$id])) {
    unset($dados[$id]);
    $dados = array_values($dados);

    $handle = fopen($arquivo, 'w');
    foreach ($dados as $linha) {
        fputcsv($handle, $linha, ';');
    }
    fclose($handle);
}

header('Location: index.php');
exit;
