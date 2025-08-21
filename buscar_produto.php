<?php
session_start();
require_once("conexao.php");

//VERIFICA SE O USUARIO TEM PERMISSAO DE adm OU secretaria]
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 2 && $_SESSION['perfil'] != 3 && $_SESSION['perfil'] != 4) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

$produtos = []; //INICIALIZA A VARIAVEL PARA EVITAR ERROS

//SE O FORMULARIO FOR ENVIADO, BUSCA O USUARIO PELO ID OU NOME
if ($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST['busca'])) {
    $busca = trim($_POST['busca']);

    //VERIFICA SE A BUSCA É UM NUMERO OU NOME
    if (is_numeric($busca)) {
        $sql = "SELECT * FROM produto WHERE id_produto = :busca ORDER BY nome_prod ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':busca', $busca, PDO::PARAM_INT);
    } else {
        $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca ORDER BY nome_prod ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':busca', "%$busca%", PDO::PARAM_STR);
    }

} else {
    $sql = "SELECT * FROM produto ORDER BY nome_prod ASC";
    $stmt = $pdo->prepare($sql);
}
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de funcionarios</title>
    <link rel="stylesheet" href="style_prod.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>

    <h2 class="text-center">Lista de Usuários</h2>

    <form action="buscar_produto.php" method="POST" >
        <label for="busca">Digite o ID ou NOME(opcional): </label>
        <input type="text" id="busca" name="busca">
        <button type="submit">Pesquisar</button>
    </form>

    <?php if (!empty($produtos)): ?>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Nome Produto</th>
                <th>Descrição</th>
                <th>Quantidade</th>
                <th>Valor unitário</th>
            </tr>

            <?php foreach ($produtos as $produto): ?>

                <tr>
                    <td><?= htmlspecialchars($produto['nome_prod']) ?> </td>
                    <td><?= htmlspecialchars($produto['descricao']) ?> </td>
                    <td><?= htmlspecialchars($produto['qtde']) ?> </td>
                    <td><?= htmlspecialchars($produto['valor_unit']) ?> </td>
                    <td>
                        <a href="alterar_produto.php?id=<?= htmlspecialchars($produto['id_produto']) ?>">Alterar</a>
                        <a href="excluir_produto.php?id=<?= htmlspecialchars($produto['id_produto']) ?>"
                            onclick="return confirm('Tem certeza que você deseja excluir esse usuário?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Nenhum produto encontrado.</p>
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