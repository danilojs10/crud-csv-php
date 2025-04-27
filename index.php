<?php
$arquivo = 'dados.csv';
$dados = [];

if (file_exists($arquivo)) {
    $dados = array_map(function($linha) {
        return str_getcsv($linha, ';');
    }, file($arquivo));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Controle de Refeições</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="container my-4">
  <h2>Nova Refeição</h2>
  <form action="salvar.php" method="POST" class="row g-3">
    <div class="col-md-6">
      <label for="data" class="form-label">Data</label>
      <input type="date" name="data" id="data" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label for="refeicao" class="form-label">Refeição</label>
      <select name="refeicao" id="refeicao" class="form-select" required>
        <option value="Cafe da Manha">Café da Manhã</option>
        <option value="Almoço">Almoço</option>
        <option value="Lanche da tarde">Lanche da Tarde</option>
        <option value="Jantar">Jantar</option>
      </select>
    </div>
    <div class="col-12">
      <label for="alimentos" class="form-label">Alimentos</label>
      <textarea name="alimentos" id="alimentos" class="form-control" rows="3"></textarea>
    </div>
    <div class="col-md-4">
      <label for="calorias" class="form-label">Calorias</label>
      <div class="input-group">
        <input type="number" name="calorias" id="calorias" class="form-control" required>
        <span class="input-group-text">kcal</span>
      </div>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Salvar</button>
    </div>
  </form>
</div>



<div class="container my-4">
  <h2>Refeições Registradas</h2>
  <div class="table-responsive">
    <table class="table table-sm table-striped table-bordered table-hover">
      <thead class="table-primary"> <!-- cabeçalho azul -->
        <tr>
          <th>Data</th>
          <th>Refeição</th>
          <th>Alimentos</th>
          <th>Calorias</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($dados as $index => $linha): ?>
          <?php if (count($linha) >= 4): ?>
            <?php
            $data_brasileira = '';
            if (!empty($linha[0])) {
                $data_obj = DateTime::createFromFormat('Y-m-d', $linha[0]);
                if ($data_obj) {
                    $data_brasileira = $data_obj->format('d/m/Y');
                }
            }
            ?>
            <tr>
              <td><?= htmlspecialchars($data_brasileira) ?></td>
              <td><?= htmlspecialchars($linha[1]) ?></td>
              <td><?= htmlspecialchars($linha[2]) ?></td>
              <td><?= htmlspecialchars($linha[3]) ?></td>
              <td>
                <a href="editar.php?id=<?= $index ?>" class="btn btn-sm btn-warning">Editar</a>
                <a href="deletar.php?id=<?= $index ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</a>
              </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>



</body>
</html>
