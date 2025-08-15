<?php
session_start();
require_once("conexao.php");

// VERIFICA SE O USUARIO TEM PERMISSAO DE ADM
if ($_SESSION['perfil'] != 1) {
    echo "<script>alert('Acesso negado!');window.location.href='principal.php'</script>";
    exit();
}

//INICIALIZA VARIAVEL PARA ARMAZENAR USUARIOS
$usuarios = [];

//BUSCA TODOS OS USUÁRIOS CADASTRADOS EM ORDEM ALFABETICA
$sql = "SELECT * FROM usuario ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

//SE UM ID FOR PASSADO VIA GET, EXCLUI O USUARIO
if (isset($_GET['id']) && is_numeric(trim($_GET['id']))) {
    $id_usuario = $_GET['id'];

    //EXCLUI O USUARIO DO BANCO DE DADOS
    $sql = "DELETE FROM usuario WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "<script>alert('Usuário excluido com sucesso!');window.location.href='excluir_usuario.php'</script>";
    } else {
        echo "<script>alert('Não foi possível excluir o usuário!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excuir usuário</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <h2 class="text-center">Excluir funcionário</h2>

    <?php if (!empty($usuarios)): ?>
        <table class="table">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['id_usuario']) ?></td>
                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['id_perfil']) ?></td>
                    <td>
                        <a href="excluir_usuario.php?id=<?= htmlspecialchars($usuario['id_usuario']) ?>"
                            onclick="return confirm('Tem certeza que deseja excluir esse usuário?')">
                            Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <p>Nenhum usuário encontrado</p>
    <?php endif; ?>

    <div class="text-center">
        <a href="principal.php">Retornar</a>
    </div>

    <address class="text-center">Trabalho desenvolvido pelo aluno Pedro Gabriel | Técnico Dev Sistemas</address>
</body>

</html>