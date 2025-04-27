<?php
$arquivo = 'dados.csv';

$dados = file_exists($arquivo) ? array_map(function($linha) {
    return str_getcsv($linha, ';');
}, file($arquivo)) : [];

$id = $_GET['id'] ?? null;

if ($id === null || !isset($dados[$id])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'] ?? '';
    $refeicao = $_POST['refeicao'] ?? '';
    $alimentos = $_POST['alimentos'] ?? '';
    $calorias = $_POST['calorias'] ?? '';

    $alimentos = str_replace(["\r\n", "\r", "\n"], ' ', $alimentos);
    $calorias = trim($calorias) . ' kcal';

    if ($data && $refeicao && $alimentos && $calorias) {
        $dados[$id] = [$data, $refeicao, $alimentos, $calorias];

        $handle = fopen($arquivo, 'w');
        foreach ($dados as $linha) {
            fputcsv($handle, $linha, ';');
        }
        fclose($handle);

        header('Location: index.php');
        exit;
    }
}

// Separar o número da palavra 'kcal' para mostrar no formulário:
$calorias_numero = str_replace(' kcal', '', $dados[$id][3]);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Refeição</title>
</head>
<body>

<h2>Editar Refeição</h2>

<form action="" method="POST">
    <p>Data: <input type="date" name="data" value="<?= htmlspecialchars($dados[$id][0]) ?>" required></p>
    <p>Refeição: 
        <select name="refeicao" id="refeicao">
            <option value="Cafe da Manha" <?= $dados[$id][1] == 'Cafe da Manha' ? 'selected' : '' ?>>Café da Manhã</option>
            <option value="Almoço" <?= $dados[$id][1] == 'Almoço' ? 'selected' : '' ?>>Almoço</option>
            <option value="Lanche da tarde" <?= $dados[$id][1] == 'Lanche da tarde' ? 'selected' : '' ?>>Lanche da Tarde</option>
            <option value="Jantar" <?= $dados[$id][1] == 'Jantar' ? 'selected' : '' ?>>Jantar</option>
        </select>
    </p>
    <p>Alimentos: <textarea name="alimentos" id="alimentos"><?= htmlspecialchars($dados[$id][2]) ?></textarea></p>
    <p>Calorias: <input type="number" name="calorias" value="<?= htmlspecialchars($calorias_numero) ?>" required> kcal</p>
    <button type="submit">Atualizar</button>
</form>

<a href="index.php">Voltar</a>

</body>
</html>
