<?php
session_start();
require_once("conexao.php");

if ($_SESSION['perfil'] != 1 || $_SESSION['perfil'] != 3) {

} else {
    echo "Acesso negado!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_prod = $_POST["nome_prod"];
    $descricao = $_POST["descricao"];
    $qtde = $_POST["qtde"];
    $valor_unit = $_POST["valor_unit"];

    $sql = "INSERT INTO produto (nome_prod, descricao, qtde, valor_unit) VALUES (:nome_prod,:descricao,:qtde,:valor_unit)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('nome_prod', $nome_prod, );
    $stmt->bindParam('descricao', $descricao, );
    $stmt->bindParam('qtde', $qtde, PDO::PARAM_STR);
    $stmt->bindParam('valor_unit', $valor_unit, PDO::PARAM_STR);

    if ($stmt->execute()) {
        echo "<script>alert('Produto cadastrado com sucesso!')</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar produto!')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Produto</title>
    <link rel="stylesheet" href="style_prod.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <script scr="validacoes_prod.js"></script>

</head>

<body>

    <h2 class="text-center">Cadastrar Produto</h2>
    <form action="cadastro_produto.php" method="POST">
        <label for="nome_prod">Nome do produto:</label>
        <input type="text" name="nome_prod" id="nome_prod" class="form-control" required>

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" class="form-control" required>

        <label for="qdte">Quantidade:</label>
        <input type="number" name="qtde" id="qtde" class="form-control" required>

        <label for="valor_unit">Valor unidade:</label>
        <input type="number" name="valor_unit" id="valor_unit" class="form-control" required>
        <br>

        <button type="submit"> Salvar </button>
        <br>
        <button type="reset"> Cancelar </button>
    </form>

    <div class="text-center">
        <a href="principal.php" class="btn-voltar">
            <button type="button">
                Voltar
            </button>
        </a>
    </div>

    <address class="text-center">Trabalho desenvolvido pelo aluno Pedro Gabriel | Técnico Dev Sistemas</address>
</body>

</html>