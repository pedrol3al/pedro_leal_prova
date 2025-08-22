<?php
session_start();
require_once("conexao.php");

// VERIFICA SE O USUARIO TEM PERMISSAO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

//INICIALIZA VARIAVEL PARA ARMAZENAR PRODUTOS
$produtos = [];

//BUSCA TODOS OS USUÁRIOS CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * FROM produto ORDER BY nome_prod ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SE UM ID FOR PASSADO VIA GET, EXCLUI O PRODUTO
if (isset($_GET['id']) && is_numeric(trim($_GET['id']))) {
    $id_produto = $_GET['id'];

    //EXCLUI O PRODUTO DO BANCO DE DADOS
    $sql = "DELETE FROM produto WHERE id_produto = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_produto, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "<script>alert('Produto excluido com sucesso!');window.location.href='excluir_produto.php'</script>";
    } else {
        echo "<script>alert('Não foi possível excluir o produto!');</script>";
    }
}

?>

<?php include("menu.php"); ?> 


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excuir produto</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <h2 class="text-center">Excluir produto</h2>

    <?php if (!empty($produtos)): ?>
        <table class="custom-table">
            <tr>
                <th>Id Produto</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Valor Unitario</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= htmlspecialchars($produto['id_produto']) ?></td>
                    <td><?= htmlspecialchars($produto['nome_prod']) ?></td>
                    <td><?= htmlspecialchars($produto['descricao']) ?></td>
                    <td><?= htmlspecialchars($produto['qtde']) ?></td>
                    <td><?= htmlspecialchars($produto['valor_unit']) ?></td>
                    <td>
                        <a href="excluir_produto.php?id=<?= htmlspecialchars($produto['id_produto']) ?>"
                            onclick="return confirm('Tem certeza que deseja excluir esse produto?')">
                            Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p>Nenhum produto encontrado</p>
    <?php endif; ?>

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