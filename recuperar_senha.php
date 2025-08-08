<?php
session_start();
require_once("conexao.php");
require_once("funcoes_email.php"); //ARQUIVO COM AS FUNÇÕES QUE GERAM A SENHA E SIMULAM O ENVIO 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    //VERIFICA SE O EMAIL EXISTE NO BANCO DE DADOS
    $sql = "SELECT * FROM usuario WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam("email", $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        //GERA UMA SENHA TEMPORARIA
        $senha_temporaria = gerarSenhaTemporaria();
        $senha_hash = password_hash($senha_temporaria, PASSWORD_DEFAULT);

        //ATUALIZA A SENHA DO USUARIO NO BANCO
        $sql = "UPDATE usuario SET senha = :senha, senha_temporaria = TRUE WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':senha', $senha_hash);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        //SIMULA O ENVIO DO EMAIL (GRAVA TXT)
        simularEnvioEmail($email, $senha_temporaria);
        echo "<script>alert('Uma senha temporaria foi gerada e enviada (Simulação). Verifique o arquivo email_simulados.txt');window.location.href='login.php';</script>";

    } else {
        echo "<script>alert('Email não encontrado!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h2>Recuperar Senha</h2>
    <form action="recuperar_senha.php" method="PALTOST">
        <label for="email">Digite o seu e-mail cadastrado:</label>
        <input type="email" name="email" id="email" required>

        <button type="submit">Enviar a Senha Temporaria </button>
    </form>

</body>

</html>