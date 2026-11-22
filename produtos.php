<?php
include ("conexao.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];

    $sql = "INSERT INTO produtos (nome, quantidade, preco) VALUES ('$nome', '$quantidade', '$preco')";

    if ($conexao->query($sql) === TRUE) {
        echo "<p style='color: green;'>Produto cadastrado com sucesso!</p>";
    } else {
        echo "Erro: " . $sql . "<br>" . $conexao->error;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Registar Produto - Logística</title>
</head>
<body>
    <h2>Registar Novo Produto</h2>
    <form method="POST" action="">
        <label>Nome do Produto:</label><br>
        <input type="text" name="nome" required><br><br>
        
        <label>Quantidade:</label><br>
        <input type="number" name="quantidade" required><br><br>
        
        <label>Preço:</label><br>
        <input type="number" step="0.01" name="preco" required><br><br>
        
        <button type="submit">Guardar Produto</button>
    </form>
</body>
</html>