<?php
$arquivo = 'dados.csv';

$data = $_POST['data'] ?? '';
$refeicao = $_POST['refeicao'] ?? '';
$alimentos = $_POST['alimentos'] ?? '';
$calorias = $_POST['calorias'] ?? '';

// Corrigir quebras de linha no alimentos
$alimentos = str_replace(["\r\n", "\r", "\n"], ' ', $alimentos);

// Formatar calorias
$calorias = trim($calorias) . ' kcal';

if ($data && $refeicao && $alimentos && $calorias) {
    $handle = fopen($arquivo, 'a');
    fputcsv($handle, [$data, $refeicao, $alimentos, $calorias], ';');
    fclose($handle);
}

header('Location: index.php');
exit;
