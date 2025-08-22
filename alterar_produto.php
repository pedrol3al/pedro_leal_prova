<?php
session_start();
require_once("conexao.php");

// VERIFICA SE O USUARIO TEM PERMISSAO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

// INICIALIZA VARIAVEL
$produto = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['busca_produto'])) {
        $busca = trim($_POST['busca_produto']);

        // VERIFICA SE A BUSCA É UM NÚMERO (id) OU UM NOME
        if (is_numeric($busca)) {
            $sql = "SELECT * FROM produto WHERE id_produto = :busca_produto";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':busca_produto', $busca, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM produto WHERE nome_prod LIKE :busca_nome_prod";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':busca_nome_prod', "%$busca%", PDO::PARAM_STR);
        }
        
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se o usuário não for encontrado, exibe um alerta
        if (!$produto) {
            echo "<script>alert('Produto não encontrado!');</script>";
        }
    }
}
?>

<?php include("menu.php"); ?> 

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar produto</title>
    <link rel="stylesheet" href="styles.css">


    <!-- CERTIFIQUE-SE DE QUE O JAVASCRIPT ESTÁ SENDO CARREGADO CORRETAMENTE -->
    <script src="scripts.js"></script>
</head>

<body>
    <h2 class="title">Alterar produto</h2>

    <form action="alterar_produto.php" method="POST">
        <label for="busca_produto">Digite o id ou nome do produto</label>
        <input type="text" id="busca_produto" name="busca_produto" required onkeyup="buscarSugestoes()">

        <!-- DIV PARA EXIBIR SUGESTOES DE PRODUTOS -->
        <div id="sugestoes"></div>
        <button type="submit">Buscar</button>
    </form>

    <?php if ($produto): ?>
        <!-- FORMULARIO PARA ALTERAR USUARIO -->
        <form action="processa_alteracao_produto.php" method="POST">
            <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto['id_produto']) ?>">

            <label for="nome_prod">Nome:</label>
            <input type="text" id="nome_prod" name="nome_prod" value="<?= htmlspecialchars($produto['nome_prod']) ?>" required>

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="<?= htmlspecialchars($produto['descricao']) ?>" required>

            <label for="qtde">Quantidade:</label>
            <input type="number" id="qtde" name="qtde" value="<?= htmlspecialchars($produto['qtde']) ?>" required>

            <label for="valor_unit">Valor unitário:</label>
            <input type="number" id="valor_unit" name="valor_unit" value="<?= htmlspecialchars($produto['valor_unit']) ?>" required>


            <button type="submit">Alterar</button>

        </form>
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
