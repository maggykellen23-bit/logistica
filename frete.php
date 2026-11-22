<?php
include "conexao.php";

$freteGerado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transportador = trim($_POST['transportador'] ?? '');
    $origem = trim($_POST['origem'] ?? '');
    $destino = trim($_POST['destino'] ?? '');
    $produtos = $_POST['produto_nome'] ?? [];
    $quantidades = $_POST['produto_qtd'] ?? [];

    $itens = [];
    for ($i = 0; $i < count($produtos); $i++) {
        $nomeProd = trim($produtos[$i] ?? '');
        $qtdProd = (int) ($quantidades[$i] ?? 0);
        if ($nomeProd !== '' && $qtdProd > 0) {
            $itens[] = [
                'nome' => $nomeProd,
                'qtd' => $qtdProd
            ];
        }
    }

    if ($transportador !== '' && $origem !== '' && $destino !== '' && count($itens) > 0) {
        $freteGerado = [
            'transportador' => $transportador,
            'origem' => $origem,
            'destino' => $destino,
            'itens' => $itens
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Gerar Frete</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 650px; margin: 30px auto; padding: 15px; }
    .campo { margin-bottom: 12px; }
    label { display: block; font-weight: bold; margin-bottom: 4px; }
    input { width: 100%; padding: 8px; box-sizing: border-box; }
    .linha-produto { display: flex; gap: 10px; margin-bottom: 8px; }
    .linha-produto input:first-child { flex: 2; }
    .linha-produto input:last-child { flex: 1; }
    button { padding: 10px 16px; cursor: pointer; margin-top: 8px; }
    .resultado { margin-top: 20px; padding: 15px; border: 1px solid #333; background: #f4f4f4; }
  </style>
</head>
<body>
  <h2>Gerar Frete</h2>

  <form method="POST">
    <div class="campo">
      <label for="transportador">Transportador:</label>
      <input type="text" id="transportador" name="transportador" required placeholder="Ex: Transportadora Rápida">
    </div>

    <div class="campo">
      <label for="origem">Endereço de Origem:</label>
      <input type="text" id="origem" name="origem" required placeholder="Ex: Rua A, 100 - Centro">
    </div>

    <div class="campo">
      <label for="destino">Endereço de Destino:</label>
      <input type="text" id="destino" name="destino" required placeholder="Ex: Av. Brasil, 500 - Industrial">
    </div>

    <div class="campo">
      <label>Produtos do Frete:</label>
      <div id="lista-produtos">
        <div class="linha-produto">
          <input type="text" name="produto_nome[]" required placeholder="Nome do produto (ex: Teclado)">
          <input type="number" name="produto_qtd[]" min="1" required placeholder="Qtd (ex: 10)">
        </div>
      </div>
      <button type="button" onclick="adicionarProduto()">+ Adicionar outro produto</button>
    </div>

    <button type="submit">Gerar Frete</button>
  </form>

  <?php if ($freteGerado): ?>
    <div class="resultado">
      <h3>Frete gerado com sucesso!</h3>
      <p><strong>Transportador:</strong> <?php echo htmlspecialchars($freteGerado['transportador']); ?></p>
      <p><strong>Origem:</strong> <?php echo htmlspecialchars($freteGerado['origem']); ?></p>
      <p><strong>Destino:</strong> <?php echo htmlspecialchars($freteGerado['destino']); ?></p>
      <p><strong>Produtos vinculados:</strong></p>
      <ul>
        <?php foreach ($freteGerado['itens'] as $item): ?>
          <li><?php echo htmlspecialchars($item['nome']); ?> — Quantidade: <?php echo (int) $item['qtd']; ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <script>
    function adicionarProduto() {
      const container = document.getElementById('lista-produtos');
      const div = document.createElement('div');
      div.className = 'linha-produto';
      div.innerHTML = `
        <input type="text" name="produto_nome[]" required placeholder="Nome do produto">
        <input type="number" name="produto_qtd[]" min="1" required placeholder="Qtd">
      `;
      container.appendChild(div);
    }
  </script>
</body>
</html>